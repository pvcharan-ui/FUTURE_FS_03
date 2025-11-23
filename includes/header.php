<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nike — Reimagined</title>
  <link rel="stylesheet" href="/FUTURE_FS_03/public/css/style.css">
</head>

<body>
<header class="site-header">
  <div class="container header-inner">

    <a href="/FUTURE_FS_03/">
      <img src="/FUTURE_FS_03/public/assets/logo.jpg" class="logo" alt="Logo">
    </a>

    <nav class="nav">
      <a href="/FUTURE_FS_03/">Home</a>
      <a href="/FUTURE_FS_03/products.php">Shop</a>
      <a href="/FUTURE_FS_03/about.php">About</a>
      <a href="/FUTURE_FS_03/contact.php">Contact</a>

      <!-- If admin logged in, show admin dashboard + logout -->
      <?php if (!empty($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
        <a href="/FUTURE_FS_03/admin/">Admin</a>
        <a href="/FUTURE_FS_03/admin/logout.php" style="color:#b91c1c;">Logout</a>
      <?php else: ?>
        <!-- If not logged in, show login -->
        <a href="/FUTURE_FS_03/admin/login.php">Login</a>
      <?php endif; ?>
    </nav>
  </div>
</header>

<main class="container">
