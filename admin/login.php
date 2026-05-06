<?php
// admin/login.php
session_start();
if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login – Tech Noblade</title>
    <link rel="icon" type="image/jpeg" href="../assets/images/logo.jpeg">
    <link rel="stylesheet" href="../assets/css/main-bundle.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/css/responsive.css?v=<?= time() ?>">
</head>
<body class="admin-login-body">
    <div class="admin-login-card">
        <img src="../assets/images/logo.jpeg" alt="Logo" class="admin-login-logo">
        <h1 class="color-tech-blue mb-0 font-weight-800 fs-1-5">Admin Login</h1>
        <p class="opacity-07 mb-25 fs-0-9">Access your dashboard to manage orders.</p>

        <div id="login-error" class="error-msg"></div>

        <form id="admin-login-form">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" class="form-input" value="admin@technoblade.com" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="pw-wrapper">
                    <input type="password" id="password" class="form-input pr-44" placeholder="Admin password" required>
                    <button type="button" class="pw-toggle" onclick="togglePw('password', this)">
                        <img src="../assets/images/icon-eye.svg" alt="Show password">
                    </button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-full" id="login-btn">Login to Dashboard</button>
        </form>
        <p class="mt-15"><a href="../index.php" class="nav-link-static">← Back to Website</a></p>
    </div>

    <script>
        function togglePw(inputId, btn) {
            const inp = document.getElementById(inputId);
            const img = btn.querySelector('img');
            if (inp.type === 'password') {
                inp.type = 'text';
                img.src = '../assets/images/icon-eye-off.svg';
            } else {
                inp.type = 'password';
                img.src = '../assets/images/icon-eye.svg';
            }
        }

        document.getElementById('admin-login-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = document.getElementById('login-btn');
            const errEl = document.getElementById('login-error');
            errEl.style.display = 'none';
            btn.textContent = 'Logging in…';
            btn.disabled = true;

            const res = await fetch('../api/auth_login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    email:    document.getElementById('email').value,
                    password: document.getElementById('password').value,
                    type:     'admin'
                })
            });
            const data = await res.json();
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                errEl.textContent = data.error || 'Login failed.';
                errEl.style.display = 'block';
                btn.textContent = 'Login to Dashboard';
                btn.disabled = false;
            }
        });
    </script>
<?php include '../shared/partials/auth-modal.php'; ?>
</body>
</html>
