<?php
// admin/index.php
require_once __DIR__ . '/../includes/admin_auth.php';
require_admin();
require_once __DIR__ . '/../includes/db.php';
?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>

<section class="section">
  <h2>Admin Dashboard</h2>
  <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px,1fr)); gap:18px; margin-top:18px;">
    <div class="card">
      <?php
        $r = $mysqli->query("SELECT COUNT(*) AS c FROM products")->fetch_assoc();
        $pcount = $r['c'] ?? 0;
      ?>
      <strong style="font-size:1.2rem;"><?= (int)$pcount ?></strong>
      <div style="color:var(--muted); margin-top:6px;">Products</div>
      <div style="margin-top:10px;"><a href="/FUTURE_FS_03/admin/products.php" class="cta">Manage products</a></div>
    </div>

    <div class="card">
      <?php
        $r2 = $mysqli->query("SELECT COUNT(*) AS c FROM contacts")->fetch_assoc();
        $mcount = $r2['c'] ?? 0;
      ?>
      <strong style="font-size:1.2rem;"><?= (int)$mcount ?></strong>
      <div style="color:var(--muted); margin-top:6px;">Messages</div>
      <div style="margin-top:10px;"><a href="/FUTURE_FS_03/admin/messages.php" class="cta">View messages</a></div>
    </div>

    <div class="card">
      <strong style="font-size:1.2rem;"><?= htmlspecialchars($_SESSION['admin_user'] ?? 'admin') ?></strong>
      <div style="color:var(--muted); margin-top:6px;">Logged in</div>
      <div style="margin-top:10px;">
        <a href="/FUTURE_FS_03/admin/logout.php" class="btn" style="background:#fff;color:var(--primary);">Logout</a>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
