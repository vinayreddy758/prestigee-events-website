<?php
/** @var string $adminPageTitle */
/** @var string $activeMenu */
$adminPageTitle = $adminPageTitle ?? "Admin";
$activeMenu = $activeMenu ?? "dashboard";
$adminUser = admin_current_user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($adminPageTitle, ENT_QUOTES, "UTF-8"); ?> | Prestigee Events Admin</title>
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
            peOff: "#F8F9FB"
          },
          boxShadow: {
            soft: "0 8px 24px rgba(41,40,102,.08), 0 2px 8px rgba(64,99,82,.06)"
          }
        }
      }
    };
  </script>
  <style>
    body { background: #f7f8fb; color: #292866; }
    .neo-card { background: #fff; box-shadow: 0 12px 26px rgba(41,40,102,.08), 0 3px 10px rgba(64,99,82,.05); border-radius: 1rem; }
    .sidebar-link { transition: all .2s ease; }
    .sidebar-link:hover { background: #eef6f1; color: #406352; transform: translateX(2px); }
    .sidebar-link.active { background: #dff2e8; color: #406352; font-weight: 600; }
  </style>
</head>
<body class="min-h-screen">
  <div id="toastWrap" class="fixed top-4 right-4 z-50 space-y-2"></div>
  <div class="flex min-h-screen">
    <?php include __DIR__ . "/sidebar.php"; ?>
    <div class="flex-1 min-w-0">
      <header class="sticky top-0 z-30 bg-white/90 backdrop-blur border-b border-slate-200">
        <div class="px-4 md:px-8 py-4 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <button id="sidebarToggle" class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl bg-peMint/25 text-peNavy">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16"></path>
              </svg>
            </button>
            <div>
              <p class="text-xs uppercase tracking-[0.14em] text-peGreen">Prestigee Events</p>
              <h1 class="text-xl md:text-2xl font-bold text-peNavy"><?php echo htmlspecialchars($adminPageTitle, ENT_QUOTES, "UTF-8"); ?></h1>
            </div>
          </div>
          <div class="flex items-center gap-3">
            <div class="hidden sm:block text-right">
              <p class="text-sm font-semibold text-peNavy"><?php echo htmlspecialchars($adminUser["full_name"], ENT_QUOTES, "UTF-8"); ?></p>
              <p class="text-xs text-slate-500">@<?php echo htmlspecialchars($adminUser["username"], ENT_QUOTES, "UTF-8"); ?></p>
            </div>
            <a href="logout.php" class="inline-flex px-4 py-2 rounded-xl bg-peNavy text-white text-sm hover:opacity-90 transition">Logout</a>
          </div>
        </div>
      </header>
      <main class="p-4 md:p-8">
