<?php
session_start();
$tour = isset($_GET['tour']) ? preg_replace('/[^a-zA-Z0-9\-]/','', $_GET['tour']) : '';
if (!isset($_SESSION['username'])) {
  $_SESSION['flash_error'] = 'Please log in first to join a tour.';
  $ret = 'join.php' . ($tour ? ('?tour=' . urlencode($tour)) : '');
  header('Location: login.php?return=' . urlencode($ret));
  exit;
}
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Join Tour • Roaming Soul</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body class="registration-page">
  <div id="appLoader" class="lottie-loader" role="status" aria-live="polite" aria-label="Loading registration page">
    <dotlottie-wc src="https://lottie.host/2d14eb0f-28b0-4d21-ac17-9a12f9404d3b/DEKcVcQZ2y.lottie" speed="1" autoplay loop></dotlottie-wc>
    <p class="loader-tip">Loading...</p>
  </div>
  <nav class="navbar white" style="position:fixed;top:0;left:0;right:0;">
    <a href="index.php" class="logo" aria-label="Roaming Soul Home" style="text-decoration:none;color:inherit;display:flex;align-items:center;gap:.4rem;">
      <img src="essentials/Logo.png" alt="Roaming Soul Logo" />
      <span class="logo-text" style="color:#1f2933;text-shadow:none;">Roaming Soul</span>
    </a>
    <ul class="nav-menu">
      <li><a href="index.php#home" class="nav-link">Home</a></li>
      <li><a href="index.php#adventures" class="nav-link">Adventures</a></li>
    </ul>
  </nav>
  <div class="join-wrapper" id="joinCard">
    <h1 id="joinHeading">Join Tour</h1>
    <p class="lead" id="joinLead">Complete the form below to reserve your spots.</p>
    <form id="joinForm" novalidate>
      <div class="two">
        <label class="field" id="field-name"><span>Name</span><input type="text" id="name" required minlength="3" placeholder="At least 3 letters" autocomplete="name" value="<?php echo htmlspecialchars($_SESSION['username'] ?? '', ENT_QUOTES); ?>"><div class="error-msg" data-for="name"></div></label>
        <label class="field" id="field-email"><span>Email</span><input type="email" id="email" required placeholder="name@example.com" autocomplete="email"><div class="error-msg" data-for="email"></div></label>
      </div>
      <div class="two">
        <label class="field" id="field-phone"><span>Phone</span><input type="tel" id="phone" required placeholder="11 digit phone" autocomplete="tel" pattern="^\d{11}$"><div class="error-msg" data-for="phone"></div></label>
        <label class="field" id="field-party"><span>Number of people (if anyone is going with you)</span><input type="number" id="party" min="0" step="1" placeholder="Leave blank = going alone" ><div class="error-msg" data-for="party"></div></label>
      </div>
      <div class="two">
        <label class="field" id="field-gender"><span>Gender</span>
          <select id="gender" required>
            <option value="">Select...</option>
            <option value="Male">Male ♂️</option>
            <option value="Female">Female ♀️</option>
            <option value="Other">Other ⚧️</option>
          </select>
          <div class="error-msg" data-for="gender"></div>
        </label>
        <label class="field" id="field-notes"><span>Additional Notes (optional)</span><textarea id="notes" rows="3" placeholder="Anything we should know?"></textarea></label>
      </div>
      <p class="note">Rules: Name ≥ 3 letters · Email valid · Phone = 11 digits · Field counts companions only (blank = going alone).</p>
      <button type="submit">Confirm & Join</button>
      <div class="success" id="successMsg" role="status" aria-live="polite">Saved! Redirecting back to tour...</div>
      <div class="aria-status" id="liveErrors" aria-live="assertive"></div>
    </form>
    <a class="back-link" id="backLink" href="#">← Back</a>
  </div>
  <script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.6.2/dist/dotlottie-wc.js" type="module"></script>
  <script>
    // Reuse registration page logic by enabling the same JS path and params
    document.body.classList.add('registration-page');
    const t = <?php echo json_encode($tour, JSON_UNESCAPED_UNICODE|JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT); ?>;
    const backMap = {
      'sundarbans':'shundarban.html',
      'bandarban':'bandarban.html',
      'sylhet':'sylhet.html',
      'rangamati':'rangamati.html',
      'saint-martins':'sentmartin.html',
      'coxs-bazar':'coxs-bazar.html'
    };
    window.history.replaceState({}, '', 'join.php' + (t?('?tour='+encodeURIComponent(t)):'') );
  </script>
  <script src="script.js"></script>
  <script>
    // Set dynamic heading/lead and back link same as registration page
    (function(){
      const heading=document.getElementById('joinHeading');
      const lead=document.getElementById('joinLead');
      const backLink=document.getElementById('backLink');
      function formatTitle(k){ return (k||'').replace(/-/g,' ').replace(/\b\w/g,ch=>ch.toUpperCase()); }
      if(t){
        if(heading) heading.textContent='Join ' + formatTitle(t) + ' Tour';
        if(lead) lead.textContent='Tell us how many people are joining the ' + formatTitle(t) + ' adventure.';
        if(backLink) backLink.href = backMap[t] || 'index.php#adventures';
      } else {
        if(backLink) backLink.href = 'index.php#adventures';
      }
    })();
  </script>
</body>
</html>
