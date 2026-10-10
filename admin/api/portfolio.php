<?php
declare(strict_types=1);

require_once __DIR__ . "/../includes/init.php";
admin_require_login();

function upload_portfolio_image(array $file): string
{
    if (($file["error"] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        throw new RuntimeException("Image upload failed.");
    }
    if (($file["size"] ?? 0) > 5 * 1024 * 1024) {
        throw new RuntimeException("Image must be below 5MB.");
    }
    $tmp = (string)($file["tmp_name"] ?? "");
    $mime = mime_content_type($tmp);
    $allowed = [
        "image/jpeg" => "jpg",
        "image/png" => "png",
        "image/webp" => "webp",
        "image/gif" => "gif",
    ];
    if (!isset($allowed[$mime])) {
        throw new RuntimeException("Only JPG, PNG, GIF, WEBP are allowed.");
    }

    $dir = __DIR__ . "/../../assets/images/portfolio";
    if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
        throw new RuntimeException("Unable to create upload directory.");
    }
    $fileName = "portfolio_" . time() . "_" . bin2hex(random_bytes(5)) . "." . $allowed[$mime];
    $target = $dir . "/" . $fileName;
    if (!move_uploaded_file($tmp, $target)) {
        throw new RuntimeException("Unable to save uploaded image.");
    }

    return "assets/images/portfolio/" . $fileName;
}

function normalize_portfolio_image_url(string $imageUrl): string
{
    $imageUrl = trim($imageUrl);
    if ($imageUrl === "") {
        return "";
    }

    // Accept external URLs (http:// or https://)
    if (preg_match("#^https?://#i", $imageUrl) === 1) {
        return $imageUrl;
    }

    // Accept internal asset paths
    if (str_starts_with($imageUrl, "/assets/images/")) {
        return ltrim($imageUrl, "/");
    }

    if (str_starts_with($imageUrl, "assets/images/")) {
        return $imageUrl;
    }

    if (str_starts_with($imageUrl, "admin/uploads/")) {
        return $imageUrl;
    }

    if (str_starts_with($imageUrl, "uploads/")) {
        return "admin/" . $imageUrl;
    }

    throw new RuntimeException("Image URL must be a valid external URL (http:// or https://) or a relative path to /assets/images/");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int)($_POST["id"] ?? 0);
    $title = admin_clean((string)($_POST["title"] ?? ""));
    $category = admin_clean((string)($_POST["category"] ?? ""));
    $imageUrl = admin_clean((string)($_POST["image_url"] ?? ""));

    if ($title === "" || $category === "") {
        admin_json(["ok" => false, "message" => "All fields are required."], 422);
    }

    if (isset($_FILES["image"]) && (int)$_FILES["image"]["error"] !== UPLOAD_ERR_NO_FILE) {
        try {
            $imageUrl = upload_portfolio_image($_FILES["image"]);
        } catch (RuntimeException $e) {
            admin_json(["ok" => false, "message" => $e->getMessage()], 422);
        }
    } else {
        try {
            $imageUrl = normalize_portfolio_image_url($imageUrl);
        } catch (RuntimeException $e) {
            admin_json(["ok" => false, "message" => $e->getMessage()], 422);
        }
    }

    if ($imageUrl === "") {
        admin_json(["ok" => false, "message" => "Portfolio image is required."], 422);
    }

    $pdo = admin_pdo();
    if ($id > 0) {
        $stmt = $pdo->prepare("UPDATE portfolio SET title = :title, category = :category, image_url = :image_url WHERE id = :id");
        $stmt->execute([
            ":title" => $title,
            ":category" => $category,
            ":image_url" => $imageUrl,
            ":id" => $id,
        ]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO portfolio (title, category, image_url) VALUES (:title, :category, :image_url)");
        $stmt->execute([
            ":title" => $title,
            ":category" => $category,
            ":image_url" => $imageUrl,
        ]);
    }

    admin_json(["ok" => true, "message" => "Portfolio saved successfully."]);
}

if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    parse_str((string)file_get_contents("php://input"), $payload);
    $id = (int)($payload["id"] ?? 0);
    if ($id <= 0) {
        admin_json(["ok" => false, "message" => "Invalid portfolio id."], 422);
    }
    $stmt = admin_pdo()->prepare("DELETE FROM portfolio WHERE id = :id");
    $stmt->execute([":id" => $id]);
    admin_json(["ok" => true, "message" => "Portfolio item deleted."]);
}

admin_json(["ok" => false, "message" => "Method not allowed."], 405);
