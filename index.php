<?php
session_start();
$is_customer   = !empty($_SESSION['customer_id']) && ($_SESSION['role'] ?? '') === 'customer';
$customer_name = $is_customer ? htmlspecialchars($_SESSION['customer_name']) : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Noblade & Top Up - Home</title>
    <link rel="icon" type="image/jpeg" href="assets/images/logo.jpeg">
    <link rel="stylesheet" href="assets/css/main-bundle.css?v=<?= time() ?>">
</head>

<body>
    <!-- Sidebar Toggle & Menu -->
    <input type="checkbox" id="side-menu-toggle" class="side-menu-toggle">
    <div class="side-menu-overlay"></div>
    <aside class="side-menu">
        <label for="side-menu-toggle" class="close-btn close-btn-pos"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></label>
        <a href="index.php" class="logo-link">
            <h2 class="logo side-logo-container">
                <img src="assets/images/logo.jpeg" class="logo-img side-logo-img" alt="Tech Noblade Logo">
            </h2>
        </a>
        <a href="index.php">Home</a>
        <a href="customer/products.php">Top-Up Products</a>
        <a href="customer/repair.php">Repair Services</a>
        <a href="shared/about.php">About</a>
        <a href="shared/contact.php">Contact</a>
        <?php include 'shared/partials/side-nav-auth.php'; ?>
    </aside>

    <!-- Header -->
    <header class="navbar">
        <div class="container header-flex-container">
            <a href="index.php" class="logo-link">
                <h2 class="logo">
                    <img src="assets/images/logo.jpeg" class="logo-img" alt="Tech Noblade Logo"> 
                    <span class="logo-text">Tech Noblade</span>
                </h2>
                <span class="tagline-nav">"Smart Solutions for Phones and Gamers."</span>
            </a>

            <nav>
                <ul class="nav-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="shared/about.php">About</a></li>
                    <li><a href="shared/contact.php">Contact</a></li>
                    <li><label for="side-menu-toggle" class="nav-toggle-btn"><img src="assets/images/icon-menu-bars.svg" class="icon-menu-img"></label></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Splash Header with Interactive Slideshow -->
    <header class="splash-header">
        <div class="slideshow-container">
            <!-- Slot 1: Image (Splash 1) -->
            <div class="slide slide-img slide-1"></div>

            <!-- Slot 2-5: Videos -->
            <div class="slide slide-video">
                <video muted autoplay loop playsinline>
                    <source src="assets/videos/phonerepair.mp4" type="video/mp4">
                </video>
            </div>
            <div class="slide slide-video">
                <video muted autoplay loop playsinline>
                    <source src="assets/videos/mobilelegends.mp4" type="video/mp4">
                </video>
            </div>
            <div class="slide slide-video">
                <video muted autoplay loop playsinline>
                    <source src="assets/videos/riotgames.mp4" type="video/mp4">
                </video>
            </div>
            <div class="slide slide-video">
                <video muted autoplay loop playsinline>
                    <source src="assets/videos/valorant.mp4" type="video/mp4">
                </video>
            </div>

            <!-- Slot 6: Image (Splash 6) -->
            <div class="slide slide-img slide-6"></div>
        </div>

        <div class="slide-nav-manual">
            <button class="slide-arrow prev" onclick="moveSlide(-1)">&#10094;</button>
            <button class="slide-arrow next" onclick="moveSlide(1)">&#10095;</button>
        </div>

        <div class="slide-nav">
            <div class="nav-dot active" onclick="currentSlide(0)"></div>
            <div class="nav-dot" onclick="currentSlide(1)"></div>
            <div class="nav-dot" onclick="currentSlide(2)"></div>
            <div class="nav-dot" onclick="currentSlide(3)"></div>
            <div class="nav-dot" onclick="currentSlide(4)"></div>
            <div class="nav-dot" onclick="currentSlide(5)"></div>
        </div>
    </header>

<?php
require_once 'api/db.php';
$sql = "SELECT game, SUM(stock) as total_stock FROM product_skus GROUP BY game";
$result = $conn->query($sql);
$stocks = [];
while ($row = $result->fetch_assoc()) {
    $stocks[$row['game']] = $row['total_stock'];
}
?>
    <!-- Action Cards Section -->
    <main class="container py-80">
        <div class="home-grid-actions">
            <!-- Tech Repair Card -->
            <a href="customer/repair.php" class="home-card-btn">
                <img src="assets/images/icon-repairs.svg" class="home-card-icon" alt="Repair">
                <h2>Tech Repair</h2>
                <p>Repair for Smartphones</p>
            </a>
            
            <!-- Game Products Card -->
            <a href="customer/products.php" class="home-card-btn">
                <img src="assets/images/icon-orders.svg" class="home-card-icon" alt="Game">
                <h2>Game Products</h2>
                <p>Top-Up for your Favorite Games</p>
            </a>
        </div>
    </main>


    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <!-- Left Column: Logo & Tagline -->
                <!-- Left Column: Branding -->
                <div class="footer-col footer-col-left">
                    <a href="index.php" class="nav-link-brand-footer">
                        <h2 class="logo footer-logo">
                            <img src="assets/images/logo.jpeg" class="logo-img logo-img-footer" alt="Logo"> 
                            Tech Noblade
                        </h2>
                    </a>
                    <p class="footer-tagline">"Smart Solutions for Phones and Gamers."</p>
                    
                </div>

                <!-- Middle Column: Our Services -->
                <div class="footer-col footer-col-middle">
                    <h4>Our Services</h4>
                    <ul>
                        <li><a href="customer/products.php">Game Top-Up</a></li>
                        <li><a href="customer/repair.php">Tech Repair</a></li>
                    </ul>
                </div>

                <!-- Right Column: Company -->
                <div class="footer-col footer-col-right">
                    <h4>Company</h4>
                    <ul>
                        <li><a href="shared/about.php">About</a></li>
                        <li><a href="shared/contact.php">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Tech Noblade & Top Up. All rights reserved.</p>
        </div>
    </footer>

    <script src="assets/js/main.js?v=<?= time() ?>"></script>
    <?php include 'shared/partials/auth-modal.php'; ?>
</body>

</html>

