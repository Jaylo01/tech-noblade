<?php
// shared/partials/side-nav-auth.php
// Session-aware auth section for the side navigation menu.
if (session_status() === PHP_SESSION_NONE) session_start();
$_is_customer   = !empty($_SESSION['customer_id']) && ($_SESSION['role'] ?? '') === 'customer';
$_customer_name = $_is_customer ? htmlspecialchars($_SESSION['customer_name']) : '';

// Determine path to root
$current_dir = basename(dirname($_SERVER['SCRIPT_NAME']));
$prefix = ($current_dir === 'customer' || $current_dir === 'admin' || $current_dir === 'shared') ? '../' : '';
?>

<!-- Auth section -->
<hr class="nav-auth-divider">
<?php if ($_is_customer): ?>
    <span class="nav-auth-label">My Account</span>
    <a href="<?= $prefix ?>customer/dashboard.php">My Dashboard</a>
    <a href="<?= $prefix ?>customer/dashboard.php"><?= $_customer_name ?></a>
    <a href="<?= $prefix ?>api/auth_logout.php" class="nav-logout-btn">Logout</a>
<?php else: ?>
    <span class="nav-auth-label">Account</span>
    <a href="<?= $prefix ?>customer/login.php">Login</a>
    <a href="<?= $prefix ?>customer/register.php">Create Account</a>
    <hr class="nav-auth-divider-thin">
    <a href="<?= $prefix ?>admin/login.php" class="nav-admin-link">Admin Portal</a>
<?php endif; ?>
