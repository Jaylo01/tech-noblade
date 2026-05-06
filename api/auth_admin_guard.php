<?php
// php/auth_admin_guard.php
// Include at the top of admin.php to require an active admin session.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $current_dir = basename(dirname($_SERVER['SCRIPT_NAME']));
    $prefix = ($current_dir === 'customer' || $current_dir === 'admin' || $current_dir === 'shared') ? '../' : '';
    header('Location: ' . $prefix . 'admin/login.php');
    exit;
}
?>
