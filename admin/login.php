<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/init.php";

if (admin_is_logged_in()) {
    header("Location: dashboard.php");
    exit;
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = admin_clean((string)($_POST["username"] ?? ""));
    $password = (string)($_POST["password"] ?? "");
    if ($username === "" || $password === "") {
        $error = "Please enter username and password.";
    } elseif (!admin_login($username, $password)) {
        $error = "Invalid login credentials.";
    } else {
        header("Location: dashboard.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login | Prestigee Events</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            peGreen: "#406352",
            peMint: "#97D0B1",
            peLavender: "#C8C2E0",
            peCoral: "#F05C4F",
            peNavy: "#292866",
          },
        },
      },
    };
  </script>
</head>
<body class="min-h-screen bg-slate-50 text-peNavy">
  <div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl shadow-slate-200/70 p-8">
      <p class="text-sm text-peGreen font-semibold">Prestigee Events</p>
      <h1 class="text-2xl font-bold mt-1">Admin Login</h1>
      <p class="text-sm text-slate-500 mt-1">Use your admin credentials to continue.</p>
      <?php if ($error !== ""): ?>
        <div class="mt-4 rounded-xl border border-red-200 bg-red-50 text-red-700 px-4 py-3 text-sm">
          <?php echo htmlspecialchars($error, ENT_QUOTES, "UTF-8"); ?>
        </div>
      <?php endif; ?>
      <form method="post" class="mt-6 space-y-4">
        <div>
          <label for="username" class="text-sm font-medium">Username</label>
          <input id="username" name="username" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-3 outline-none focus:ring-2 focus:ring-peMint" required>
        </div>
        <div>
          <label for="password" class="text-sm font-medium">Password</label>
          <input id="password" type="password" name="password" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-3 outline-none focus:ring-2 focus:ring-peMint" required>
        </div>
        <button class="w-full rounded-xl bg-peNavy text-white py-3 font-semibold hover:opacity-90 transition">Login</button>
      </form>
    </div>
  </div>
</body>
</html>
