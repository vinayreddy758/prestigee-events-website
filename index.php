<?php
$pageTitle = "Prestigee Events | Luxury Event Management";
$activePage = "home";
include __DIR__ . "/includes/header.php";
?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Prestigee Events",
  "url": "https://prestigeeevents.com",
  "logo": "https://prestigeeevents.com/assets/images/logo.png",
  "description": "Premium event management company specializing in corporate events, luxury celebrations, and high-impact brand experiences",
  "sameAs": [
    "https://www.facebook.com/prestigee-events",
    "https://www.instagram.com/prestigee-events",
    "https://www.linkedin.com/company/prestigee-events"
  ],
  "contactPoint": {
    "@type": "ContactPoint",
    "contactType": "Customer Service",
    "telephone": "+1-XXX-XXX-XXXX",
    "email": "info@prestigee-events.com"
  },
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Your Address",
    "addressLocality": "Your City",
    "addressRegion": "Your State",
    "postalCode": "Your Postal Code",
    "addressCountry": "US"
  }
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "Prestigee Events",
  "image": "https://prestigeeevents.com/assets/images/logo.png",
  "description": "Luxury event management and planning services",
  "url": "https://prestigeeevents.com",
  "priceRange": "$$$$",
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.9",
    "reviewCount": "150"
  }
}
</script>

<div id="siteLoader" class="fixed inset-0 z-[100] bg-black flex items-center justify-center px-6">
  <div class="w-full max-w-md text-center">
    <p class="loader-logo-pulse text-3xl md:text-4xl font-extrabold tracking-wide">
      Prestigee <span class="text-gold-500">Events</span>
    </p>
    <p class="loader-text-fade mt-3 text-xs md:text-sm tracking-[0.2em] uppercase text-gold-400/90">Crafting Luxury Moments</p>
    <div class="mt-8 h-2 rounded-full bg-white/10 overflow-hidden border border-white/15">
      <div id="siteLoaderBar" class="h-full w-0 bg-gradient-to-r from-gold-600 via-gold-500 to-gold-400 transition-all duration-300"></div>
    </div>
    <p id="siteLoaderPercent" class="mt-4 text-gold-400 text-sm font-semibold">0%</p>
  </div>
</div>

<section id="heroScroll" class="relative h-[280vh]">
  <div class="sticky top-0 h-screen overflow-hidden">
    <canvas id="heroCanvas" class="absolute inset-0 w-full h-full"></canvas>
    <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/50 to-black/80"></div>

    <div class="relative z-10 h-full flex items-center justify-center px-4">
      <div id="heroTextContent" class="max-w-4xl text-center">
        <p class="fade-up text-gold-400 uppercase tracking-[0.2em] text-xs md:text-sm mb-5">Luxury Event Curation</p>
        <h1 class="fade-up text-4xl sm:text-5xl md:text-7xl font-extrabold leading-tight">
          Crafting Unforgettable Experiences
        </h1>
        <p class="fade-up mt-6 text-base sm:text-lg md:text-xl text-white/80">
          Premium Corporate &amp; Luxury Event Management
        </p>
        <div class="fade-up mt-10 flex items-center justify-center gap-4 flex-wrap">
          <a href="quote.php" class="btn-glow glass px-7 py-3 rounded-xl bg-gold-500/95 text-black font-semibold shadow-glow">
            Get Quote
          </a>
          <a href="services.php" class="btn-glow glass px-7 py-3 rounded-xl border border-gold-400/60 text-gold-300 font-medium">
            View Services
          </a>
        </div>
      </div>
    </div>

    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-10 flex flex-col items-center text-white/70">
      <span class="text-xs tracking-[0.16em] uppercase">Scroll</span>
      <span class="mt-2 w-6 h-10 rounded-full border border-white/40 flex justify-center">
        <span class="w-1.5 h-1.5 rounded-full bg-gold-400 mt-2 animate-bounce"></span>
      </span>
    </div>
  </div>
</section>

<section class="section-divider max-w-7xl mx-auto px-4 md:px-8 py-16 md:py-24">
  <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-6">
    <article class="glass rounded-2xl p-6">
      <h3 class="text-xl font-semibold text-gold-400">Corporate Excellence</h3>
      <p class="mt-3 text-white/75">Board meetings, launches, and executive experiences tailored to your brand voice.</p>
    </article>
    <article class="glass rounded-2xl p-6">
      <h3 class="text-xl font-semibold text-gold-400">Manpower Services</h3>
      <p class="mt-3 text-white/75">Professional on-ground staffing for registration, guest handling, stage operations, and smooth event flow.</p>
    </article>
    <article class="glass rounded-2xl p-6">
      <h3 class="text-xl font-semibold text-gold-400">Luxury Weddings</h3>
      <p class="mt-3 text-white/75">Immersive design, storytelling, and precision planning for once-in-a-lifetime moments.</p>
    </article>
    <article class="glass rounded-2xl p-6">
      <h3 class="text-xl font-semibold text-gold-400">Private Celebrations</h3>
      <p class="mt-3 text-white/75">Curated decor, lighting, and guest-flow management with premium hospitality standards.</p>
    </article>
  </div>
</section>

<section class="section-divider max-w-7xl mx-auto px-4 md:px-8 py-8 md:py-16">
  <div class="flex items-end justify-between gap-4 flex-wrap">
    <div>
      <p class="text-gold-400 uppercase tracking-[0.16em] text-xs">Our Advantage</p>
      <h2 class="mt-3 text-3xl md:text-5xl font-bold">Why Choose Us</h2>
    </div>
  </div>
  <div class="mt-10 grid sm:grid-cols-2 xl:grid-cols-4 gap-6">
    <article class="glass neu-shadow hover-gold rounded-2xl p-6 border border-white/10">
      <div class="w-12 h-12 rounded-xl bg-gold-500/15 text-gold-400 flex items-center justify-center">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M12 3l2.7 5.47L21 9.4l-4.5 4.38L17.55 21 12 18.1 6.45 21 7.5 13.78 3 9.4l6.3-.93L12 3z"/></svg>
      </div>
      <h3 class="mt-4 text-xl font-semibold text-gold-400">Creative Concepts</h3>
      <p class="mt-2 text-white/75">Fresh storytelling and design direction crafted around your audience and brand identity.</p>
    </article>
    <article class="glass neu-shadow hover-gold rounded-2xl p-6 border border-white/10">
      <div class="w-12 h-12 rounded-xl bg-gold-500/15 text-gold-400 flex items-center justify-center">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M4 7h16M4 12h16M4 17h10"/></svg>
      </div>
      <h3 class="mt-4 text-xl font-semibold text-gold-400">End-to-End Execution</h3>
      <p class="mt-2 text-white/75">From planning to live operations, we manage every detail with high-precision delivery.</p>
    </article>
    <article class="glass neu-shadow hover-gold rounded-2xl p-6 border border-white/10">
      <div class="w-12 h-12 rounded-xl bg-gold-500/15 text-gold-400 flex items-center justify-center">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M9 12l2 2 4-4m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      </div>
      <h3 class="mt-4 text-xl font-semibold text-gold-400">Premium Quality</h3>
      <p class="mt-2 text-white/75">Luxury-grade visuals, hospitality standards, and production quality your guests remember.</p>
    </article>
    <article class="glass neu-shadow hover-gold rounded-2xl p-6 border border-white/10">
      <div class="w-12 h-12 rounded-xl bg-gold-500/15 text-gold-400 flex items-center justify-center">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M17 20h5V4H2v16h5m10 0v-5a3 3 0 00-6 0v5m6 0H7"/></svg>
      </div>
      <h3 class="mt-4 text-xl font-semibold text-gold-400">Trusted by Corporates</h3>
      <p class="mt-2 text-white/75">Preferred partner for executive events, annual meets, launches, and marquee engagements.</p>
    </article>
  </div>
</section>

<section class="section-divider max-w-7xl mx-auto px-4 md:px-8 py-14 md:py-20" data-stagger-section>
  <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-center">
    <div class="order-2 md:order-1 reveal">
      <p class="text-gold-400 tracking-[0.18em] text-xs uppercase">What We Offer</p>
      <h2 class="mt-3 text-4xl md:text-5xl font-bold">Our Services</h2>
      <p class="mt-4 text-white/70 max-w-xl">
        End-to-end event management solutions tailored to your goals. From people to production, we deliver seamless experiences.
      </p>

      <div class="mt-8">
        <a href="services.php" class="group flex items-start justify-between gap-4 py-5 border-b border-white/15 hover:border-gold-500/70 transition duration-300 hover:scale-[1.01]" data-card-reveal>
          <div class="flex gap-4">
            <div class="w-12 h-12 rounded-xl glass neu-shadow border border-white/20 text-gold-400 flex items-center justify-center shrink-0">
              <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 14a4 4 0 10-8 0M12 11a3 3 0 110-6 3 3 0 010 6zm7 9a7 7 0 10-14 0"/></svg>
            </div>
            <div>
              <h3 class="text-xl font-semibold text-gold-400">Manpower Services</h3>
              <p class="mt-1 text-white/70 text-sm md:text-base">Skilled professionals for event operations, guest management, logistics, hospitality and more.</p>
            </div>
          </div>
          <span class="text-gold-400 text-2xl leading-none translate-y-1 transition-transform duration-300 group-hover:translate-x-1.5">→</span>
        </a>

        <a href="services.php" class="group flex items-start justify-between gap-4 py-5 border-b border-white/15 hover:border-gold-500/70 transition duration-300 hover:scale-[1.01]" data-card-reveal>
          <div class="flex gap-4">
            <div class="w-12 h-12 rounded-xl glass neu-shadow border border-white/20 text-gold-400 flex items-center justify-center shrink-0">
              <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 8h16M4 12h16M4 16h10M7 5h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2z"/></svg>
            </div>
            <div>
              <h3 class="text-xl font-semibold text-gold-400">Corporate Events</h3>
              <p class="mt-1 text-white/70 text-sm md:text-base">Conferences, product launches, annual meets and seminars executed with precision and professionalism.</p>
            </div>
          </div>
          <span class="text-gold-400 text-2xl leading-none translate-y-1 transition-transform duration-300 group-hover:translate-x-1.5">→</span>
        </a>

        <a href="services.php" class="group flex items-start justify-between gap-4 py-5 border-b border-white/15 hover:border-gold-500/70 transition duration-300 hover:scale-[1.01]" data-card-reveal>
          <div class="flex gap-4">
            <div class="w-12 h-12 rounded-xl glass neu-shadow border border-white/20 text-gold-400 flex items-center justify-center shrink-0">
              <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V5a4 4 0 118 0v2m-9 0h10a2 2 0 012 2v8a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2z"/></svg>
            </div>
            <div>
              <h3 class="text-xl font-semibold text-gold-400">Event Services</h3>
              <p class="mt-1 text-white/70 text-sm md:text-base">Complete event support including design, decor, AV, entertainment, catering and on-site execution.</p>
            </div>
          </div>
          <span class="text-gold-400 text-2xl leading-none translate-y-1 transition-transform duration-300 group-hover:translate-x-1.5">→</span>
        </a>
      </div>
    </div>

    <div class="order-1 md:order-2 reveal">
      <div class="group relative overflow-hidden rounded-3xl border border-white/10 shadow-[0_16px_48px_rgba(0,0,0,0.55)]">
        <img
          src="assets/images/event.png"
          alt="Premium event stage setup"
          class="w-full h-[360px] md:h-[560px] object-cover transition duration-500 group-hover:scale-105"
        >
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/35 to-transparent"></div>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . "/includes/footer.php"; ?>

