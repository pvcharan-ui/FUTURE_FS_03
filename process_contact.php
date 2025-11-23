<?php
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /FUTURE_FS_03/contact.php");
    exit;
}

// simple sanitization
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '') {
    header("Location: /FUTURE_FS_03/contact.php?error=empty");
    exit;
}

/* Ensure contacts table exists (safe guard) */
$create_sql = "
CREATE TABLE IF NOT EXISTS contacts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";

if (!$mysqli->query($create_sql)) {
    error_log('Failed to create contacts table: ' . $mysqli->error);
    header("Location: /FUTURE_FS_03/contact.php?error=dbcreate");
    exit;
}

/* Insert using prepared statement */
$stmt = $mysqli->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
if (!$stmt) {
    error_log("Prepare failed: " . $mysqli->error);
    header("Location: /FUTURE_FS_03/contact.php?error=prepare");
    exit;
}

$stmt->bind_param('sss', $name, $email, $message);
$ok = $stmt->execute();
if (!$ok) {
    error_log("Execute failed: " . $stmt->error);
    header("Location: /FUTURE_FS_03/contact.php?error=execute");
    $stmt->close();
    exit;
}

$stmt->close();
header("Location: /FUTURE_FS_03/contact.php?success=1");
exit;
