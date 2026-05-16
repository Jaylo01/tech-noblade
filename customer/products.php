<?php
require_once '../api/db.php';
$sql = "SELECT game, SUM(stock) as total_stock FROM product_skus GROUP BY game";
$result = $conn->query($sql);
$stocks = [];
while ($row = $result->fetch_assoc()) {
    $stocks[$row['game']] = $row['total_stock'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Noblade</title>
    <link rel="icon" type="image/jpeg" href="../assets/images/logo.jpeg">
    <link rel="stylesheet" href="../assets/css/main-bundle.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/css/responsive.css?v=<?= time() ?>">
</head>

<body>
    <!-- Sidebar Toggle & Menu -->
    <input type="checkbox" id="side-menu-toggle" class="side-menu-toggle">
    <div class="side-menu-overlay"></div>
    <aside class="side-menu">
        <label for="side-menu-toggle" class="close-btn close-btn-pos"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></label>
        <a href="../index.php" class="logo-link">
            <h2 class="logo side-logo-container">
                <img src="../assets/images/logo.jpeg" class="logo-img side-logo-img" alt="Tech Noblade Logo">
            </h2>
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
        <div class="container header-flex-container">
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
                    <li><label for="side-menu-toggle" class="nav-toggle-btn"><img src="../assets/images/icon-menu-bars.svg" class="icon-menu-img"></label></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container section-padding">
        <h2 class="section-title">Game Currency Top-Up</h2>
        <div class="game-grid">
            <!-- Mobile Legends -->
            <div class="game-card">
                <img src="../assets/images/mlbb.jpg" alt="MLBB" class="game-icon">
                <h3>Mobile Legends</h3>
                <p class="currency-desc">Diamonds</p>
                <div class="stock-badge-container">Stock: <span class="stock-val-accent"><?php echo $stocks['Mobile Legends'] ?? 0; ?></span></div>
                <a href="pricelist-mlbb.php" class="btn btn-primary">Buy Now</a>
            </div>
            <!-- Roblox -->
            <div class="game-card">
                <img src="../assets/images/roblox.jpeg" alt="Roblox" class="game-icon">
                <h3>Roblox</h3>
                <p class="currency-desc">Robux</p>
                <div class="stock-badge-container">Stock: <span class="stock-val-accent"><?php echo $stocks['Roblox (Robux)'] ?? 0; ?></span></div>
                <a href="pricelist-roblox.php" class="btn btn-primary">Buy Now</a>
            </div>
            <!-- CODM -->
            <div class="game-card">
                <img src="../assets/images/codmobile.jpg" alt="CODM" class="game-icon">
                <h3>Call of Duty: Mobile</h3>
                <p class="currency-desc">CP</p>
                <div class="stock-badge-container">Stock: <span class="stock-val-accent"><?php echo $stocks['Call of Duty: Mobile'] ?? 0; ?></span></div>
                <a href="pricelist-codm.php" class="btn btn-primary">Buy Now</a>
            </div>
            <!-- Valorant -->
            <div class="game-card">
                <img src="../assets/images/valorant.jpg" alt="Valorant" class="game-icon">
                <h3>Valorant</h3>
                <p class="currency-desc">VP</p>
                <div class="stock-badge-container">Stock: <span class="stock-val-accent"><?php echo $stocks['Valorant'] ?? 0; ?></span></div>
                <a href="pricelist-valorant.php" class="btn btn-primary">Buy Now</a>
            </div>
             <!-- HOK -->
             <div class="game-card">
                <img src="../assets/images/hok.jpeg" alt="HOK" class="game-icon">
                <h3>Honor of Kings</h3>
                <p class="currency-desc">Tokens</p>
                <div class="stock-badge-container">Stock: <span class="stock-val-accent"><?php echo $stocks['Honor of Kings'] ?? 0; ?></span></div>
                <a href="pricelist-hok.php" class="btn btn-primary">Buy Now</a>
            </div>
             <!-- LOL -->
             <div class="game-card">
                <img src="../assets/images/lol-wildrift.jpeg" alt="LOL" class="game-icon">
                <h3>League of Legends: Wild Rift</h3>
                <p class="currency-desc">Wild Cores</p>
                <div class="stock-badge-container">Stock: <span class="stock-val-accent"><?php echo $stocks['League of Legends: Wild Rift'] ?? 0; ?></span></div>
                <a href="pricelist-lol.php" class="btn btn-primary">Buy Now</a>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <!-- Left Column: Logo & Tagline -->
                <div class="footer-col footer-col-left">
                    <a href="../index.php" class="nav-link-brand-footer">
                        <h2 class="logo footer-logo">
                            <img src="../assets/images/logo.jpeg" class="logo-img logo-img-footer" alt="Logo"> 
                            Tech Noblade
                        </h2>
                    </a>
                    <p class="footer-tagline">"Smart Solutions for Phones and Gamers."</p>
                    
                </div>

                <!-- Middle Column: Our Services -->
                <div class="footer-col footer-col-middle">
                    <h4>Our Services</h4>
                    <ul>
                        <li><a href="products.php">Game Top-Up</a></li>
                        <li><a href="repair.php">Tech Repair</a></li>
                    </ul>
                </div>

                <!-- Right Column: Company -->
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


<?php include '../shared/partials/auth-modal.php'; ?>
</body>

</html>


