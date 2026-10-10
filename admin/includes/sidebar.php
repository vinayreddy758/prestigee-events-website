<?php
/** @var string $activeMenu */
$activeMenu = $activeMenu ?? "dashboard";
?>
<aside id="adminSidebar" class="fixed md:static inset-y-0 left-0 w-72 bg-white border-r border-slate-200 shadow-soft md:shadow-none transform -translate-x-full md:translate-x-0 transition-transform z-40">
  <div class="h-full flex flex-col">
    <div class="px-6 py-6 border-b border-slate-100">
      <a href="dashboard.php" class="text-2xl font-extrabold text-peNavy">Prestigee <span class="text-peGreen">Admin</span></a>
      <p class="text-xs text-slate-500 mt-1">Event Management Panel</p>
    </div>
    <nav class="p-4 space-y-2 text-sm overflow-y-auto">
      <a class="sidebar-link <?php echo $activeMenu === 'dashboard' ? 'active' : ''; ?> block px-4 py-3 rounded-xl" href="dashboard.php">Dashboard</a>
      <a class="sidebar-link <?php echo $activeMenu === 'services' ? 'active' : ''; ?> block px-4 py-3 rounded-xl" href="services.php">Services</a>
      <a class="sidebar-link <?php echo $activeMenu === 'portfolio' ? 'active' : ''; ?> block px-4 py-3 rounded-xl" href="portfolio.php">Portfolio</a>
      <a class="sidebar-link <?php echo $activeMenu === 'about' ? 'active' : ''; ?> block px-4 py-3 rounded-xl" href="about-content.php">About Page</a>
      <a class="sidebar-link <?php echo $activeMenu === 'quotes' ? 'active' : ''; ?> block px-4 py-3 rounded-xl" href="quotes.php">Quote Requests</a>
      <a class="sidebar-link <?php echo $activeMenu === 'messages' ? 'active' : ''; ?> block px-4 py-3 rounded-xl" href="messages.php">Contact Messages</a>
      <a class="sidebar-link <?php echo $activeMenu === 'settings' ? 'active' : ''; ?> block px-4 py-3 rounded-xl" href="settings.php">Site Settings</a>
    </nav>
  </div>
</aside>
<div id="sidebarBackdrop" class="hidden md:hidden fixed inset-0 bg-black/30 z-30"></div>
