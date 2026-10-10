<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/init.php";
admin_require_login();

$pdo = admin_pdo();
$about = $pdo->query("SELECT * FROM about_content WHERE id = 1 LIMIT 1")->fetch();
if (!$about) {
    $about = [
        "who_we_are" => "",
        "experience_text" => "",
        "mission" => "",
        "vision" => "",
        "strengths" => "",
    ];
}

$adminPageTitle = "About Page Management";
$activeMenu = "about";
include __DIR__ . "/includes/header.php";
?>
<section class="neo-card p-6">
  <h2 class="text-xl font-semibold">Edit About Page Content</h2>
  <form id="aboutForm" class="mt-5 grid gap-4">
    <div>
      <label class="text-sm font-medium">Who is Prestigee Events</label>
      <textarea name="who_we_are" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-3 h-24" required><?php echo htmlspecialchars((string)$about["who_we_are"], ENT_QUOTES, "UTF-8"); ?></textarea>
    </div>
    <div>
      <label class="text-sm font-medium">Your Experience</label>
      <textarea name="experience_text" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-3 h-24" required><?php echo htmlspecialchars((string)$about["experience_text"], ENT_QUOTES, "UTF-8"); ?></textarea>
    </div>
    <div>
      <label class="text-sm font-medium">Mission</label>
      <textarea name="mission" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-3 h-24" required><?php echo htmlspecialchars((string)$about["mission"], ENT_QUOTES, "UTF-8"); ?></textarea>
    </div>
    <div>
      <label class="text-sm font-medium">Vision</label>
      <textarea name="vision" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-3 h-24" required><?php echo htmlspecialchars((string)$about["vision"], ENT_QUOTES, "UTF-8"); ?></textarea>
    </div>
    <div>
      <label class="text-sm font-medium">Strengths</label>
      <textarea name="strengths" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-3 h-28" required><?php echo htmlspecialchars((string)$about["strengths"], ENT_QUOTES, "UTF-8"); ?></textarea>
    </div>
    <div>
      <button class="rounded-xl bg-peNavy text-white px-5 py-2.5 text-sm">Save About Content</button>
    </div>
  </form>
</section>
<?php include __DIR__ . "/includes/footer.php"; ?>
