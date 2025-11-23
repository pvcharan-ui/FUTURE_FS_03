<?php
require 'includes/header.php';
require 'includes/db.php';

// --- simple search + pagination params
$search = trim($_GET['q'] ?? '');
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 8;
$offset = ($page - 1) * $perPage;

// Build where clause safely
$where = "";
$params = [];
$types = "";
if ($search !== '') {
    $where = "WHERE title LIKE CONCAT('%', ?, '%') OR sku LIKE CONCAT('%', ?, '%')";
    $params[] = $search; $params[] = $search;
    $types .= "ss";
}

// Count total
$countSql = "SELECT COUNT(*) AS cnt FROM products $where";
if ($stmt = $mysqli->prepare($countSql)) {
    if ($types) $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $res = $stmt->get_result();
    $total = ($row = $res->fetch_assoc()) ? (int)$row['cnt'] : 0;
    $stmt->close();
} else {
    $total = 0;
}
$totalPages = max(1, (int)ceil($total / $perPage));

// Fetch paginated rows
$listSql = "SELECT id, sku, title, price, image, stock FROM products $where ORDER BY created_at DESC LIMIT ? OFFSET ?";
if ($stmt = $mysqli->prepare($listSql)) {
    // bind dynamic params
    if ($types) {
        // append types for limit/offset
        $typesAll = $types . "ii";
        $paramsAll = array_merge($params, [$perPage, $offset]);
        // bind_param requires variables
        $bind_names[] = $typesAll;
        foreach ($paramsAll as $key => $val) {
            $bind_name = 'bind' . $key;
            $$bind_name = $val;
            $bind_names[] = &$$bind_name;
        }
        call_user_func_array([$stmt, 'bind_param'], $bind_names);
    } else {
        $stmt->bind_param('ii', $perPage, $offset);
    }
    $stmt->execute();
    $res = $stmt->get_result();
} else {
    $res = false;
}
?>

<section class="section reveal stagger-1" style="padding-top:18px;">
  <div style="display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:18px;">
    <h2 style="font-size:1.6rem; margin:0;">Shop — Products</h2>

    <form method="get" style="margin:0;">
      <input type="search" name="q" value="<?= htmlspecialchars($search) ?>" placeholder="Search products or SKU" style="padding:8px 12px; border-radius:8px; border:1px solid rgba(0,0,0,0.06);">
      <button type="submit" class="btn" style="padding:8px 12px; margin-left:8px;">Search</button>
    </form>
  </div>

  <?php if ($res && $res->num_rows > 0): ?>
    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap:20px;">
      <?php while ($row = $res->fetch_assoc()): ?>
        <div class="card reveal" style="display:flex; flex-direction:column; justify-content:space-between; min-height:300px;">
          <div style="position:relative; padding-bottom:56%; overflow:hidden; border-radius:10px; background:#fff; border:1px solid rgba(0,0,0,0.03);">
            <img src="/FUTURE_FS_03/public/assets/products/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['title']) ?>" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">
          </div>

          <div style="padding:12px 6px;">
            <h3 style="margin:6px 0 8px; font-size:1.05rem;"><?= htmlspecialchars($row['title']) ?></h3>
            <div style="color:var(--muted); font-size:0.95rem; margin-bottom:8px;">SKU: <?= htmlspecialchars($row['sku']) ?></div>
            <div style="font-weight:800; margin-bottom:12px;">₹ <?= number_format($row['price'], 2) ?></div>

            <div style="display:flex; gap:8px; align-items:center;">
              <a href="/FUTURE_FS_03/product.php?id=<?= (int)$row['id'] ?>" class="btn" style="background:#fff; border:1px solid rgba(0,0,0,0.06); color:var(--primary); padding:8px 10px; text-decoration:none;">View</a>

              <?php if ($row['stock'] > 0): ?>
                <form method="post" action="/FUTURE_FS_03/add_to_cart.php" style="display:inline-block; margin:0;">
                  <input type="hidden" name="product_id" value="<?= (int)$row['id'] ?>">
                  <input type="hidden" name="qty" value="1">
                  <button class="cta" type="submit" style="padding:8px 12px;">Add to cart</button>
                </form>
              <?php else: ?>
                <div style="color:#b91c1c; font-weight:700;">Out of stock</div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <!-- Pagination -->
    <div style="display:flex; justify-content:center; margin-top:24px; gap:8px; align-items:center;">
      <?php if ($page > 1): ?>
        <a href="?<?= ($search !== '' ? 'q='.urlencode($search).'&' : '') ?>page=<?= $page-1 ?>" class="btn" style="background:#fff; border:1px solid rgba(0,0,0,0.06);">Prev</a>
      <?php endif; ?>

      <div style="padding:6px 10px; color:var(--muted);">Page <?= $page ?> of <?= $totalPages ?></div>

      <?php if ($page < $totalPages): ?>
        <a href="?<?= ($search !== '' ? 'q='.urlencode($search).'&' : '') ?>page=<?= $page+1 ?>" class="btn" style="background:#fff; border:1px solid rgba(0,0,0,0.06);">Next</a>
      <?php endif; ?>
    </div>

  <?php else: ?>
    <div class="card">
      <p style="margin:0;">No products found. <a href="/FUTURE_FS_03/products.php">Clear search</a> or add products in phpMyAdmin.</p>
    </div>
  <?php endif; ?>

</section>

<?php
if (isset($stmt) && $stmt) $stmt->close();
require 'includes/footer.php';
