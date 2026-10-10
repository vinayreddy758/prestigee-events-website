<?php
$pageTitle = $pageTitle ?? "Prestigee Events";
$activePage = $activePage ?? "";
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Premium event management for corporate events, luxury celebrations, and high-impact brand experiences. Professional event planning and execution.">
  <meta name="keywords" content="event management, corporate events, luxury events, event planning, brand experiences">
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
  <meta name="theme-color" content="#d4af37">
  <meta name="author" content="Prestigee Events">
  <meta property="og:site_name" content="Prestigee Events">
  <meta property="og:type" content="website">
  <meta property="og:locale" content="en_US">
  <meta name="twitter:card" content="summary_large_image">
  <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, "UTF-8"); ?></title>
  <link rel="canonical" href="https://prestigeeevents.com<?php echo str_replace('/', '/', $_SERVER['REQUEST_URI']); ?>">
  <link rel="alternate" hreflang="en-US" href="https://prestigeeevents.com<?php echo str_replace('/', '/', $_SERVER['REQUEST_URI']); ?>">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon/favicon-16x16.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="48x48" href="assets/images/favicon/favicon-48x48.png">
  <link rel="icon" type="image/png" sizes="64x64" href="assets/images/favicon/favicon-64x64.png">
  <link rel="icon" type="image/png" sizes="128x128" href="assets/images/favicon/favicon-128x128.png">
  <link rel="icon" type="image/png" sizes="256x256" href="assets/images/favicon/favicon-256x256.png">
  <link rel="icon" type="image/png" sizes="512x512" href="assets/images/favicon/favicon-512x512.png">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/images/favicon/favicon-256x256.png">
  <link rel="shortcut icon" href="assets/images/favicon/favicon-32x32.png">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            gold: {
              400: "#e7c56d",
              500: "#d4af37",
              600: "#b8912a"
            }
          },
          boxShadow: {
            glow: "0 0 22px rgba(212,175,55,0.35)"
          },
          fontFamily: {
            sans: ["Inter", "Poppins", "ui-sans-serif", "system-ui", "sans-serif"]
          }
        }
      }
    };
  </script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    :root {
      color-scheme: dark;
    }
    body {
      background: radial-gradient(circle at 20% 10%, #1a1a1a 0%, #090909 42%, #050505 100%);
    }
    .glass {
      background: linear-gradient(135deg, rgba(255,255,255,0.12), rgba(255,255,255,0.05));
      border: 1px solid rgba(255, 255, 255, 0.16);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
    }
    .btn-glow {
      transition: transform .25s ease, box-shadow .25s ease, background .25s ease;
    }
    .btn-glow:hover {
      transform: translateY(-2px);
      box-shadow: 0 0 20px rgba(212,175,55,0.4);
    }
    .neu-shadow {
      box-shadow: 9px 9px 24px rgba(0,0,0,.45), -7px -7px 20px rgba(255,255,255,.03);
    }
    .hover-gold {
      transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
    }
    .hover-gold:hover {
      transform: translateY(-4px) scale(1.02);
      border-color: rgba(212,175,55,.6);
      box-shadow: 0 0 0 1px rgba(212,175,55,.35), 0 0 28px rgba(212,175,55,.25);
    }
    .zoom-media img {
      transition: transform .6s ease;
    }
    .zoom-media:hover img {
      transform: scale(1.08);
    }
    .masonry-grid {
      column-count: 1;
      column-gap: 1rem;
    }
    @media (min-width: 768px) {
      .masonry-grid { column-count: 2; }
    }
    @media (min-width: 1280px) {
      .masonry-grid { column-count: 3; }
    }
    .mask-reveal {
      display: block;
      overflow: hidden;
    }
    .mask-reveal .mask-line {
      display: inline-block;
      will-change: transform, opacity;
      transform: translateY(0);
    }
    [data-parallax] {
      will-change: transform;
    }
    .fade-up {
      animation: fadeUp .8s ease both;
    }
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(14px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .loader-logo-pulse {
      text-shadow: 0 0 24px rgba(212,175,55,.55);
    }
    .loader-text-fade {
      animation: loaderText 1.5s ease-in-out infinite;
    }
    .brand-card-wrapper {
      perspective: 1800px;
      overflow: hidden;
      border-radius: 18px;
    }
    .brand-card {
      position: relative;
      width: 100%;
      max-width: 420px;
      height: 260px;
      margin: 0 auto;
      transform-style: preserve-3d;
      transform-origin: right center;
      transition: transform 1.15s cubic-bezier(0.65, 0.05, 0.36, 1);
      will-change: transform;
      cursor: pointer;
    }
    .brand-card-wrapper:hover .brand-card,
    .brand-card.flip {
      transform: translateX(-100%) rotateY(180deg);
    }
    .brand-card-bend {
      position: absolute;
      inset: 0;
      transform-style: preserve-3d;
      transition: transform .35s ease;
      will-change: transform;
    }
    .brand-card-wrapper:hover .brand-card-bend,
    .brand-card.flip .brand-card-bend {
      transform: rotateX(0deg) skewY(0deg) scaleX(1);
    }
    .brand-card::after {
      content: "";
      position: absolute;
      inset: 0;
      border-radius: 18px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.45), 0 0 30px rgba(255,215,0,0.08);
      transition: box-shadow 1.2s cubic-bezier(0.22, 1, 0.36, 1);
      pointer-events: none;
    }
    .brand-card-wrapper:hover .brand-card::after,
    .brand-card.flip::after {
      box-shadow: 0 50px 100px rgba(0,0,0,0.65), 0 0 50px rgba(255,215,0,0.15);
    }
    .brand-card-face {
      position: absolute;
      inset: 0;
      border-radius: 18px;
      overflow: hidden;
      backface-visibility: hidden;
      -webkit-backface-visibility: hidden;
      box-shadow: 0 20px 40px rgba(0,0,0,0.42);
      border: 1px solid rgba(255,255,255,0.12);
      background: #0a0a0a;
      transform-style: preserve-3d;
    }
    .brand-card-front {
      transform: rotateY(0deg) translateZ(1px);
    }
    .brand-card-back {
      transform: rotateY(180deg) translateZ(1px);
    }
    .brand-card-face img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      border-radius: 1rem;
    }
    .brand-card-shine {
      position: absolute;
      top: 0;
      left: -100%;
      width: 200%;
      height: 100%;
      background: linear-gradient(120deg, transparent 40%, rgba(255,255,255,0.2), transparent 60%);
      transition: left .8s ease;
      pointer-events: none;
    }
    .brand-card-wrapper:hover .brand-card-shine,
    .brand-card.flip .brand-card-shine {
      left: 100%;
    }
    @media (max-width: 640px) {
      .brand-card {
        height: 220px;
      }
    }
    @keyframes loaderText {
      0%, 100% { opacity: .45; }
      50% { opacity: 1; }
    }
  </style>
</head>
<body class="text-white font-sans antialiased">
  <header class="fixed top-0 inset-x-0 z-50 px-4 md:px-8 py-4">
    <nav class="glass mx-auto max-w-7xl rounded-2xl">
      <div class="px-4 md:px-6 py-3 flex items-center justify-between">
        <a href="index.php" class="text-xl font-bold tracking-wide">
          Prestigee <span class="text-gold-500">Events</span>
        </a>
        <button id="menuBtn" class="md:hidden p-2 rounded-lg border border-white/20" aria-label="Toggle menu">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
        <ul id="navMenu" class="hidden md:flex items-center gap-5 text-sm">
          <li><a class="hover:text-gold-400 transition <?php echo $activePage === 'home' ? 'text-gold-400' : ''; ?>" href="index.php">Home</a></li>
          <li><a class="hover:text-gold-400 transition <?php echo $activePage === 'about' ? 'text-gold-400' : ''; ?>" href="about.php">About</a></li>
          <li><a class="hover:text-gold-400 transition <?php echo $activePage === 'services' ? 'text-gold-400' : ''; ?>" href="services.php">Services</a></li>
          <li><a class="hover:text-gold-400 transition <?php echo $activePage === 'portfolio' ? 'text-gold-400' : ''; ?>" href="portfolio.php">Portfolio</a></li>
          <li><a class="hover:text-gold-400 transition <?php echo $activePage === 'contact' ? 'text-gold-400' : ''; ?>" href="contact.php">Contact</a></li>
          <li>
            <a href="quote.php" class="btn-glow inline-flex items-center px-4 py-2 rounded-xl bg-gold-500 text-black font-semibold shadow-glow <?php echo $activePage === 'quote' ? 'ring-2 ring-gold-400/70' : ''; ?>">
              Get Quote
            </a>
          </li>
        </ul>
      </div>
      <div id="mobileMenu" class="hidden md:hidden border-t border-white/10 px-4 pb-4">
        <div class="flex flex-col gap-3 pt-3 text-sm">
          <a class="hover:text-gold-400 transition" href="index.php">Home</a>
          <a class="hover:text-gold-400 transition" href="about.php">About</a>
          <a class="hover:text-gold-400 transition" href="services.php">Services</a>
          <a class="hover:text-gold-400 transition" href="portfolio.php">Portfolio</a>
          <a class="hover:text-gold-400 transition" href="contact.php">Contact</a>
          <a href="quote.php" class="btn-glow text-center px-4 py-2 rounded-xl bg-gold-500 text-black font-semibold">Get Quote</a>
        </div>
      </div>
    </nav>
  </header>
  <main>

