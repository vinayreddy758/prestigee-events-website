<?php
declare(strict_types=1);

require_once __DIR__ . "/../includes/init.php";
admin_require_login();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    admin_json(["ok" => false, "message" => "Method not allowed."], 405);
}

$who = admin_clean((string)($_POST["who_we_are"] ?? ""));
$exp = admin_clean((string)($_POST["experience_text"] ?? ""));
$mission = admin_clean((string)($_POST["mission"] ?? ""));
$vision = admin_clean((string)($_POST["vision"] ?? ""));
$strengths = admin_clean((string)($_POST["strengths"] ?? ""));

if ($who === "" || $exp === "" || $mission === "" || $vision === "" || $strengths === "") {
    admin_json(["ok" => false, "message" => "All about fields are required."], 422);
}

$stmt = admin_pdo()->prepare(
    "UPDATE about_content
     SET who_we_are = :who, experience_text = :exp, mission = :mission, vision = :vision, strengths = :strengths
     WHERE id = 1"
);
$stmt->execute([
    ":who" => $who,
    ":exp" => $exp,
    ":mission" => $mission,
    ":vision" => $vision,
    ":strengths" => $strengths,
]);

admin_json(["ok" => true, "message" => "About content saved."]);
