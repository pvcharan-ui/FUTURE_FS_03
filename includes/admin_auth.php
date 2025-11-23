<?php
// includes/admin_auth.php
if (session_status() === PHP_SESSION_NONE) session_start();

/**
 * Checks if admin is logged in.
 * Returns true/false.
 */
function is_admin_logged_in(): bool {
    return !empty($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
}

/**
 * Protect a page; redirect to admin/login.php if not logged in.
 */
function require_admin() {
    if (!is_admin_logged_in()) {
        // redirect to admin login, preserve next/url if desired
        header('Location: /FUTURE_FS_03/admin/login.php');
        exit;
    }
}
