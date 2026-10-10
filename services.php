<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/db.php";

$pageTitle = "Professional Event Services | Prestigee Events";
$pageDescription = "Explore our comprehensive event management services - corporate events, luxury celebrations, brand experiences, and more. Professional event planning & execution.";
$activePage = "services";

$pdo = prestigee_db();
$pdo->exec(
    "CREATE TABLE IF NOT EXISTS services (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(150) NOT NULL,
        category VARCHAR(120) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
);

$serviceRows = $pdo->query("SELECT title, category FROM services ORDER BY id ASC")->fetchAll();

$flatGroups = [];
$nestedGroups = [];

foreach ($serviceRows as $row) {
    $title = trim((string)($row["title"] ?? ""));
    if ($title === "") {
        continue;
    }

    $category = trim((string)($row["category"] ?? "Other Services"));
    if ($category === "") {
        $category = "Other Services";
    }

    if (strpos($category, " - ") !== false) {
        [$parent, $subCategory] = array_map("trim", explode(" - ", $category, 2));
        $parent = $parent !== "" ? $parent : "Other Services";
        $subCategory = $subCategory !== "" ? $subCategory : "General";
        $nestedGroups[$parent][$subCategory][] = $title;
        continue;
    }

    $flatGroups[$category][] = $title;
}


include __DIR__ . "/includes/header.php";
?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "Prestigee Events",
  "description": "<?php echo htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8'); ?>",
  "url": "https://prestigeeevents.com/services.php",
  "serviceType": ["Corporate Events", "Luxury Events", "Event Planning", "Brand Experiences"]
}
</script>

<section class="pt-32 pb-16 px-4 md:px-8">
  <div class="max-w-7xl mx-auto">
    <div class="glass neu-shadow rounded-3xl p-8 md:p-10 border border-white/10 reveal">
      <p class="text-gold-400 uppercase tracking-[0.18em] text-xs">Our Expertise</p>
      <h1 class="mt-4 text-4xl md:text-6xl font-bold leading-tight">Services</h1>
      <p class="mt-4 text-white/70 max-w-3xl">Premium event solutions with brochure-accurate categories, presented in a cleaner visual hierarchy.</p>
    </div>

    <?php foreach ($flatGroups as $groupName => $items): ?>
      <div class="mt-8 glass neu-shadow rounded-3xl p-7 md:p-9 border border-white/10 reveal">
        <div class="flex items-center gap-3 flex-wrap">
          <h2 class="text-2xl md:text-3xl font-bold text-gold-400"><?php echo htmlspecialchars($groupName, ENT_QUOTES, "UTF-8"); ?></h2>
          <span class="px-3 py-1 rounded-full text-xs border border-gold-400/40 text-gold-300 bg-gold-500/10">
            <?php echo count($items); ?> Services
          </span>
        </div>
        <ul class="mt-6 grid sm:grid-cols-2 xl:grid-cols-3 gap-3 text-sm">
          <?php foreach ($items as $item): ?>
            <li class="rounded-xl border border-white/10 bg-black/30 px-4 py-3 text-white/85 hover:border-gold-400/60 hover:text-white transition">
              <?php echo htmlspecialchars($item, ENT_QUOTES, "UTF-8"); ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endforeach; ?>

    <?php foreach ($nestedGroups as $parentName => $subGroups): ?>
      <div class="mt-8 glass neu-shadow rounded-3xl p-7 md:p-9 border border-white/10 reveal">
        <div class="flex items-center gap-3 flex-wrap">
          <h2 class="text-2xl md:text-3xl font-bold text-gold-400"><?php echo htmlspecialchars($parentName, ENT_QUOTES, "UTF-8"); ?></h2>
          <span class="px-3 py-1 rounded-full text-xs border border-gold-400/40 text-gold-300 bg-gold-500/10">
            <?php echo count($subGroups); ?> Categories
          </span>
        </div>

        <div class="mt-7 grid lg:grid-cols-2 xl:grid-cols-3 gap-5">
          <?php foreach ($subGroups as $subCategory => $items): ?>
            <article class="rounded-2xl border border-white/10 bg-black/30 p-5 hover:border-gold-400/60 transition">
              <h3 class="text-lg font-semibold text-gold-300"><?php echo htmlspecialchars($subCategory, ENT_QUOTES, "UTF-8"); ?></h3>
              <ul class="mt-4 space-y-2 text-sm">
                <?php foreach ($items as $item): ?>
                  <li class="text-white/85 leading-relaxed">
                    <span class="text-gold-400 mr-2">•</span><?php echo htmlspecialchars($item, ENT_QUOTES, "UTF-8"); ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>

    <?php if ($serviceRows === []): ?>
      <div class="mt-8 glass neu-shadow rounded-3xl p-7 md:p-9 border border-white/10 reveal text-center text-white/70">
        No services added yet. Please add services from the Admin panel.
      </div>
    <?php endif; ?>

    <div class="mt-8 text-center reveal">
      <a href="quote.php" class="btn-glow inline-flex px-7 py-3 rounded-xl bg-gold-500 text-black font-semibold shadow-glow">Get Quote</a>
    </div>
  </div>
</section>
<?php include __DIR__ . "/includes/footer.php"; ?>
