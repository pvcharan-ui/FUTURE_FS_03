<?php require 'includes/header.php'; ?>
<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// handle updates (simple POST from form)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'update' && isset($_POST['qty']) && is_array($_POST['qty'])) {
        foreach ($_POST['qty'] as $id => $q) {
            $id = (int)$id; $q = max(0,(int)$q);
            if ($q === 0) {
                unset($_SESSION['cart'][$id]);
            } else {
                if (isset($_SESSION['cart'][$id])) $_SESSION['cart'][$id]['qty'] = $q;
            }
        }
        header("Location: /FUTURE_FS_03/cart.php?updated=1"); exit;
    }
    if ($_POST['action'] === 'clear') {
        unset($_SESSION['cart']);
        header("Location: /FUTURE_FS_03/cart.php?cleared=1"); exit;
    }
}

$cart = $_SESSION['cart'] ?? [];
$subtotal = 0.0;
foreach ($cart as $it) $subtotal += $it['price'] * $it['qty'];
?>

<section class="section reveal stagger-1" style="padding-top:18px;">
  <h2 style="font-size:1.6rem; margin-bottom:12px;">Your Cart</h2>

  <?php if (empty($cart)): ?>
    <div class="card">
      <p>Your cart is empty. <a href="/FUTURE_FS_03/products.php">Continue shopping</a></p>
    </div>
  <?php else: ?>
    <form method="post">
      <input type="hidden" name="action" value="update">
      <table class="admin-table">
        <thead>
          <tr><th>Product</th><th>Price</th><th>Qty</th><th>Total</th></tr>
        </thead>
        <tbody>
          <?php foreach ($cart as $id => $item): 
            $line = $item['price'] * $item['qty'];
          ?>
            <tr>
              <td style="display:flex; gap:12px; align-items:center;">
                <img src="/FUTURE_FS_03/public/assets/products/<?= htmlspecialchars($item['image']) ?>" alt="" style="width:64px; height:64px; object-fit:cover; border-radius:8px;">
                <div>
                  <strong><?= htmlspecialchars($item['title']) ?></strong><br>
                  <small style="color:var(--muted);">₹ <?= number_format($item['price'],2) ?></small>
                </div>
              </td>
              <td>₹ <?= number_format($item['price'],2) ?></td>
              <td><input type="number" name="qty[<?= (int)$id ?>]" value="<?= (int)$item['qty'] ?>" min="0" style="width:80px; padding:6px; border-radius:8px; border:1px solid #ddd;"></td>
              <td>₹ <?= number_format($line,2) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div style="display:flex; justify-content:space-between; align-items:center; margin-top:20px;">
        <div>
          <button type="submit" class="btn" style="margin-right:12px;">Update cart</button>
          <button type="submit" name="action" value="clear" class="btn" style="background:#f87171;">Clear cart</button>
        </div>

        <div style="text-align:right;">
          <div style="font-weight:700;">Subtotal: ₹ <?= number_format($subtotal,2) ?></div>
          <div style="color:var(--muted); font-size:0.95rem; margin-top:6px;">
            Taxes & shipping calculated at checkout.
          </div>
          <!-- Mock checkout -->
          <div style="margin-top:10px;">
            <a href="/FUTURE_FS_03/checkout.php" class="cta" style="display:inline-block;">Checkout (mock)</a>
          </div>
        </div>
      </div>
    </form>
  <?php endif; ?>
</section>

<?php require 'includes/footer.php'; ?>
