<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/db.php";

$pageTitle = "Event Portfolio | Prestigee Events - Corporate & Luxury Event Showcase";
$pageDescription = "Explore our portfolio of premium corporate events, luxury celebrations, and brand experiences. See our past successful events.";

$portfolioItems = [];
$pdo = prestigee_db();
$pdo->exec(
    "CREATE TABLE IF NOT EXISTS portfolio (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(180) NOT NULL,
        category VARCHAR(120) NOT NULL,
        image_url VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
);
$portfolioItems = $pdo->query("SELECT title, image_url FROM portfolio ORDER BY id DESC")->fetchAll();

$resolveImageUrl = static function (string $url): string {
    $url = trim($url);
    if ($url === "") {
        return "";
    }
    if (preg_match("/^https?:\/\//i", $url) === 1 || str_starts_with($url, "/")) {
        if (str_starts_with($url, "/assets/") || str_starts_with($url, "/admin/")) {
            return ltrim($url, "/");
        }
        return $url;
    }
    if (str_starts_with($url, "admin/uploads/")) {
        return $url;
    }
    if (str_starts_with($url, "uploads/")) {
        return "admin/" . $url;
    }
    if (str_starts_with($url, "assets/images/")) {
        return $url;
    }
    return $url;
};

if ($portfolioItems === []) {
    $portfolioItems = [
        ["title" => "Annual Gala Night", "image_url" => "https://images.unsplash.com/photo-1519741497674-611481863552?auto=format&fit=crop&w=1200&q=80"],
        ["title" => "Product Launch Experience", "image_url" => "https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=1200&q=80"],
        ["title" => "Executive Summit", "image_url" => "https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?auto=format&fit=crop&w=1200&q=80"],
        ["title" => "Destination Celebration", "image_url" => "https://images.unsplash.com/photo-1478146896981-b80fe463b330?auto=format&fit=crop&w=1200&q=80"],
        ["title" => "Live Entertainment Night", "image_url" => "https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=1200&q=80"],
        ["title" => "Luxury Wedding Production", "image_url" => "https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?auto=format&fit=crop&w=1200&q=80"],
    ];
}

$activePage = "portfolio";
include __DIR__ . "/includes/header.php";
?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "CollectionPage",
  "name": "Event Portfolio",
  "description": "<?php echo htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8'); ?>",
  "url": "https://prestigeeevents.com/portfolio.php"
}
</script>

<section class="pt-32 pb-16 px-4 md:px-8">
  <div class="max-w-6xl mx-auto">
    <h1 class="text-4xl md:text-5xl font-bold text-gold-400 reveal">Portfolio</h1>
    <p class="mt-4 text-white/70 max-w-2xl reveal">A cinematic selection of premium events, launches, and unforgettable hospitality moments.</p>
    <div class="mt-10 masonry-grid">
      <?php foreach ($portfolioItems as $item): ?>
        <?php $imageUrl = $resolveImageUrl((string)$item["image_url"]); ?>
        <article class="group relative mb-4 overflow-hidden rounded-2xl glass reveal" data-scroll-scale>
          <img src="<?php echo htmlspecialchars($imageUrl, ENT_QUOTES, "UTF-8"); ?>" alt="<?php echo htmlspecialchars((string)$item["title"], ENT_QUOTES, "UTF-8"); ?>" class="w-full h-auto object-cover transition duration-700 group-hover:scale-110" data-scroll-image>
          <div class="absolute inset-0 bg-black/15 group-hover:bg-black/55 transition duration-500"></div>
          <h3 class="absolute left-5 bottom-5 text-gold-300 font-semibold opacity-0 group-hover:opacity-100 transition duration-500"><?php echo htmlspecialchars((string)$item["title"], ENT_QUOTES, "UTF-8"); ?></h3>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php include __DIR__ . "/includes/footer.php"; ?>

