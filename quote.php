<?php
declare(strict_types=1);

require_once __DIR__ . "/includes/db.php";

$pageTitle = "Get a Event Quote | Prestigee Events";
$pageDescription = "Request a personalized event quote from Prestigee Events. Share your event details and budget for a professional proposal.";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    header("Content-Type: application/json; charset=UTF-8");

    $name = trim((string)($_POST["name"] ?? ""));
    $company = trim((string)($_POST["company"] ?? ""));
    $phone = trim((string)($_POST["phone"] ?? ""));
    $email = trim((string)($_POST["email"] ?? ""));
    $eventType = trim((string)($_POST["event_type"] ?? ""));
    $eventDate = trim((string)($_POST["event_date"] ?? ""));
    $location = trim((string)($_POST["location"] ?? ""));
    $budget = trim((string)($_POST["budget"] ?? ""));
    $message = trim((string)($_POST["message"] ?? ""));

    $errors = [];

    if ($name === "" || mb_strlen($name) < 2) {
        $errors["name"] = "Please enter a valid name.";
    }
    if ($company === "") {
        $errors["company"] = "Company is required.";
    }
    if ($phone === "" || !preg_match("/^[0-9+/-()/s]{7,20}$/", $phone)) {
        $errors["phone"] = "Please enter a valid phone number.";
    }
    if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "Please enter a valid email address.";
    }
    if ($eventType === "") {
        $errors["event_type"] = "Event type is required.";
    }
    if ($location === "") {
        $errors["location"] = "Location is required.";
    }
    if ($budget === "") {
        $errors["budget"] = "Budget is required.";
    }
    if ($message === "" || mb_strlen($message) < 10) {
        $errors["message"] = "Message must be at least 10 characters.";
    }

    $dateObj = DateTime::createFromFormat("Y-m-d", $eventDate);
    if (!$dateObj || $dateObj->format("Y-m-d") !== $eventDate) {
        $errors["event_date"] = "Please provide a valid event date.";
    }

    if (!empty($errors)) {
        http_response_code(422);
        echo json_encode([
            "ok" => false,
            "message" => "Please fix the highlighted fields.",
            "errors" => $errors,
        ]);
        exit;
    }

    try {
        $pdo = prestigee_db();
        ensure_quotes_table($pdo);

        $stmt = $pdo->prepare(
            "INSERT INTO quotes
            (name, company, phone, email, event_type, event_date, location, budget, message, is_contacted)
            VALUES
            (:name, :company, :phone, :email, :event_type, :event_date, :location, :budget, :message, 0)"
        );

        $stmt->execute([
            ":name" => $name,
            ":company" => $company,
            ":phone" => $phone,
            ":email" => $email,
            ":event_type" => $eventType,
            ":event_date" => $eventDate,
            ":location" => $location,
            ":budget" => $budget,
            ":message" => $message,
        ]);

        echo json_encode([
            "ok" => true,
            "message" => "Quote request submitted successfully.",
        ]);
        exit;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            "ok" => false,
            "message" => "Unable to submit at the moment. Please try again.",
        ]);
        exit;
    }
}

$activePage = "quote";
include __DIR__ . "/includes/header.php";
?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "Prestigee Events",
  "url": "https://prestigeeevents.com/quote.php",
  "description": "<?php echo htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8'); ?>",
  "areaServed": "Nationwide",
  "serviceType": "Event Proposal"
}
</script>

<section class="pt-32 pb-16 px-4 md:px-8">
  <div class="max-w-4xl mx-auto glass rounded-2xl p-8 reveal">
    <h1 class="text-4xl md:text-5xl font-bold text-gold-400">Get Quote</h1>
    <p class="mt-4 text-white/75">Share your vision and we will craft a tailored premium event proposal.</p>
    <div id="quoteFeedback" class="hidden mt-6 rounded-xl px-4 py-3 text-sm"></div>
    <form id="quoteForm" class="mt-8 grid md:grid-cols-2 gap-4">
      <div>
        <input name="name" class="w-full glass rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-gold-400/60 border border-transparent" placeholder="Name" required />
      </div>
      <div>
        <input name="company" class="w-full glass rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-gold-400/60 border border-transparent" placeholder="Company" required />
      </div>
      <div>
        <input name="phone" class="w-full glass rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-gold-400/60 border border-transparent" placeholder="Phone" required />
      </div>
      <div>
        <input type="email" name="email" class="w-full glass rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-gold-400/60 border border-transparent" placeholder="Email" required />
      </div>
      <div>
        <input name="event_type" class="w-full glass rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-gold-400/60 border border-transparent" placeholder="Event Type" required />
      </div>
      <div>
        <input type="date" name="event_date" class="w-full glass rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-gold-400/60 border border-transparent text-white/80" required />
      </div>
      <div>
        <input name="location" class="w-full glass rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-gold-400/60 border border-transparent" placeholder="Location" required />
      </div>
      <div>
        <input name="budget" class="w-full glass rounded-xl px-4 py-3 outline-none focus:ring-2 focus:ring-gold-400/60 border border-transparent" placeholder="Budget" required />
      </div>
      <div class="md:col-span-2">
        <textarea name="message" class="w-full glass rounded-xl px-4 py-3 h-36 outline-none focus:ring-2 focus:ring-gold-400/60 border border-transparent" placeholder="Message" required></textarea>
      </div>
      <button id="quoteSubmit" class="btn-glow w-fit px-6 py-3 rounded-xl bg-gold-500 text-black font-semibold md:col-span-2" type="submit">Get Quote</button>
    </form>
  </div>
</section>
<?php include __DIR__ . "/includes/footer.php"; ?>

