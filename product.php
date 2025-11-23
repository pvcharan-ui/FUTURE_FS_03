<?php require 'includes/header.php'; ?>
<?php require 'includes/db.php'; ?>

<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
  header("Location: /FUTURE_FS_03/products.php");
  exit;
}

$stmt = $mysqli->prepare("SELECT id, sku, title, description, price, image, stock FROM products WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$product = $res->fetch_assoc();
$stmt->close();

if (!$product) {
  echo '<div class="section"><p>Product not found.</p></div>';
  require 'includes/footer.php';
  exit;
}
?>

<section class="section reveal stagger-1" style="padding-top:18px;">
  <div style="display:grid; grid-template-columns: 1fr 420px; gap:28px; align-items:start;">
    <div>
      <h1 style="margin-top:0;"><?= htmlspecialchars($product['title']) ?></h1>
      <p style="color:var(--muted);"><?= nl2br(htmlspecialchars($product['description'])) ?></p>

      <p style="font-size:1.2rem; font-weight:700; margin-top:14px;">₹ <?= number_format($product['price'], 2) ?></p>

      <?php if ($product['stock'] > 0): ?>
        <form method="post" action="/FUTURE_FS_03/add_to_cart.php" style="margin-top:12px;">
          <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
          <label for="qty">Quantity</label>
          <input id="qty" name="qty" type="number" min="1" max="<?= (int)$product['stock'] ?>" value="1" class="input" style="width:110px;">
          <div style="margin-top:12px;">
            <button class="btn" type="submit">Add to cart</button>
            <a href="/FUTURE_FS_03/cart.php" style="margin-left:12px; text-decoration:none; font-weight:600;">View cart</a>
          </div>
        </form>
      <?php else: ?>
        <div style="margin-top:12px; color:#b91c1c; font-weight:700;">Out of stock</div>
      <?php endif; ?>
    </div>

    <aside style="background:var(--surface); padding:16px; border-radius:12px; border:1px solid var(--card-border);">
      <img src="/FUTURE_FS_03/public/assets/products/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['title']) ?>" style="width:100%; border-radius:8px; object-fit:cover;">
      <div style="margin-top:12px; color:var(--muted);">SKU: <?= htmlspecialchars($product['sku']) ?></div>
      <div style="margin-top:8px; color:var(--muted);">Stock: <?= (int)$product['stock'] ?></div>
    </aside>
  </div>
</section>

<?php require 'includes/footer.php'; ?>
