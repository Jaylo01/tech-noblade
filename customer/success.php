<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - Tech Noblade</title>
    <link rel="icon" type="image/jpeg" href="../assets/images/logo.jpeg">
    <link rel="stylesheet" href="../assets/css/main-bundle.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/css/receipt.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/css/responsive.css?v=<?= time() ?>">
</head>
<body class="bg-f8faff">
    <header class="navbar">
        <div class="container">
            <a href="../index.php" class="logo-link">
                <h2 class="logo"><img src="../assets/images/logo.jpeg" class="logo-img" alt="Tech Noblade Logo"> Tech Noblade</h2>
                <span class="tagline-nav">"Smart Solutions for Phones and Gamers."</span>
            </a>
        </div>
    </header>

    <div class="success-container">
        <div class="success-card">
            <div class="success-icon-check">✓</div>
            <h1 class="color-tech-dark mb-10">Payment Confirmed!</h1>
            <p class="color-666 mb-30 lh-1-6">
                Thank you for your purchase. Your payment has been verified and your order is now being processed.
            </p>
            
            <?php if(isset($_GET['orderId'])): ?>
            <div class="order-id-badge-container">
                <p class="fs-0-9 color-tech-blue font-weight-800">Order ID: <?php echo htmlspecialchars($_GET['orderId']); ?></p>
            </div>
            <?php endif; ?>

            <div class="flex-column gap-15">
                <a href="receipt.php?orderId=<?php echo htmlspecialchars($_GET['orderId'] ?? ''); ?>" class="btn btn-primary btn-full">View Digital Receipt</a>
                <a href="../index.php" class="btn btn-light btn-full">Back to Home</a>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-bottom">
            <p>&copy; 2026 Tech Noblade & Top Up. All rights reserved.</p>
        </div>
    </footer>
<?php include '../shared/partials/auth-modal.php'; ?>
</body>
</html>
