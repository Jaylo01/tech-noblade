<?php
// api/auth_logout.php
if (session_status() === PHP_SESSION_NONE) session_start();
$role = $_SESSION['role'] ?? 'customer';

session_unset();
session_destroy();

// Redirect paths corrected for reorganization
if ($role === 'admin') {
    header('Location: ../admin/login.php');
} else {
    header('Location: ../customer/login.php');
}
exit;
?>
