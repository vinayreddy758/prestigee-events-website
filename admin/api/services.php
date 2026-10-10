<?php
declare(strict_types=1);

require_once __DIR__ . "/../includes/init.php";
admin_require_login();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int)($_POST["id"] ?? 0);
    $title = admin_clean((string)($_POST["title"] ?? ""));
    $category = admin_clean((string)($_POST["category"] ?? ""));

    if ($title === "" || $category === "") {
        admin_json(["ok" => false, "message" => "All fields are required."], 422);
    }

    $pdo = admin_pdo();
    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE services SET title = :title, category = :category WHERE id = :id");
        $stmt->execute([
            ":title" => $title,
            ":category" => $category,
            ":id" => $id,
        ]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO services (title, category) VALUES (:title, :category)");
        $stmt->execute([
            ":title" => $title,
            ":category" => $category,
        ]);
    }

    admin_json(["ok" => true, "message" => "Service saved successfully."]);
}

if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    parse_str((string)file_get_contents("php://input"), $payload);
    $id = (int)($payload["id"] ?? 0);
    if ($id <= 0) {
        admin_json(["ok" => false, "message" => "Invalid service id."], 422);
    }
    $stmt = admin_pdo()->prepare("DELETE FROM services WHERE id = :id");
    $stmt->execute([":id" => $id]);
    admin_json(["ok" => true, "message" => "Service deleted."]);
}

admin_json(["ok" => false, "message" => "Method not allowed."], 405);
