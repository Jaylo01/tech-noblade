<?php
// Determine prefix for auth links in shared modal
$current_script = $_SERVER['SCRIPT_NAME'];
$prefix = (strpos($current_script, '/customer/') !== false || strpos($current_script, '/admin/') !== false || strpos($current_script, '/shared/') !== false) ? '../' : 'customer/';
?>
<!-- Auth Required Modal -->
<div id="auth-required-modal" class="modal-overlay hidden">
    <div class="modal-card max-w-450 text-center p-40 br-20">
        <h2 class="color-tech-dark mb-15">Authentication Required</h2>
        <p class="color-666 mb-25 lh-1-6">You must be logged in to proceed with this transaction. Log in or create an account to continue.</p>
        <div class="flex-column gap-10">
            <a href="<?= (strpos($current_script, '/customer/') !== false) ? 'login.php' : $prefix . 'login.php' ?>" class="btn btn-primary">Login Now</a>
            <a href="<?= (strpos($current_script, '/customer/') !== false) ? 'register.php' : $prefix . 'register.php' ?>" class="btn btn-outline color-tech-blue">Create Account</a>
        </div>
        <button onclick="document.getElementById('auth-required-modal').style.display='none'" class="modal-btn-cancel">Cancel</button>
    </div>
</div>
