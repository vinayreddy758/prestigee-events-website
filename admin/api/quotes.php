<?php
declare(strict_types=1);

require_once __DIR__ . "/../includes/init.php";
admin_require_login();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    admin_json(["ok" => false, "message" => "Method not allowed."], 405);
}

$id = (int)($_POST["id"] ?? 0);
if ($id <= 0) {
    admin_json(["ok" => false, "message" => "Invalid quote id."], 422);
}

$stmt = admin_pdo()->prepare("UPDATE quotes SET is_contacted = 1, contacted_at = NOW() WHERE id = :id");
$stmt->execute([":id" => $id]);
admin_json(["ok" => true, "message" => "Quote marked as contacted."]);
