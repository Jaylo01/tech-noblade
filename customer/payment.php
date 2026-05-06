<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Selection - Tech Noblade</title>
    <link rel="icon" type="image/jpeg" href="../assets/images/logo.jpeg">
    <link rel="stylesheet" href="../assets/css/main-bundle.css?v=<?= time() ?>">
</head>

<body>
    <!-- Sidebar Toggle & Menu -->
    <input type="checkbox" id="side-menu-toggle" class="side-menu-toggle">
    <div class="side-menu-overlay"></div>
    <aside class="side-menu">
        <label for="side-menu-toggle" class="close-btn close-btn-pos">◊</label>
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

    <!-- Header -->
    <header class="navbar">
        <div class="container container-flex">
            <a href="../index.php" class="logo-link">
                <h2 class="logo">
                    <img src="../assets/images/logo.jpeg" class="logo-img" alt="Tech Noblade Logo"> 
                    Tech Noblade
                </h2>
                <span class="tagline-nav">"Smart Solutions for Phones and Gamers."</span>
            </a>

            <nav>
                <ul class="nav-links">
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="../shared/about.php">About</a></li>
                    <li><a href="../shared/contact.php">Contact</a></li>
                    <li><label for="side-menu-toggle" class="nav-toggle-btn">‚ò∞</label></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container section-padding text-center">
        <div class="flex-between-center mb-20 px-20">
            <a href="products.php" class="btn btn-outline-blue py-8 px-20 fs-0-9">‚Üê Back to Products</a>
            <h2 class="section-title mb-0">Payment Method</h2>
            <div class="spacer-140"></div>
        </div>
        
        <p class="color-666 mb-40">Please select your preferred payment method to proceed.</p>

        <div class="payment-grid">
            <div class="payment-method">
                <label class="pointer block w-full">
                    <div class="method-card">
                        <img src="../assets/images/gcash_logo.png" class="payment-logo" alt="GCash">
                        <span>GCash</span>
                    </div>
                </label>
            </div>
            <div class="payment-method">
                <label class="pointer block w-full">
                    <div class="method-card">
                        <img src="../assets/images/maya_logo.png" class="payment-logo" alt="Maya">
                        <span>Maya</span>
                    </div>
                </label>
            </div>
            <div class="payment-method">
                <label class="pointer block w-full">
                    <div class="method-card">
                        <img src="../assets/images/otc_logo.png" class="payment-logo" alt="OTC">
                        <span>Over the Counter</span>
                    </div>
                </label>
            </div>
        </div>

        <!-- Maintenance Note -->
        <div class="maintenance-box">
            <p class="fs-0-9 color-warning"><strong>Note:</strong> Direct account connection is currently under maintenance. Please use the <strong>QR Code</strong> method for instant processing.</p>
            <a href="#" class="nav-link-brand fs-0-8 underline">Learn more</a>
        </div>
    </main>

    <!-- Overlay and Panels -->
    <div id="payment-overlay" class="payment-overlay"></div>
    
    <!-- GCash Panel -->
    <div id="gcash-panel" class="payment-panel">
        <span class="payment-panel-close-btn">◊</span>
        <div class="qr-container">
            <img src="../assets/images/qr-img-rollrick.jpeg" class="qr-image" alt="GCash QR Code">
        </div>
        <h3 class="color-tech-blue mb-5">Scan to Pay with GCash</h3>
        <p class="fs-0-9 color-666">Open your GCash app and scan the QR code.</p>
        <div class="bg-f8f9fa p-15 br-12 mt-20">
            <p>Account: <strong>TECH NOBLADE</strong></p>
            <p>Order ID: <strong class="current-ref-display color-tech-blue font-mono">---</strong></p>
        </div>

        <div class="mt-15 text-center color-tech-blue">
             <img src="../assets/images/techno-standby_transparent.gif" class="w-70 mb-8" alt="Standby">
             <div class="spinner-spin"></div>
             <p class="font-weight-800 fs-0-8">Waiting for Payment Confirmation...</p>
        </div>
        
        <div class="bg-f0f7ff p-20 br-15 mt-20 b-1-dashed-blue">
            <p class="fs-0-85 mb-10 color-333">Enter <strong>Reference Number</strong> below:</p>
            <input type="text" id="gcash-ref" class="form-input text-center mb-10 w-full p-12 br-8 b-1-ddd" placeholder="Ref No. from Receipt">
            <button onclick="submitReference('gcash-ref', this)" class="btn btn-primary btn-full">Submit Reference</button>
            <div id="gcash-ref-msg" class="mt-10 fs-0-8 font-weight-800"></div>
        </div>
    </div>

    <!-- Maya Panel -->
    <div id="maya-panel" class="payment-panel">
        <span class="payment-panel-close-btn">◊</span>
        <div class="qr-container">
            <img src="../assets/images/qr-img-rollrick.jpeg" class="qr-image" alt="Maya QR Code">
        </div>
        <h3 class="color-tech-blue mb-5">Scan to Pay with Maya</h3>
        <p class="fs-0-9 color-666">Open your Maya app and scan the QR code.</p>
        <div class="bg-f8f9fa p-15 br-12 mt-20">
            <p>Account: <strong>TECH NOBLADE</strong></p>
            <p>Order ID: <strong class="current-ref-display color-tech-blue font-mono">---</strong></p>
        </div>

        <div class="mt-15 text-center color-tech-blue">
             <img src="../assets/images/techno-standby_transparent.gif" class="w-70 mb-8" alt="Standby">
             <div class="spinner-spin"></div>
             <p class="font-weight-800 fs-0-8">Waiting for Payment Confirmation...</p>
        </div>
        
        <div class="bg-f0f7ff p-20 br-15 mt-20 b-1-dashed-blue">
            <p class="fs-0-85 mb-10 color-333">Enter <strong>Reference Number</strong> below:</p>
            <input type="text" id="maya-ref" class="form-input text-center mb-10 w-full p-12 br-8 b-1-ddd" placeholder="Ref No. from Receipt">
            <button onclick="submitReference('maya-ref', this)" class="btn btn-primary btn-full">Submit Reference</button>
            <div id="maya-ref-msg" class="mt-10 fs-0-8 font-weight-800"></div>
        </div>
    </div>

    <!-- OTC Panel -->
    <div id="otc-panel" class="payment-panel">
        <span class="payment-panel-close-btn">◊</span>
        <h3 class="color-tech-blue">Over the Counter</h3>
        <p class="color-666">Pay manually to Tech Noblade staff. Then click below.</p>
        <div class="bg-f8f9fa p-15 br-12 my-20">
            <p>Order ID: <strong class="current-ref-display color-tech-blue font-mono">---</strong></p>
        </div>
        <button id="otc-proceed-btn" class="btn btn-primary btn-full">Proceed (I've Paid)</button>
        <div id="otc-waiting" class="hidden mt-20 text-center">
            <p class="color-tech-blue font-weight-800">Waiting for Staff Confirmation...</p>
            <input type="text" id="otc-ref" class="form-input text-center my-15 w-full p-12 br-8 b-1-ddd" placeholder="Staff Name or ID">
            <button onclick="submitReference('otc-ref', this)" class="btn btn-primary btn-full">Submit Ref</button>
            <div id="otc-ref-msg"></div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col footer-col-left">
                    <div class="footer-logo-block">
                        <img src="../assets/images/logo.jpeg" class="footer-logo-img" alt="Logo">
                        <h2 class="color-fff m-0">Tech Noblade</h2>
                        <p class="footer-tagline-text">"Smart Solutions for Phones and Gamers."</p>
                    </div>
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
    <script src="../assets/js/payment.js?v=<?php echo time(); ?>"></script>
<?php include '../shared/partials/auth-modal.php'; ?>
</body>
</html>
