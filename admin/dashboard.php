<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/init.php";
admin_require_login();

$pdo = admin_pdo();
$counts = [
    "services" => (int)$pdo->query("SELECT COUNT(*) FROM services")->fetchColumn(),
    "portfolio" => (int)$pdo->query("SELECT COUNT(*) FROM portfolio")->fetchColumn(),
    "quotes" => (int)$pdo->query("SELECT COUNT(*) FROM quotes")->fetchColumn(),
    "messages" => (int)$pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn(),
];

$latestQuotes = $pdo->query("SELECT id, name, event_type, created_at, is_contacted FROM quotes ORDER BY id DESC LIMIT 5")->fetchAll();
$latestMessages = $pdo->query("SELECT id, name, subject, created_at FROM messages ORDER BY id DESC LIMIT 5")->fetchAll();

$adminPageTitle = "Dashboard";
$activeMenu = "dashboard";
include __DIR__ . "/includes/header.php";
?>
<section class="grid sm:grid-cols-2 xl:grid-cols-4 gap-4">
  <article class="neo-card p-5 bg-gradient-to-br from-peMint/50 to-white">
    <p class="text-sm text-slate-600">Total Services</p>
    <h2 class="text-3xl font-bold mt-2"><?php echo $counts["services"]; ?></h2>
  </article>
  <article class="neo-card p-5 bg-gradient-to-br from-peLavender/50 to-white">
    <p class="text-sm text-slate-600">Total Portfolio</p>
    <h2 class="text-3xl font-bold mt-2"><?php echo $counts["portfolio"]; ?></h2>
  </article>
  <article class="neo-card p-5 bg-gradient-to-br from-peCoral/25 to-white">
    <p class="text-sm text-slate-600">Total Quotes</p>
    <h2 class="text-3xl font-bold mt-2"><?php echo $counts["quotes"]; ?></h2>
  </article>
  <article class="neo-card p-5 bg-gradient-to-br from-peGreen/25 to-white">
    <p class="text-sm text-slate-600">Total Messages</p>
    <h2 class="text-3xl font-bold mt-2"><?php echo $counts["messages"]; ?></h2>
  </article>
</section>

<section class="mt-6 grid xl:grid-cols-2 gap-6">
  <article class="neo-card p-5">
    <h3 class="font-semibold text-lg">Recent Quote Requests</h3>
    <div class="mt-4 overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead>
          <tr class="text-left text-slate-500 border-b">
            <th class="py-2 pr-3">Name</th>
            <th class="py-2 pr-3">Event</th>
            <th class="py-2 pr-3">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($latestQuotes as $row): ?>
            <tr class="border-b border-slate-100">
              <td class="py-2 pr-3"><?php echo htmlspecialchars($row["name"], ENT_QUOTES, "UTF-8"); ?></td>
              <td class="py-2 pr-3"><?php echo htmlspecialchars($row["event_type"], ENT_QUOTES, "UTF-8"); ?></td>
              <td class="py-2 pr-3">
                <span class="inline-flex px-2 py-1 rounded-full text-xs <?php echo ((int)$row["is_contacted"] === 1) ? "bg-emerald-100 text-emerald-700" : "bg-amber-100 text-amber-700"; ?>">
                  <?php echo ((int)$row["is_contacted"] === 1) ? "Contacted" : "Pending"; ?>
                </span>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </article>

  <article class="neo-card p-5">
    <h3 class="font-semibold text-lg">Recent Messages</h3>
    <div class="mt-4 overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead>
          <tr class="text-left text-slate-500 border-b">
            <th class="py-2 pr-3">Name</th>
            <th class="py-2 pr-3">Subject</th>
            <th class="py-2 pr-3">Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($latestMessages as $row): ?>
            <tr class="border-b border-slate-100">
              <td class="py-2 pr-3"><?php echo htmlspecialchars($row["name"], ENT_QUOTES, "UTF-8"); ?></td>
              <td class="py-2 pr-3"><?php echo htmlspecialchars($row["subject"], ENT_QUOTES, "UTF-8"); ?></td>
              <td class="py-2 pr-3"><?php echo htmlspecialchars((string)$row["created_at"], ENT_QUOTES, "UTF-8"); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </article>
</section>
<?php include __DIR__ . "/includes/footer.php"; ?>
