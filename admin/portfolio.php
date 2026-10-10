<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/init.php";
admin_require_login();

$pdo = admin_pdo();
$q = admin_clean((string)($_GET["q"] ?? ""));
$stmt = $pdo->prepare(
    "SELECT id, title, category, image_url, created_at
     FROM portfolio
     WHERE (:q = '' OR title LIKE :term_title OR category LIKE :term_category)
     ORDER BY id DESC"
);
$term = "%" . $q . "%";
$stmt->execute([
    ":q" => $q,
    ":term_title" => $term,
    ":term_category" => $term,
]);
$portfolio = $stmt->fetchAll();

$toAdminImageSrc = static function (string $url): string {
    $url = trim($url);
    if ($url === "") {
        return "";
    }
    if (preg_match("/^https?:/i", $url) === 1) {
        return $url;
    }
    if (str_starts_with($url, "/assets/")) {
        return ".." . $url;
    }
    if (str_starts_with($url, "/admin/")) {
        return ".." . $url;
    }
    if (str_starts_with($url, "assets/") || str_starts_with($url, "admin/")) {
        return "../" . $url;
    }
    if (str_starts_with($url, "uploads/")) {
        return "../admin/" . $url;
    }
    return $url;
};

$adminPageTitle = "Portfolio Management";
$activeMenu = "portfolio";
include __DIR__ . "/includes/header.php";
?>
<section class="neo-card p-5">
  <div class="flex flex-wrap items-center gap-3 justify-between">
    <form class="flex items-center gap-2">
      <input name="q" value="<?php echo htmlspecialchars($q, ENT_QUOTES, "UTF-8"); ?>" placeholder="Search portfolio..." class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-peMint">
      <button class="rounded-xl bg-peGreen text-white px-4 py-2.5 text-sm">Search</button>
    </form>
    <button data-open-modal="portfolioModal" class="rounded-xl bg-peNavy text-white px-4 py-2.5 text-sm">Add Portfolio</button>
  </div>

  <div class="mt-5 overflow-x-auto">
    <table class="min-w-full text-sm">
      <thead>
        <tr class="text-left text-slate-500 border-b">
          <th class="py-3 pr-3">Image</th>
          <th class="py-3 pr-3">Title</th>
          <th class="py-3 pr-3">Category</th>
          <th class="py-3 pr-3">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($portfolio as $row): ?>
          <?php
          $rawImageUrl = (string)$row["image_url"];
          $adminImageSrc = $toAdminImageSrc($rawImageUrl);
          ?>
          <tr class="border-b border-slate-100">
            <td class="py-3 pr-3">
              <img src="<?php echo htmlspecialchars($adminImageSrc, ENT_QUOTES, "UTF-8"); ?>" alt="" class="w-16 h-12 object-cover rounded-lg border border-slate-200">
            </td>
            <td class="py-3 pr-3"><?php echo htmlspecialchars($row["title"], ENT_QUOTES, "UTF-8"); ?></td>
            <td class="py-3 pr-3"><?php echo htmlspecialchars($row["category"], ENT_QUOTES, "UTF-8"); ?></td>
            <td class="py-3 pr-3">
              <div class="flex items-center gap-2">
                <button
                  class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs"
                  data-open-modal="portfolioModal"
                  data-id="<?php echo (int)$row["id"]; ?>"
                  data-title="<?php echo htmlspecialchars($row["title"], ENT_QUOTES, "UTF-8"); ?>"
                  data-category="<?php echo htmlspecialchars($row["category"], ENT_QUOTES, "UTF-8"); ?>"
                  data-image_url="<?php echo htmlspecialchars($rawImageUrl, ENT_QUOTES, "UTF-8"); ?>"
                  data-image_preview="<?php echo htmlspecialchars($adminImageSrc, ENT_QUOTES, "UTF-8"); ?>"
                >Edit</button>
                <button class="rounded-lg bg-red-100 text-red-700 px-3 py-1.5 text-xs" data-delete-portfolio="<?php echo (int)$row["id"]; ?>">Delete</button>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>

<div id="portfolioModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
  <div class="absolute inset-0 bg-black/40" data-close-modal></div>
  <div class="relative bg-white w-full max-w-xl rounded-2xl p-6 shadow-xl">
    <h3 class="text-xl font-semibold mb-4">Portfolio Item</h3>
    <form id="portfolioForm" class="space-y-4" enctype="multipart/form-data">
      <input type="hidden" name="id" id="portfolioId">
      <div>
        <label class="text-sm font-medium">Title</label>
        <input name="title" id="portfolioTitle" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-3" required>
      </div>
      <div>
        <label class="text-sm font-medium">Category</label>
        <input name="category" id="portfolioCategory" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-3" required>
      </div>
      <div>
        <label class="text-sm font-medium">Image URL</label>
        <input type="url" name="image_url" id="portfolioImageUrl" placeholder="https://example.com/image.jpg" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-3">
        <p class="mt-1 text-xs text-slate-500">Use either Image URL or Upload Image. If both are provided, uploaded image will be used.</p>
      </div>
      <div>
        <label class="text-sm font-medium">Upload Image</label>
        <input type="file" name="image" id="portfolioImage" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-3" accept="image/*">
        <img id="portfolioPreview" src="" alt="" class="mt-3 w-32 h-20 object-cover rounded-lg border border-slate-200 hidden">
      </div>
      <div class="flex items-center justify-end gap-2">
        <button type="button" class="rounded-xl border border-slate-200 px-4 py-2.5" data-close-modal>Cancel</button>
        <button class="rounded-xl bg-peNavy text-white px-4 py-2.5">Save</button>
      </div>
    </form>
  </div>
</div>
<?php include __DIR__ . "/includes/footer.php"; ?>
