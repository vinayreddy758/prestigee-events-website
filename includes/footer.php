  </main>

<?php
$settingsMap = [
  "phone" => "",
  "whatsapp" => "",
  "email" => "",
  "address" => "",
  "facebook" => "",
  "instagram" => "",
  "linkedin" => "",
];

try {
  require_once __DIR__ . "/db.php";
  $pdo = prestigee_db();
  $pdo->exec(
    "CREATE TABLE IF NOT EXISTS settings (
      setting_key VARCHAR(80) PRIMARY KEY,
      setting_value TEXT NOT NULL,
      updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
     ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
  );

  $pdo->exec(
    "INSERT IGNORE INTO settings (setting_key, setting_value) VALUES
      ('phone', ''),
      ('whatsapp', ''),
      ('email', ''),
      ('address', ''),
      ('facebook', ''),
      ('instagram', ''),
      ('linkedin', '')"
  );

  $stmt = $pdo->query(
    "SELECT setting_key, setting_value
     FROM settings
     WHERE setting_key IN ('phone','whatsapp','email','address','facebook','instagram','linkedin')"
  );
  foreach ($stmt->fetchAll() as $row) {
    $key = (string)($row["setting_key"] ?? "");
    if (array_key_exists($key, $settingsMap)) {
      $settingsMap[$key] = trim((string)($row["setting_value"] ?? ""));
    }
  }
} catch (PDOException $e) {
  error_log("Footer settings load failed: " . $e->getMessage());
}

$phone = $settingsMap["phone"];
$email = $settingsMap["email"];
$address = $settingsMap["address"];
$phoneTel = preg_replace("/[^0-9+]/", "", $phone) ?? "";
$waDigits = preg_replace("/[^0-9]/", "", $settingsMap["whatsapp"]) ?? "";
$waLink = $waDigits !== "" ? "https://wa.me/" . $waDigits : "";

$normalizeUrl = static function (string $url): string {
  $url = trim($url);
  if ($url === "") {
    return "";
  }
  if (preg_match("~^https?://~i", $url) === 1) {
    return $url;
  }
  return "https://" . $url;
};

$facebookUrl = $normalizeUrl($settingsMap["facebook"]);
$instagramUrl = $normalizeUrl($settingsMap["instagram"]);
$linkedinUrl = $normalizeUrl($settingsMap["linkedin"]);
?>
<?php if ($waLink === "") { $waLink = "https://wa.me/"; } ?>
  <a
    href="<?php echo htmlspecialchars($waLink, ENT_QUOTES, "UTF-8"); ?>"
    target="_blank"
    rel="noopener noreferrer"
    class="fixed bottom-5 right-5 z-40 w-14 h-14 rounded-full glass flex items-center justify-center text-green-400 shadow-[0_0_20px_rgba(34,197,94,0.45)] transition hover:scale-105"
    aria-label="Chat on WhatsApp"
  >
    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
      <path d="M12.04 2C6.58 2 2.15 6.42 2.15 11.88c0 1.93.56 3.8 1.61 5.4L2 22l4.86-1.7a9.88 9.88 0 0 0 5.18 1.46h.01c5.46 0 9.89-4.42 9.89-9.88A9.88 9.88 0 0 0 12.04 2Zm0 18.08h-.01a8.2 8.2 0 0 1-4.16-1.13l-.3-.18-2.88 1 1-2.8-.2-.3a8.14 8.14 0 0 1-1.27-4.4c0-4.5 3.67-8.17 8.18-8.17a8.16 8.16 0 0 1 8.16 8.17 8.17 8.17 0 0 1-8.17 8.16Zm4.48-6.13c-.25-.12-1.47-.72-1.7-.8-.23-.08-.4-.12-.56.12-.17.25-.64.8-.79.97-.14.17-.29.19-.54.07-.25-.12-1.05-.39-2-1.25-.74-.66-1.24-1.47-1.39-1.72-.14-.24-.01-.37.11-.5.11-.11.25-.29.37-.43.12-.14.16-.25.25-.42.08-.17.04-.31-.02-.43-.06-.12-.56-1.35-.77-1.85-.2-.48-.4-.41-.56-.42h-.48c-.17 0-.43.06-.66.31-.23.25-.87.85-.87 2.07s.89 2.4 1.02 2.56c.12.17 1.75 2.67 4.23 3.75.59.26 1.05.41 1.4.53.59.19 1.12.16 1.54.1.47-.07 1.47-.6 1.67-1.19.21-.59.21-1.1.14-1.19-.06-.1-.23-.16-.48-.28Z"/>
    </svg>
  </a>

  <footer class="mt-20 border-t border-white/10">
    <div class="max-w-7xl mx-auto px-4 md:px-8 py-10 grid gap-8 md:grid-cols-3">
      <div>
        <p class="text-white text-lg font-semibold">Prestigee Events</p>
        <p class="mt-2 text-sm text-white/70">Premium event management for corporate and luxury experiences.</p>
      </div>

      <div>
        <p class="text-white font-medium">Contact</p>
        <div class="mt-3 space-y-2 text-sm text-white/75">
          <?php if ($phone !== ""): ?>
            <p><a class="hover:text-gold-400 transition" href="tel:<?php echo htmlspecialchars($phoneTel !== "" ? $phoneTel : $phone, ENT_QUOTES, "UTF-8"); ?>"><?php echo htmlspecialchars($phone, ENT_QUOTES, "UTF-8"); ?></a></p>
          <?php endif; ?>
          <?php if ($email !== ""): ?>
            <p><a class="hover:text-gold-400 transition" href="mailto:<?php echo htmlspecialchars($email, ENT_QUOTES, "UTF-8"); ?>"><?php echo htmlspecialchars($email, ENT_QUOTES, "UTF-8"); ?></a></p>
          <?php endif; ?>
          <?php if ($address !== ""): ?>
            <p><?php echo htmlspecialchars($address, ENT_QUOTES, "UTF-8"); ?></p>
          <?php endif; ?>
        </div>
      </div>

      <div>
        <p class="text-white font-medium">Social Media</p>
        <div class="mt-3 flex items-center gap-3">
          <<?php if ($facebookUrl !== ""): ?>a<?php else: ?>div<?php endif; ?> href="<?php echo $facebookUrl !== "" ? htmlspecialchars($facebookUrl, ENT_QUOTES, "UTF-8") : "#"; ?>" <?php if ($facebookUrl !== ""): ?>target="_blank" rel="noopener noreferrer"<?php endif; ?> aria-label="Facebook" class="h-10 w-10 rounded-full border <?php echo $facebookUrl !== "" ? "border-white/20 text-white/80 hover:text-gold-400 hover:border-gold-400/50 cursor-pointer" : "border-white/10 text-white/30 cursor-default"; ?> flex items-center justify-center transition">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 12.06C22 6.5 17.52 2 12 2S2 6.5 2 12.06c0 5.02 3.66 9.18 8.44 9.94v-7.03H7.9v-2.9h2.54V9.85c0-2.52 1.49-3.92 3.78-3.92 1.1 0 2.25.2 2.25.2v2.48h-1.27c-1.25 0-1.64.78-1.64 1.58v1.88h2.8l-.45 2.9h-2.35V22c4.78-.76 8.44-4.92 8.44-9.94Z"/></svg>
          </<?php if ($facebookUrl !== ""): ?>a<?php else: ?>div<?php endif; ?>>

          <<?php if ($instagramUrl !== ""): ?>a<?php else: ?>div<?php endif; ?> href="<?php echo $instagramUrl !== "" ? htmlspecialchars($instagramUrl, ENT_QUOTES, "UTF-8") : "#"; ?>" <?php if ($instagramUrl !== ""): ?>target="_blank" rel="noopener noreferrer"<?php endif; ?> aria-label="Instagram" class="h-10 w-10 rounded-full border <?php echo $instagramUrl !== "" ? "border-white/20 text-white/80 hover:text-gold-400 hover:border-gold-400/50 cursor-pointer" : "border-white/10 text-white/30 cursor-default"; ?> flex items-center justify-center transition">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2Zm0 1.8A3.95 3.95 0 0 0 3.8 7.75v8.5A3.95 3.95 0 0 0 7.75 20.2h8.5a3.95 3.95 0 0 0 3.95-3.95v-8.5a3.95 3.95 0 0 0-3.95-3.95h-8.5Zm8.85 1.35a1.1 1.1 0 1 1 0 2.2 1.1 1.1 0 0 1 0-2.2ZM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 1.8a3.2 3.2 0 1 0 0 6.4 3.2 3.2 0 0 0 0-6.4Z"/></svg>
          </<?php if ($instagramUrl !== ""): ?>a<?php else: ?>div<?php endif; ?>>

          <<?php if ($linkedinUrl !== ""): ?>a<?php else: ?>div<?php endif; ?> href="<?php echo $linkedinUrl !== "" ? htmlspecialchars($linkedinUrl, ENT_QUOTES, "UTF-8") : "#"; ?>" <?php if ($linkedinUrl !== ""): ?>target="_blank" rel="noopener noreferrer"<?php endif; ?> aria-label="LinkedIn" class="h-10 w-10 rounded-full border <?php echo $linkedinUrl !== "" ? "border-white/20 text-white/80 hover:text-gold-400 hover:border-gold-400/50 cursor-pointer" : "border-white/10 text-white/30 cursor-default"; ?> flex items-center justify-center transition">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.94 8.5A1.56 1.56 0 1 1 6.9 5.4a1.56 1.56 0 0 1 .04 3.1ZM5.5 9.8h2.85V19H5.5V9.8Zm4.5 0h2.73v1.26h.04c.38-.72 1.31-1.47 2.7-1.47 2.88 0 3.41 1.9 3.41 4.38V19h-2.84v-4.44c0-1.06-.02-2.43-1.48-2.43-1.48 0-1.71 1.16-1.71 2.36V19H10V9.8Z"/></svg>
          </<?php if ($linkedinUrl !== ""): ?>a<?php else: ?>div<?php endif; ?>>
        </div>
      </div>
    </div>

    <div class="border-t border-white/10">
      <div class="max-w-7xl mx-auto px-4 md:px-8 py-4 text-sm text-white/70 flex flex-col md:flex-row gap-2 md:items-center md:justify-between">
        <p>&copy; <?php echo date("Y"); ?> Prestigee Events. Premium Event Management.</p>
        <p class="text-gold-400/90">Crafting Luxury Experiences</p>
        <p><a href="https://anilkumar-seven.vercel.app/" target="_blank" rel="noopener noreferrer" class="text-gold-400/90 hover:text-gold-400 transition">Developed by 😎</a></p>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.42/dist/lenis.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>
</html>

