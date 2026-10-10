<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/db.php";

$pageTitle = "About Prestigee Events | Premium Event Management Company";
$pageDescription = "Learn about Prestigee Events - premium event management specialists. Discover our mission, vision, expertise, and commitment to delivering exceptional experiences.";

$whoText = "We are strategic planners, creative thinkers, and execution specialists who transform ideas into immersive event journeys with measurable impact.";
$experienceText = "From executive conferences and launches to private luxury celebrations, our team has hands-on experience managing diverse event formats, vendor ecosystems, and live production timelines.";
$missionText = "To deliver seamless, meaningful, and memorable events that elevate brand perception, strengthen relationships, and create lasting value for every client.";
$visionText = "To be the most trusted premium event partner known for reliability, innovation, and flawless execution across every touchpoint.";
$strengthsList = [
    "Client-first planning approach",
    "Strong vendor and production network",
    "Detail-driven execution standards",
    "Creative concept-to-delivery capability",
    "On-ground coordination excellence",
    "Clear communication and accountability",
];

$pdo = prestigee_db();
ensure_about_content_table($pdo);
$row = $pdo->query("SELECT who_we_are, experience_text, mission, vision, strengths FROM about_content WHERE id = 1 LIMIT 1")->fetch();
if ($row) {
    $whoText = trim((string)$row["who_we_are"]) !== "" ? (string)$row["who_we_are"] : $whoText;
    $experienceText = trim((string)$row["experience_text"]) !== "" ? (string)$row["experience_text"] : $experienceText;
    $missionText = trim((string)$row["mission"]) !== "" ? (string)$row["mission"] : $missionText;
    $visionText = trim((string)$row["vision"]) !== "" ? (string)$row["vision"] : $visionText;
    $rawStrengths = trim((string)$row["strengths"]);
    if ($rawStrengths !== "") {
        $parsed = preg_split("/\r\n|\r|\n|\|/", $rawStrengths);
        if ($parsed !== false) {
            $parsed = array_values(array_filter(array_map("trim", $parsed), static fn ($v) => $v !== ""));
            if ($parsed !== []) {
                $strengthsList = $parsed;
            }
        }
    }
}

$activePage = "about";
include __DIR__ . "/includes/header.php";
?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "AboutPage",
  "name": "About Prestigee Events",
  "description": "<?php echo htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8'); ?>",
  "url": "https://prestigeeevents.com/about.php"
}
</script>

<section class="pt-32 pb-16 px-4 md:px-8">
  <div class="max-w-6xl mx-auto">
    <div class="glass rounded-2xl p-8 md:p-12 reveal">
      <p class="text-gold-400 uppercase tracking-[0.16em] text-xs">About Prestigee Events</p>
      <h1 class="mt-3 text-4xl md:text-5xl font-bold text-white">Building Trust Through Exceptional Event Experiences</h1>
      <p class="mt-5 text-white/75 text-lg">Prestigee Events is a premium event management team focused on corporate events, luxury celebrations, and high-impact brand experiences delivered with precision and consistency.</p>
    </div>

    <div class="mt-8 grid md:grid-cols-2 gap-6">
      <article class="glass rounded-2xl p-7 reveal border border-white/10">
        <h2 class="text-2xl font-semibold text-gold-400">Who is Prestigee Events</h2>
        <p class="mt-3 text-white/75"><?php echo nl2br(htmlspecialchars($whoText, ENT_QUOTES, "UTF-8")); ?></p>
      </article>
      <article class="glass rounded-2xl p-7 reveal border border-white/10">
        <h2 class="text-2xl font-semibold text-gold-400">Our Experience</h2>
        <p class="mt-3 text-white/75"><?php echo nl2br(htmlspecialchars($experienceText, ENT_QUOTES, "UTF-8")); ?></p>
      </article>
    </div>

    <div class="mt-6 grid md:grid-cols-2 gap-6">
      <article class="glass rounded-2xl p-7 reveal border border-white/10">
        <h2 class="text-2xl font-semibold text-gold-400">Our Mission</h2>
        <p class="mt-3 text-white/75"><?php echo nl2br(htmlspecialchars($missionText, ENT_QUOTES, "UTF-8")); ?></p>
      </article>
      <article class="glass rounded-2xl p-7 reveal border border-white/10">
        <h2 class="text-2xl font-semibold text-gold-400">Our Vision</h2>
        <p class="mt-3 text-white/75"><?php echo nl2br(htmlspecialchars($visionText, ENT_QUOTES, "UTF-8")); ?></p>
      </article>
    </div>

    <article class="mt-6 glass rounded-2xl p-7 reveal border border-white/10">
      <h2 class="text-2xl font-semibold text-gold-400">Our Strengths</h2>
      <div class="mt-4 grid sm:grid-cols-2 lg:grid-cols-3 gap-3 text-sm">
        <?php foreach ($strengthsList as $strength): ?>
          <div class="rounded-xl bg-black/30 border border-white/10 px-4 py-3 text-white/80"><?php echo htmlspecialchars($strength, ENT_QUOTES, "UTF-8"); ?></div>
        <?php endforeach; ?>
      </div>
    </article>

    <section class="mt-6 glass rounded-2xl p-7 md:p-10 reveal border border-gold-400/30">
      <div class="grid lg:grid-cols-2 gap-8 items-center">
        <div>
          <p class="text-gold-400 uppercase tracking-[0.18em] text-xs">Brand Identity</p>
          <h2 class="mt-3 text-3xl md:text-4xl font-bold">Meet The Brand Behind The Experience</h2>
          <p class="mt-4 text-white/75 max-w-xl">Every unforgettable event starts with a strong identity. Explore our premium interactive business card.</p>
          <p class="mt-5 text-gold-300/90 text-sm tracking-[0.14em] uppercase">Hover To Experience Our Brand Identity</p>
        </div>
        <div class="brand-card-wrapper max-w-xl w-full mx-auto" data-card-reveal>
          <div class="brand-card" data-brand-card>
            <div class="brand-card-bend">
              <div class="brand-card-face brand-card-front">
                <img src="assets/images/card-front.png" alt="Prestigee Events business card front" loading="eager" fetchpriority="high" decoding="async">
                <span class="brand-card-shine"></span>
              </div>
              <div class="brand-card-face brand-card-back">
                <img src="assets/images/card-back.png" alt="Prestigee Events business card back" loading="eager" fetchpriority="high" decoding="async">
                <span class="brand-card-shine"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>
</section>
<?php include __DIR__ . "/includes/footer.php"; ?>

