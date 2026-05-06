<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login – Tech Noblade</title>
    <link rel="icon" type="image/jpeg" href="../assets/images/logo.jpeg">
    <link rel="stylesheet" href="../assets/css/main-bundle.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/css/auth.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/css/responsive.css?v=<?= time() ?>">
</head>
<body class="auth-body">
    <div class="auth-card">
        <img src="../assets/images/logo.jpeg" alt="Tech Noblade Logo" class="auth-logo">
        <div class="auth-title">Welcome Back</div>
        <div class="auth-sub">Sign in to your Tech Noblade account</div>

        <div id="login-error" class="error-msg"></div>

        <form id="login-form">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="you@example.com" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="pw-wrapper">
                    <input type="password" id="password" name="password" class="form-input pr-44" placeholder="Your password" required>
                    <button type="button" class="pw-toggle" onclick="togglePw('password', this)">
                        <img src="../assets/images/icon-eye.svg" alt="Show password">
                    </button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-full" id="login-btn">Sign In</button>
        </form>

        <div class="divider"></div>
        <div class="auth-links">
            Don't have an account? <a href="register.php">Create Account</a>
        </div>
        <div class="auth-links mt-15">
            <a href="../index.php">← Back to Website</a>
        </div>
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
        document.getElementById('login-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = document.getElementById('login-btn');
            const errEl = document.getElementById('login-error');
            errEl.style.display = 'none';
            btn.textContent = 'Signing in…';
            btn.disabled = true;

            const res = await fetch('../api/auth_login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    email:    document.getElementById('email').value,
                    password: document.getElementById('password').value,
                    type:     'customer'
                })
            });
            const data = await res.json();
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                errEl.textContent = data.error || 'Login failed.';
                errEl.style.display = 'block';
                btn.textContent = 'Sign In';
                btn.disabled = false;
            }
        });
    </script>
<?php include '../shared/partials/auth-modal.php'; ?>
</body>
</html>
