<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/init.php";
admin_require_login();

$pdo = admin_pdo();
$q = admin_clean((string)($_GET["q"] ?? ""));
$page = max(1, (int)($_GET["page"] ?? 1));
$perPage = 10;
$offset = ($page - 1) * $perPage;

$countStmt = $pdo->prepare("SELECT COUNT(*) FROM messages WHERE (:q = '' OR name LIKE :term_name OR email LIKE :term_email OR subject LIKE :term_subject)");
$term = "%" . $q . "%";
$countStmt->execute([
    ":q" => $q,
    ":term_name" => $term,
    ":term_email" => $term,
    ":term_subject" => $term,
]);
$total = (int)$countStmt->fetchColumn();
$pages = max(1, (int)ceil($total / $perPage));

$stmt = $pdo->prepare(
    "SELECT id, name, email, phone, subject, message, created_at
     FROM messages
     WHERE (:q = '' OR name LIKE :term_name OR email LIKE :term_email OR subject LIKE :term_subject)
     ORDER BY id DESC
     LIMIT :lim OFFSET :off"
);
$stmt->bindValue(":q", $q, PDO::PARAM_STR);
$stmt->bindValue(":term_name", $term, PDO::PARAM_STR);
$stmt->bindValue(":term_email", $term, PDO::PARAM_STR);
$stmt->bindValue(":term_subject", $term, PDO::PARAM_STR);
$stmt->bindValue(":lim", $perPage, PDO::PARAM_INT);
$stmt->bindValue(":off", $offset, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll();

$adminPageTitle = "Contact Messages";
$activeMenu = "messages";
include __DIR__ . "/includes/header.php";
?>
<section class="neo-card p-5">
  <div class="flex flex-wrap items-center gap-3 justify-between">
    <form class="flex items-center gap-2">
      <input name="q" value="<?php echo htmlspecialchars($q, ENT_QUOTES, "UTF-8"); ?>" placeholder="Search messages..." class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-peMint">
      <button class="rounded-xl bg-peGreen text-white px-4 py-2.5 text-sm">Search</button>
    </form>
    <p class="text-sm text-slate-500">Total: <?php echo $total; ?></p>
  </div>

  <div class="mt-5 overflow-x-auto">
    <table class="min-w-full text-sm">
      <thead>
        <tr class="text-left text-slate-500 border-b">
          <th class="py-3 pr-3">Sender</th>
          <th class="py-3 pr-3">Contact</th>
          <th class="py-3 pr-3">Subject</th>
          <th class="py-3 pr-3">Message</th>
          <th class="py-3 pr-3">Date</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row): ?>
          <tr class="border-b border-slate-100 align-top">
            <td class="py-3 pr-3"><?php echo htmlspecialchars($row["name"], ENT_QUOTES, "UTF-8"); ?></td>
            <td class="py-3 pr-3">
              <p><?php echo htmlspecialchars($row["email"], ENT_QUOTES, "UTF-8"); ?></p>
              <p class="text-xs text-slate-500"><?php echo htmlspecialchars((string)$row["phone"], ENT_QUOTES, "UTF-8"); ?></p>
            </td>
            <td class="py-3 pr-3"><?php echo htmlspecialchars($row["subject"], ENT_QUOTES, "UTF-8"); ?></td>
            <td class="py-3 pr-3 max-w-sm"><?php echo nl2br(htmlspecialchars($row["message"], ENT_QUOTES, "UTF-8")); ?></td>
            <td class="py-3 pr-3"><?php echo htmlspecialchars((string)$row["created_at"], ENT_QUOTES, "UTF-8"); ?></td>
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
