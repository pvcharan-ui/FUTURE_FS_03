<?php require 'includes/header.php'; ?>
<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
  header("Location: /FUTURE_FS_03/products.php");
  exit;
}

// In a real site you'd process payment here.
// For the demo, clear cart and show a confirmation.
unset($_SESSION['cart']);
?>

<section class="section reveal">
  <div class="card">
    <h2>Thank you — Order placed</h2>
    <p>Your mock order has been received. For the internship demo, this is a placeholder checkout. Add payment integration to go live.</p>
    <p><a href="/FUTURE_FS_03/products.php" class="cta">Continue shopping</a></p>
  </div>
</section>

<?php require 'includes/footer.php'; ?>
