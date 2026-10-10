<?php
declare(strict_types=1);

require_once __DIR__ . "/../includes/init.php";
admin_require_login();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    admin_json(["ok" => false, "message" => "Method not allowed."], 405);
}

$allowed = ["phone", "whatsapp", "email", "address", "facebook", "instagram", "linkedin"];
$pdo = admin_pdo();
$stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (:key, :value) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)");

foreach ($allowed as $key) {
    $value = admin_clean((string)($_POST[$key] ?? ""));
    $stmt->execute([":key" => $key, ":value" => $value]);
}

admin_json(["ok" => true, "message" => "Settings saved successfully."]);
