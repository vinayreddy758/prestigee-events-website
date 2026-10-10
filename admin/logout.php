<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/init.php";
admin_logout();
header("Location: login.php");
exit;
