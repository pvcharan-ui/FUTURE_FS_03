<?php
require_once __DIR__ . '/../includes/admin_auth.php';
require_admin();
require_once __DIR__ . '/../includes/db.php';
$res = $mysqli->query("SELECT id, name, email, message, created_at FROM contacts ORDER BY created_at DESC");
$rows = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
require_once __DIR__ . '/../includes/header.php';
?>
<section class="section">
  <h2>Contact messages</h2>
  <table class="admin-table">
    <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Message</th><th>When</th></tr></thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?= (int)$r['id'] ?></td>
          <td><?= htmlspecialchars($r['name']) ?></td>
          <td><?= htmlspecialchars($r['email']) ?></td>
          <td><?= nl2br(htmlspecialchars($r['message'])) ?></td>
          <td><?= htmlspecialchars($r['created_at']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
