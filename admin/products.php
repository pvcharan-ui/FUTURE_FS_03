<?php
// admin/products.php
require_once __DIR__ . '/../includes/admin_auth.php';
require_admin();
require_once __DIR__ . '/../includes/db.php';

$errors = [];
$info = '';

// Handle create / update / delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'create') {
        $sku = trim($_POST['sku'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $desc = trim($_POST['description'] ?? '');
        $price = (float)$_POST['price'] ?? 0.0;
        $stock = (int)($_POST['stock'] ?? 0);
        $imageName = trim($_POST['image_name'] ?? ''); // optional filename

        // handle file upload
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {
            $up = $_FILES['image'];
            $ext = pathinfo($up['name'], PATHINFO_EXTENSION);
            $imageName = 'prod_' . time() . '.' . $ext;
            $dest = __DIR__ . '/../public/assets/products/' . $imageName;
            move_uploaded_file($up['tmp_name'], $dest);
        }

        if ($sku === '' || $title === '') {
            $errors[] = 'SKU and Title are required.';
        } else {
            $stmt = $mysqli->prepare("INSERT INTO products (sku, title, description, price, image, stock) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sssisi', $sku, $title, $desc, $price, $imageName, $stock);
            if ($stmt->execute()) {
                $info = 'Product created.';
            } else {
                $errors[] = 'DB error: ' . $stmt->error;
            }
            $stmt->close();
        }
    }

    elseif ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        // delete row
        $stmt = $mysqli->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            $info = 'Product deleted.';
        } else $errors[] = 'DB error: ' . $stmt->error;
        $stmt->close();
    }

    elseif ($action === 'update') {
        $id = (int)($_POST['id'] ?? 0);
        $sku = trim($_POST['sku'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $desc = trim($_POST['description'] ?? '');
        $price = (float)($_POST['price'] ?? 0.0);
        $stock = (int)($_POST['stock'] ?? 0);
        $imageName = trim($_POST['image_name'] ?? '');

        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {
            $up = $_FILES['image'];
            $ext = pathinfo($up['name'], PATHINFO_EXTENSION);
            $imageName = 'prod_' . time() . '.' . $ext;
            $dest = __DIR__ . '/../public/assets/products/' . $imageName;
            move_uploaded_file($up['tmp_name'], $dest);
        }

        $stmt = $mysqli->prepare("UPDATE products SET sku=?, title=?, description=?, price=?, image=?, stock=? WHERE id=?");
        $stmt->bind_param('sssdssi', $sku, $title, $desc, $price, $imageName, $stock, $id);
        if ($stmt->execute()) $info = 'Product updated.';
        else $errors[] = 'DB error: ' . $stmt->error;
        $stmt->close();
    }
}

// Fetch list
$res = $mysqli->query("SELECT id, sku, title, price, image, stock FROM products ORDER BY created_at DESC");
$products = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
?>
<?php require_once __DIR__ . '/../includes/header.php'; ?>

<section class="section">
  <h2>Manage Products</h2>

  <?php if ($info): ?>
    <div class="alert alert-success"><?= htmlspecialchars($info) ?></div>
  <?php endif; ?>
  <?php if ($errors): foreach ($errors as $e): ?>
    <div class="alert alert-error"><?= htmlspecialchars($e) ?></div>
  <?php endforeach; endif; ?>

  <div style="display:grid; grid-template-columns: 1fr 380px; gap:20px; align-items:start;">
    <div>
      <h3>Products list</h3>
      <table class="admin-table">
        <thead><tr><th>ID</th><th>Title</th><th>Price</th><th>Stock</th><th>Actions</th></tr></thead>
        <tbody>
          <?php foreach ($products as $p): ?>
            <tr>
              <td><?= (int)$p['id'] ?></td>
              <td><?= htmlspecialchars($p['title']) ?></td>
              <td>₹ <?= number_format($p['price'],2) ?></td>
              <td><?= (int)$p['stock'] ?></td>
              <td>
                <a href="/FUTURE_FS_03/admin/products.php?edit=<?= (int)$p['id'] ?>" style="margin-right:8px;">Edit</a>
                <form method="post" style="display:inline" onsubmit="return confirm('Delete this product?');">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                  <button type="submit" style="background:none;border:none;color:#b91c1c;cursor:pointer;">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <aside style="background:var(--surface); padding:16px; border-radius:12px; border:1px solid var(--card-border);">
      <h3 style="margin-top:0;">Add product</h3>
      <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="create">
        <label>SKU</label>
        <input class="input" name="sku" required>
        <label>Title</label>
        <input class="input" name="title" required>
        <label>Description</label>
        <textarea class="input" name="description" rows="4"></textarea>
        <label>Price</label>
        <input class="input" name="price" type="number" step="0.01" required>
        <label>Stock</label>
        <input class="input" name="stock" type="number" value="0" required>
        <label>Image (upload optional)</label>
        <input type="file" name="image" accept="image/*">
        <div style="margin-top:10px;">
          <button class="btn" type="submit">Create product</button>
        </div>
      </form>

      <?php if (isset($_GET['edit'])):
        $eid = (int)$_GET['edit'];
        $stmt = $mysqli->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param('i',$eid);
        $stmt->execute();
        $edit = $stmt->get_result()->fetch_assoc();
        $stmt->close();
      ?>
      <hr>
      <h3>Edit product</h3>
      <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?= (int)$edit['id'] ?>">
        <label>SKU</label>
        <input class="input" name="sku" value="<?= htmlspecialchars($edit['sku']) ?>" required>
        <label>Title</label>
        <input class="input" name="title" value="<?= htmlspecialchars($edit['title']) ?>" required>
        <label>Description</label>
        <textarea class="input" name="description" rows="4"><?= htmlspecialchars($edit['description']) ?></textarea>
        <label>Price</label>
        <input class="input" name="price" type="number" step="0.01" value="<?= htmlspecialchars($edit['price']) ?>" required>
        <label>Stock</label>
        <input class="input" name="stock" type="number" value="<?= (int)$edit['stock'] ?>" required>
        <label>Image name (leave blank to keep)</label>
        <input class="input" name="image_name" value="<?= htmlspecialchars($edit['image']) ?>">
        <label>Replace image (optional)</label>
        <input type="file" name="image" accept="image/*">
        <div style="margin-top:10px;"><button class="btn" type="submit">Save changes</button></div>
      </form>
      <?php endif; ?>
    </aside>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
