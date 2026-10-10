<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/init.php";

if (admin_is_logged_in()) {
    header("Location: dashboard.php");
    exit;
}

header("Location: login.php");
exit;
