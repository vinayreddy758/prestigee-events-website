<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/init.php";
admin_require_login();

$pdo = admin_pdo();
$q = admin_clean((string)($_GET["q"] ?? ""));
$page = max(1, (int)($_GET["page"] ?? 1));
$perPage = 10;
$offset = ($page - 1) * $perPage;

$countStmt = $pdo->prepare("SELECT COUNT(*) FROM quotes WHERE (:q = '' OR name LIKE :term_name OR email LIKE :term_email OR event_type LIKE :term_event)");
$term = "%" . $q . "%";
$countStmt->execute([
    ":q" => $q,
    ":term_name" => $term,
    ":term_email" => $term,
    ":term_event" => $term,
]);
$total = (int)$countStmt->fetchColumn();
$pages = max(1, (int)ceil($total / $perPage));

$stmt = $pdo->prepare(
    "SELECT id, name, company, phone, email, event_type, event_date, location, budget, message, is_contacted, created_at
     FROM quotes
     WHERE (:q = '' OR name LIKE :term_name OR email LIKE :term_email OR event_type LIKE :term_event)
     ORDER BY id DESC
     LIMIT :lim OFFSET :off"
);
$stmt->bindValue(":q", $q, PDO::PARAM_STR);
$stmt->bindValue(":term_name", $term, PDO::PARAM_STR);
$stmt->bindValue(":term_email", $term, PDO::PARAM_STR);
$stmt->bindValue(":term_event", $term, PDO::PARAM_STR);
$stmt->bindValue(":lim", $perPage, PDO::PARAM_INT);
$stmt->bindValue(":off", $offset, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll();

$adminPageTitle = "Quote Requests";
$activeMenu = "quotes";
include __DIR__ . "/includes/header.php";
?>
<section class="neo-card p-5">
  <div class="flex flex-wrap items-center gap-3 justify-between">
    <form class="flex items-center gap-2">
      <input name="q" value="<?php echo htmlspecialchars($q, ENT_QUOTES, "UTF-8"); ?>" placeholder="Search quotes..." class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-peMint">
      <button class="rounded-xl bg-peGreen text-white px-4 py-2.5 text-sm">Search</button>
    </form>
    <p class="text-sm text-slate-500">Total: <?php echo $total; ?></p>
  </div>

  <div class="mt-5 overflow-x-auto">
    <table class="min-w-full text-sm">
      <thead>
        <tr class="text-left text-slate-500 border-b">
          <th class="py-3 pr-3">Client</th>
          <th class="py-3 pr-3">Event</th>
          <th class="py-3 pr-3">Contact</th>
          <th class="py-3 pr-3">Status</th>
          <th class="py-3 pr-3">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row): ?>
          <tr class="border-b border-slate-100 align-top">
            <td class="py-3 pr-3">
              <p class="font-medium"><?php echo htmlspecialchars($row["name"], ENT_QUOTES, "UTF-8"); ?></p>
              <p class="text-xs text-slate-500"><?php echo htmlspecialchars($row["company"], ENT_QUOTES, "UTF-8"); ?></p>
            </td>
            <td class="py-3 pr-3">
              <p><?php echo htmlspecialchars($row["event_type"], ENT_QUOTES, "UTF-8"); ?></p>
              <p class="text-xs text-slate-500"><?php echo htmlspecialchars((string)$row["event_date"], ENT_QUOTES, "UTF-8"); ?></p>
            </td>
            <td class="py-3 pr-3">
              <p><?php echo htmlspecialchars($row["email"], ENT_QUOTES, "UTF-8"); ?></p>
              <p class="text-xs text-slate-500"><?php echo htmlspecialchars($row["phone"], ENT_QUOTES, "UTF-8"); ?></p>
            </td>
            <td class="py-3 pr-3">
              <span class="inline-flex px-2 py-1 rounded-full text-xs <?php echo ((int)$row["is_contacted"] === 1) ? "bg-emerald-100 text-emerald-700" : "bg-amber-100 text-amber-700"; ?>">
                <?php echo ((int)$row["is_contacted"] === 1) ? "Contacted" : "Pending"; ?>
              </span>
            </td>
            <td class="py-3 pr-3">
              <?php if ((int)$row["is_contacted"] === 0): ?>
                <button class="rounded-lg bg-peNavy text-white px-3 py-1.5 text-xs" data-contact-quote="<?php echo (int)$row["id"]; ?>">Mark Contacted</button>
              <?php endif; ?>
            </td>
          </tr>
          <tr class="border-b border-slate-100">
            <td colspan="5" class="py-3 px-3 bg-slate-50">
              <p class="text-xs font-semibold text-slate-600">Message:</p>
              <p class="text-sm text-slate-700 mt-1 whitespace-pre-wrap"><?php echo htmlspecialchars((string)$row["message"], ENT_QUOTES, "UTF-8"); ?></p>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="mt-4 flex items-center gap-2">
    <?php for ($i = 1; $i <= $pages; $i++): ?>
      <a href="?q=<?php echo urlencode($q); ?>&page=<?php echo $i; ?>" class="px-3 py-1.5 rounded-lg text-sm <?php echo $i === $page ? "bg-peNavy text-white" : "bg-slate-100 text-slate-700"; ?>">
        <?php echo $i; ?>
      </a>
    <?php endfor; ?>
  </div>
</section>
<?php include __DIR__ . "/includes/footer.php"; ?>
