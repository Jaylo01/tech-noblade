<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Noblade</title>
    <link rel="icon" type="image/jpeg" href="../assets/images/logo.jpeg">
    <link rel="stylesheet" href="../assets/css/main-bundle.css?v=<?= time() ?>">
</head>

<body>
    <!-- Sidebar Toggle & Menu -->
    <input type="checkbox" id="side-menu-toggle" class="side-menu-toggle">
    <div class="side-menu-overlay"></div>
    <aside class="side-menu">
        <label for="side-menu-toggle" class="close-btn close-btn-pos"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></label>
        <a href="../index.php" class="logo-link">
            <h2 class="logo"><img src="../assets/images/logo.jpeg" class="logo-img" alt="Logo"> Tech Noblade</h2>
        </a>

        <a href="../index.php">Home</a>
        <a href="products.php">Top-Up Products</a>
        <a href="repair.php">Repair Services</a>

        <a href="../shared/about.php">About</a>
        <a href="../shared/contact.php">Contact</a>

    <?php include '../shared/partials/side-nav-auth.php'; ?>
    </aside>

    <header class="navbar">
        <div class="container">
            <a href="../index.php" class="logo-link">
                <h2 class="logo"><img src="../assets/images/logo.jpeg" class="logo-img" alt="Tech Noblade Logo"> Tech Noblade</h2>
                <span class="tagline-nav">"Smart Solutions for Phones and Gamers."</span>
            </a>

            <nav>
                <ul class="nav-links">
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="../shared/about.php">About</a></li>
                    <li><a href="../shared/contact.php">Contact</a></li>
                    <li><label for="side-menu-toggle" class="nav-toggle-btn"><img src="../assets/images/icon-menu-bars.svg" class="icon-menu-img"></label></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="section-padding text-center bg-f8faff">
        <div class="container">
            <!-- Unified Status Tracker -->
            <div class="status-tracker">
                <div class="tracker-line-container">
                    <div class="tracker-line-bg"></div>
                    <div class="tracker-line-fill" id="status-progress"></div>
                    <img src="../assets/images/techno-walking_transparent.gif" id="walking-anim" class="walking-anim-pos" alt="Walking">
                </div>
                <div class="status-steps-overlay">
                    <div class="status-step" id="step1">
                        <div class="step-circle">1</div>
                        <span class="step-label">Order Placed</span>
                    </div>
                    <div class="status-step" id="step2">
                        <div class="step-circle">2</div>
                        <span class="step-label">Processing</span>
                    </div>
                    <div class="status-step" id="step3">
                        <div class="step-circle">3</div>
                        <span class="step-label">Completed</span>
                    </div>
                </div>
                <p id="status-text" class="status-label-main mt-20">Loading order status...</p>
            </div>

            <div class="receipt-box">
                <div class="receipt-header-clean">
                    <img src="../assets/images/logo.jpeg" alt="Logo" class="receipt-logo">
                    <h2 class="receipt-title">OFFICIAL RECEIPT</h2>
                </div>

                <div class="receipt-header-status">
                    <h1 class="receipt-status-success">Payment Successful!</h1>
                    <p class="color-666">Thank you for choosing Tech Noblade & Top Up.</p>
                </div>

                <!-- Main Transaction Info -->
                <div class="ref-meta-box">
                    <div class="ref-meta-row">
                        <span class="ref-meta-label">Status</span>
                        <span class="ref-meta-badge">COMPLETED</span>
                    </div>
                    <div class="ref-meta-row">
                        <span class="ref-meta-label">Reference No.</span>
                        <span id="ref-no" class="ref-meta-val">TN-83749201</span>
                    </div>
                    <div class="ref-meta-row">
                        <span class="ref-meta-label">Date & Time</span>
                        <span id="datetime" class="font-weight-500">April 02, 2026 | 05:45 PM</span>
                    </div>
                    <div class="ref-meta-row mb-0">
                        <span class="ref-meta-label">Payment Method</span>
                        <span id="payment-method" class="font-weight-800 text-uppercase color-tech-blue">GCASH</span>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="product-summary-card">
                    <h3 class="summary-card-header">Product Summary</h3>
                    
                    <div class="flex-between mb-15">
                        <div>
                            <p id="game-name" class="font-weight-800 color-333 mb-4 fs-1-0">Mobile Legends</p>
                            <p id="item-amount" class="color-666 fs-0-9">100 Diamonds</p>
                        </div>
                        <div class="text-right">
                            <p id="item-price" class="font-weight-800 color-tech-blue fs-1-1">₱90.00</p>
                        </div>
                    </div>

                    <div class="summary-divider">
                        <div id="user-details-row" class="flex-between mb-8 hidden">
                            <span class="color-888 fs-0-9">Player Details</span>
                            <span id="display-userid" class="font-weight-600 color-333">-</span>
                        </div>
                        <div class="flex-between-center">
                            <span class="font-weight-800 color-333">Total Amount Paid</span>
                            <span id="total-paid" class="font-weight-900 fs-1-4 color-tech-blue">₱90.00</span>
                        </div>
                    </div>
                </div>

                <p class="mt-30 color-888 fs-0-85 italic text-center">Please keep this receipt for your records. The credits will be added to your account within 5-15 minutes.</p>
                <div class="mt-30 text-center">
                    <a href="../index.php" class="btn btn-primary btn-wide">Back to Home</a>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col footer-col-left">
                    <a href="../index.php" class="logo-link">
                        <h2 class="logo color-fff"><img src="../assets/images/logo.jpeg" class="logo-img-small" alt="Logo"> Tech Noblade</h2>
                    </a>
                    <p class="footer-tagline">Smart Solutions for Phones and Gamers..</p>
                </div>

                <div class="footer-col footer-col-middle">
                    <h4>Our Services</h4>
                    <ul>
                        <li><a href="products.php">Game Top-Up</a></li>
                        <li><a href="repair.php">Tech Repair</a></li>
                    </ul>
                </div>
                <div class="footer-col footer-col-right">
                    <h4>Company</h4>
                    <ul>
                        <li><a href="../shared/about.php">About</a></li>
                        <li><a href="../shared/contact.php">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Tech Noblade & Top Up. All rights reserved.</p>
        </div>
    </footer>

    <script src="../assets/js/receipt.js"></script>
<?php include '../shared/partials/auth-modal.php'; ?>
</body>

</html>


