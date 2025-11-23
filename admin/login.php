<?php
// admin/login.php
require_once __DIR__ . '/../includes/admin_users.php';
if (session_status() === PHP_SESSION_NONE) session_start();

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = $_POST['username'] ?? '';
    $p = $_POST['password'] ?? '';

    // simple check - for production use hashed passwords
    if ($u === $ADMIN_USER && $p === $ADMIN_PASS) {
        $_SESSION['is_admin'] = true;
        $_SESSION['admin_user'] = $u;
        header('Location: /FUTURE_FS_03/admin/');
        exit;
    } else {
        $err = 'Invalid username or password.';
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin Login — Rebrand Demo</title>
  <link rel="stylesheet" href="/FUTURE_FS_03/public/css/style.css">
  <style>
    .admin-login { max-width:420px; margin:60px auto; }
    .admin-login .card { padding:22px; }
    .form-row { margin-bottom:12px; }
  </style>
</head>
<body>
<?php require_once __DIR__ . '/../includes/header.php'; ?>

<section class="section admin-login">
  <div class="card">
    <h2>Admin login</h2>
    <?php if ($err): ?>
      <div class="alert alert-error"><?= htmlspecialchars($err) ?></div>
    <?php endif; ?>
    <form method="post">
      <div class="form-row">
        <label>Username</label>
        <input class="input" name="username" required autofocus>
      </div>
      <div class="form-row">
        <label>Password</label>
        <input class="input" name="password" type="password" required>
      </div>
      <div style="display:flex; gap:8px; align-items:center;">
        <button class="btn" type="submit">Sign in</button>
        <a href="/FUTURE_FS_03/" style="text-decoration:none; color:var(--muted);">Back to site</a>
      </div>
    </form>
    <p style="color:var(--muted); margin-top:12px; font-size:0.92rem;">
      Demo credentials: <strong>admin / admin123</strong> — change in <code>includes/admin_users.php</code>.
    </p>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
