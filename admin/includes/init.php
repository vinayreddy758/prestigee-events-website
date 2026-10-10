<?php
declare(strict_types=1);

require_once __DIR__ . "/../../includes/db.php";

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function admin_pdo(): PDO
{
    return prestigee_db();
}

function admin_ensure_schema(PDO $pdo): void
{
    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS admins (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(80) NOT NULL UNIQUE,
            password_hash VARCHAR(255) NOT NULL,
            full_name VARCHAR(120) NOT NULL DEFAULT 'Administrator',
            is_active TINYINT(1) NOT NULL DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    );

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS services (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(150) NOT NULL,
            category VARCHAR(120) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    );
    $servicesDescriptionColumn = (int)$pdo->query(
        "SELECT COUNT(*) FROM information_schema.columns
         WHERE table_schema = DATABASE() AND table_name = 'services' AND column_name = 'description'"
    )->fetchColumn();
    if ($servicesDescriptionColumn > 0) {
        $pdo->exec("ALTER TABLE services DROP COLUMN description");
    }

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS portfolio (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(180) NOT NULL,
            category VARCHAR(120) NOT NULL,
            image_url VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    );
    $portfolioDescriptionColumn = (int)$pdo->query(
        "SELECT COUNT(*) FROM information_schema.columns
         WHERE table_schema = DATABASE() AND table_name = 'portfolio' AND column_name = 'description'"
    )->fetchColumn();
    if ($portfolioDescriptionColumn > 0) {
        $pdo->exec("ALTER TABLE portfolio DROP COLUMN description");
    }

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS about_content (
            id TINYINT UNSIGNED PRIMARY KEY,
            who_we_are TEXT NOT NULL,
            experience_text TEXT NOT NULL,
            mission TEXT NOT NULL,
            vision TEXT NOT NULL,
            strengths TEXT NOT NULL,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    );

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS quotes (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(120) NOT NULL,
            company VARCHAR(150) NOT NULL,
            phone VARCHAR(30) NOT NULL,
            email VARCHAR(190) NOT NULL,
            event_type VARCHAR(120) NOT NULL,
            event_date DATE NOT NULL,
            location VARCHAR(180) NOT NULL,
            budget VARCHAR(80) NOT NULL,
            message TEXT NOT NULL,
            is_contacted TINYINT(1) NOT NULL DEFAULT 0,
            contacted_at TIMESTAMP NULL DEFAULT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    );

    $legacyExists = (int)$pdo->query("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'quote_requests'")->fetchColumn();
    if ($legacyExists > 0) {
        $pdo->exec(
            "INSERT INTO quotes (name, company, phone, email, event_type, event_date, location, budget, message, is_contacted, created_at)
             SELECT qr.name, qr.company, qr.phone, qr.email, qr.event_type, qr.event_date, qr.location, qr.budget, qr.message, 0, qr.created_at
             FROM quote_requests qr
             LEFT JOIN quotes q
               ON q.name = qr.name
              AND q.email = qr.email
              AND q.event_type = qr.event_type
              AND q.event_date = qr.event_date
              AND q.created_at = qr.created_at
             WHERE q.id IS NULL"
        );
    }

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS messages (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(120) NOT NULL,
            email VARCHAR(190) NOT NULL,
            phone VARCHAR(30) DEFAULT NULL,
            subject VARCHAR(180) NOT NULL,
            message TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    );

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS settings (
            setting_key VARCHAR(80) PRIMARY KEY,
            setting_value TEXT NOT NULL,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    );

    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM admins");
    $count = (int) $stmt->fetchColumn();
    if ($count === 0) {
        $insert = $pdo->prepare(
            "INSERT INTO admins (username, password_hash, full_name, is_active)
             VALUES (:username, :password_hash, :full_name, 1)"
        );
        $insert->execute([
            ":username" => "aaron",
            ":password_hash" => password_hash("aaron@5500", PASSWORD_DEFAULT),
            ":full_name" => "Aaron",
        ]);
    }

    $pdo->exec(
        "INSERT IGNORE INTO settings (setting_key, setting_value) VALUES
            ('phone', ''),
            ('whatsapp', ''),
            ('email', ''),
            ('address', ''),
            ('facebook', ''),
            ('instagram', ''),
            ('linkedin', '')"
    );

    $pdo->exec(
        "INSERT IGNORE INTO about_content (id, who_we_are, experience_text, mission, vision, strengths)
         VALUES
            (1, '', '', '', '', '')"
    );
}

function admin_is_logged_in(): bool
{
    return isset($_SESSION["admin_id"]) && is_int($_SESSION["admin_id"]);
}

function admin_require_login(): void
{
    if (!admin_is_logged_in()) {
        $script = str_replace("/", "/", (string)($_SERVER["SCRIPT_NAME"] ?? ""));
        $loginPath = (strpos($script, "/admin/api/") !== false) ? "../login.php" : "login.php";
        header("Location: " . $loginPath);
        exit;
    }
}

function admin_current_user(): array
{
    return [
        "id" => (int)($_SESSION["admin_id"] ?? 0),
        "username" => (string)($_SESSION["admin_username"] ?? ""),
        "full_name" => (string)($_SESSION["admin_name"] ?? "Admin"),
    ];
}

function admin_login(string $username, string $password): bool
{
    $pdo = admin_pdo();
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = :username LIMIT 1");
    $stmt->execute([":username" => $username]);
    $admin = $stmt->fetch();

    if (!$admin || (int)$admin["is_active"] !== 1) {
        return false;
    }

    if (!password_verify($password, (string)$admin["password_hash"])) {
        return false;
    }

    $_SESSION["admin_id"] = (int)$admin["id"];
    $_SESSION["admin_username"] = (string)$admin["username"];
    $_SESSION["admin_name"] = (string)$admin["full_name"];
    return true;
}

function admin_logout(): void
{
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), "", time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    session_destroy();
}

function admin_json(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($payload);
    exit;
}

function admin_clean(string $value): string
{
    return trim($value);
}

admin_ensure_schema(admin_pdo());
