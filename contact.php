<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/db.php";

$pageTitle = "Contact Prestigee Events | Get in Touch";
$pageDescription = "Contact us for premium event management services. Reach out via email, phone, or contact form.";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    header("Content-Type: application/json; charset=UTF-8");
    $name = trim((string)($_POST["name"] ?? ""));
    $email = trim((string)($_POST["email"] ?? ""));
    $phone = trim((string)($_POST["phone"] ?? ""));
    $subject = trim((string)($_POST["subject"] ?? ""));
    $message = trim((string)($_POST["message"] ?? ""));

    $errors = [];
    if ($name === "" || mb_strlen($name) < 2) {
        $errors["name"] = "Please enter valid name.";
    }
    if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Please enter valid email.";
    }
    if ($subject === "") {
        $errors["subject"] = "Subject is required.";
    }
    if ($message === "" || mb_strlen($message) < 8) {
        $errors["message"] = "Message should be at least 8 characters.";
    }

    if ($errors !== []) {
        http_response_code(422);
        echo json_encode(["ok" => false, "message" => "Please fix the highlighted fields.", "errors" => $errors]);
        exit;
    }

    try {
        $pdo = prestigee_db();
        ensure_messages_table($pdo);
        $stmt = $pdo->prepare("INSERT INTO messages (name, email, phone, subject, message) VALUES (:name, :email, :phone, :subject, :message)");
        $stmt->execute([
            ":name" => $name,
            ":email" => $email,
            ":phone" => $phone === "" ? null : $phone,
            ":subject" => $subject,
            ":message" => $message,
        ]);
        echo json_encode(["ok" => true, "message" => "Message sent successfully."]);
        exit;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["ok" => false, "message" => "Unable to send message right now."]);
        exit;
    }
}

$activePage = "contact";
include __DIR__ . "/includes/header.php";
?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ContactPage",
  "name": "Contact Prestigee Events",
  "description": "<?php echo htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8'); ?>",
  "url": "https://prestigeeevents.com/contact.php"
}
</script>

<section class="pt-32 pb-16 px-4 md:px-8">
  <div class="max-w-4xl mx-auto glass rounded-2xl p-8 reveal">
    <h1 class="text-4xl md:text-5xl font-bold text-gold-400">Contact</h1>
    <p class="mt-4 text-white/75">Let us design your next unforgettable event.</p>
    <div id="contactFeedback" class="hidden mt-6 rounded-xl px-4 py-3 text-sm"></div>
    <form id="contactForm" class="mt-8 grid gap-4">
      <input name="name" class="glass rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-gold-400/60 border border-transparent" placeholder="Name" required />
      <input type="email" name="email" class="glass rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-gold-400/60 border border-transparent" placeholder="Email" required />
      <input name="phone" class="glass rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-gold-400/60 border border-transparent" placeholder="Phone (optional)" />
      <input name="subject" class="glass rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-gold-400/60 border border-transparent" placeholder="Subject" required />
      <textarea name="message" class="glass rounded-xl px-4 py-3 h-32 outline-none focus:ring-2 focus:ring-gold-400/60 border border-transparent" placeholder="Message" required></textarea>
      <button id="contactSubmit" class="btn-glow w-fit px-6 py-3 rounded-xl bg-gold-500 text-black font-semibold" type="submit">Send Message</button>
    </form>
  </div>
</section>
<?php include __DIR__ . "/includes/footer.php"; ?>

