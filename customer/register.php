<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account – Tech Noblade</title>
    <link rel="icon" type="image/jpeg" href="../assets/images/logo.jpeg">
    <link rel="stylesheet" href="../assets/css/main-bundle.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/css/auth.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/css/responsive.css?v=<?= time() ?>">
</head>
<body class="auth-body">
    <div class="auth-card">
        <img src="../assets/images/logo.jpeg" alt="Tech Noblade Logo" class="auth-logo">
        <div class="auth-title">Create Account</div>
        <div class="auth-sub">Join Tech Noblade to track your orders &amp; services</div>

        <div id="reg-error" class="error-msg"></div>
        <div id="reg-success" class="success-msg"></div>

        <form id="register-form">
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" class="form-input" placeholder="Juan Dela Cruz" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="you@example.com" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="pw-wrapper">
                    <input type="password" id="password" name="password" class="form-input pr-44" placeholder="Min. 6 characters" required>
                    <button type="button" class="pw-toggle" onclick="togglePw('password', this)">
                        <img src="../assets/images/icon-eye.svg" alt="Show password">
                    </button>
                </div>
                <p class="password-hint">At least 6 characters</p>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <div class="pw-wrapper">
                    <input type="password" id="confirm_password" name="confirm_password" class="form-input pr-44" placeholder="Re-enter password" required>
                    <button type="button" class="pw-toggle" onclick="togglePw('confirm_password', this)">
                        <img src="../assets/images/icon-eye.svg" alt="Show password">
                    </button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-full" id="reg-btn">Create Account</button>
        </form>

        <div class="divider"></div>
        <div class="auth-links">
            Already have an account? <a href="login.php">Sign In</a>
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
        document.getElementById('register-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            const btn = document.getElementById('reg-btn');
            const errEl = document.getElementById('reg-error');
            const sucEl = document.getElementById('reg-success');
            errEl.style.display = 'none';
            sucEl.style.display = 'none';
            btn.textContent = 'Creating account…';
            btn.disabled = true;

            const res = await fetch('../api/auth_register.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    full_name:        document.getElementById('full_name').value,
                    email:            document.getElementById('email').value,
                    password:         document.getElementById('password').value,
                    confirm_password: document.getElementById('confirm_password').value
                })
            });
            const data = await res.json();
            if (data.success) {
                sucEl.textContent = 'Account created! Redirecting…';
                sucEl.style.display = 'block';
                window.location.href = data.redirect;
            } else {
                errEl.textContent = data.error || 'Registration failed.';
                errEl.style.display = 'block';
                btn.textContent = 'Create Account';
                btn.disabled = false;
            }
        });
    </script>
<?php include '../shared/partials/auth-modal.php'; ?>
</body>
</html>
