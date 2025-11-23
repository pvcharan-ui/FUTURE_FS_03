<?php require 'includes/header.php'; ?>

<?php
// Read success/error flags from query params (set by process_contact.php)
$showSuccess = (isset($_GET['success']) && $_GET['success'] == '1');
$errorCode = $_GET['error'] ?? null;

// Map simple error messages (you can expand these)
$errorMessage = null;
if ($errorCode) {
    if ($errorCode === 'empty') $errorMessage = 'Please fill all required fields.';
    elseif ($errorCode === 'dbcreate') $errorMessage = 'Temporary database issue. Try again later.';
    elseif ($errorCode === 'prepare' || $errorCode === 'execute') $errorMessage = 'Server error. Message not saved.';
    else $errorMessage = 'An unexpected error occurred. Please try again.';
}
?>

<section class="section">
  <h2 style="font-size:1.6rem; margin-bottom:8px;">Contact</h2>

  <!-- Alerts area -->
  <div id="alerts-region" aria-live="polite" aria-atomic="true" style="margin-bottom:18px;">
    <?php if ($showSuccess): ?>
      <div class="alert alert-success reveal active" id="contact-alert" role="status" style="display:flex; align-items:center; justify-content:space-between;">
        <div style="display:flex; gap:12px; align-items:center;">
          <!-- lightweight check icon (svg) -->
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M20 6L9 17l-5-5" stroke="#065f46" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <div>
            <strong>Message sent</strong>
            <div style="font-weight:600; color: #044d47; font-size:0.95rem;">Thank you — I will respond soon.</div>
          </div>
        </div>

        <button aria-label="Dismiss success message" id="alert-close" style="background:none;border:none;font-weight:700;cursor:pointer;color:#044d47;padding:6px;">✕</button>
      </div>
    <?php elseif ($errorMessage): ?>
      <div class="alert alert-error reveal active" id="contact-alert" role="status" style="display:flex; align-items:center; justify-content:space-between;">
        <div style="display:flex; gap:12px; align-items:center;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
            <path d="M12 8v4m0 4h.01" stroke="#7f1d1d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M10 3h4l6 6v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a3 3 0 0 1 3-3z" stroke="#7f1d1d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <div>
            <strong>Could not send</strong>
            <div style="color:#9f1239; font-size:0.95rem; font-weight:600;"><?= htmlspecialchars($errorMessage) ?></div>
          </div>
        </div>

        <button aria-label="Dismiss error message" id="alert-close-error" style="background:none;border:none;font-weight:700;cursor:pointer;color:#9f1239;padding:6px;">✕</button>
      </div>
    <?php endif; ?>
  </div>

  <!-- Contact form -->
  <form class="contact-form" method="post" action="/FUTURE_FS_03/process_contact.php" novalidate>
    <label for="name">Name</label>
    <input id="name" class="input" type="text" name="name" required maxlength="100">

    <label for="email">Email</label>
    <input id="email" class="input" type="email" name="email" required maxlength="150">

    <label for="message">Message</label>
    <textarea id="message" name="message" class="input" rows="7" required></textarea>

    <button class="btn" type="submit">Send</button>
  </form>
</section>

<!-- Inline small JS for auto-dismiss and accessibility -->
<script>
(function(){
  // Auto-dismiss configuration (milliseconds)
  const AUTO_DISMISS_MS = 4000;
  const FADE_DURATION_MS = 420;

  // Utility to gracefully hide an element
  function gracefulDismiss(el) {
    if (!el) return;
    // add transitioning style
    el.style.transition = `opacity ${FADE_DURATION_MS}ms ease, transform ${FADE_DURATION_MS}ms ease`;
    el.style.opacity = '0';
    el.style.transform = 'translateY(-8px)';
    // remove after animation
    setTimeout(() => {
      if (el && el.parentNode) el.parentNode.removeChild(el);
    }, FADE_DURATION_MS + 50);
  }

  const alertEl = document.getElementById('contact-alert');
  if (alertEl) {
    // If there is an explicit close button
    const closeBtn = document.getElementById('alert-close') || document.getElementById('alert-close-error');
    if (closeBtn) {
      closeBtn.addEventListener('click', function(e){
        e.preventDefault();
        gracefulDismiss(alertEl);
      });
    }
    // Auto-dismiss after timeout
    setTimeout(() => gracefulDismiss(alertEl), AUTO_DISMISS_MS);
    // Make sure it's focusable/readable for keyboard users
    alertEl.setAttribute('tabindex','0');
    alertEl.focus({preventScroll: true});
  }
})();
</script>

<?php require 'includes/footer.php'; ?>
