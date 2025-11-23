<?php
// add_to_cart.php
session_start();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /FUTURE_FS_03/products.php");
    exit;
}

$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;
$qty = max(1, $qty);

// fetch product to validate
$stmt = $mysqli->prepare("SELECT id, title, price, stock, image FROM products WHERE id = ?");
$stmt->bind_param('i', $product_id);
$stmt->execute();
$res = $stmt->get_result();
$product = $res->fetch_assoc();
$stmt->close();

if (!$product) {
    header("Location: /FUTURE_FS_03/products.php?error=notfound");
    exit;
}

if ($product['stock'] < $qty) {
    header("Location: /FUTURE_FS_03/product.php?id={$product_id}&error=stock");
    exit;
}

// Ensure cart exists
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) $_SESSION['cart'] = [];

// If already in cart, increment
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['qty'] += $qty;
} else {
    $_SESSION['cart'][$product_id] = [
        'id' => (int)$product['id'],
        'title' => $product['title'],
        'price' => (float)$product['price'],
        'image' => $product['image'],
        'qty' => $qty
    ];
}

// Redirect back to cart with success
header("Location: /FUTURE_FS_03/cart.php?added=1");
exit;
