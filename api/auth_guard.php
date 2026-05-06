<?php
// php/auth_guard.php
// Include this at the top of any page that requires a logged-in customer.
// Usage: require_once '../php/auth_guard.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['customer_id']) || ($_SESSION['role'] ?? '') !== 'customer') {
    // Determine path to customer/login.php based on current location
    $current_dir = basename(dirname($_SERVER['SCRIPT_NAME']));
    $prefix = ($current_dir === 'customer' || $current_dir === 'admin' || $current_dir === 'shared') ? '../' : '';
    header('Location: ' . $prefix . 'customer/login.php');
    exit;
}
?>
