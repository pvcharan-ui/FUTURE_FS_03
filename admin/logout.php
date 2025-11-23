<?php
// admin/logout.php
if (session_status() === PHP_SESSION_NONE) session_start();
session_unset();
session_destroy();
header('Location: /FUTURE_FS_03/admin/login.php');
exit;
