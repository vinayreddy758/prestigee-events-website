<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/init.php";
admin_require_login();

$pdo = admin_pdo();
$settings = $pdo->query("SELECT setting_key, setting_value FROM settings")->fetchAll();
$map = [];
foreach ($settings as $item) {
    $map[(string)$item["setting_key"]] = (string)$item["setting_value"];
}

$adminPageTitle = "Site Settings";
$activeMenu = "settings";
include __DIR__ . "/includes/header.php";
?>
<section class="neo-card p-6">
  <h2 class="text-xl font-semibold">Contact & Social Settings</h2>
  <form id="settingsForm" class="mt-5 grid md:grid-cols-2 gap-4">
    <div>
      <label class="text-sm font-medium">Phone</label>
      <input name="phone" value="<?php echo htmlspecialchars($map["phone"] ?? "", ENT_QUOTES, "UTF-8"); ?>" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-3">
    </div>
    <div>
      <label class="text-sm font-medium">WhatsApp</label>
      <input name="whatsapp" value="<?php echo htmlspecialchars($map["whatsapp"] ?? "", ENT_QUOTES, "UTF-8"); ?>" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-3">
    </div>
    <div>
      <label class="text-sm font-medium">Email</label>
      <input name="email" value="<?php echo htmlspecialchars($map["email"] ?? "", ENT_QUOTES, "UTF-8"); ?>" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-3">
    </div>
    <div>
      <label class="text-sm font-medium">Address</label>
      <input name="address" value="<?php echo htmlspecialchars($map["address"] ?? "", ENT_QUOTES, "UTF-8"); ?>" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-3">
    </div>
    <div>
      <label class="text-sm font-medium">Facebook</label>
      <input name="facebook" value="<?php echo htmlspecialchars($map["facebook"] ?? "", ENT_QUOTES, "UTF-8"); ?>" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-3">
    </div>
    <div>
      <label class="text-sm font-medium">Instagram</label>
      <input name="instagram" value="<?php echo htmlspecialchars($map["instagram"] ?? "", ENT_QUOTES, "UTF-8"); ?>" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-3">
    </div>
    <div class="md:col-span-2">
      <label class="text-sm font-medium">LinkedIn</label>
      <input name="linkedin" value="<?php echo htmlspecialchars($map["linkedin"] ?? "", ENT_QUOTES, "UTF-8"); ?>" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-3">
    </div>
    <div class="md:col-span-2">
      <button class="rounded-xl bg-peNavy text-white px-5 py-2.5 text-sm">Save Settings</button>
    </div>
  </form>
</section>
<?php include __DIR__ . "/includes/footer.php"; ?>
