<?php
require_once '../api/db.php';
$game = "Valorant";

// Security Hardening: Use prepared statements
$stmt = $conn->prepare("SELECT SUM(stock) as stock FROM product_skus WHERE game = ?");
$stmt->bind_param("s", $game);
$stmt->execute();
$res = $stmt->get_result();
$stock = $res->fetch_assoc()['stock'] ?? 0;
$stmt->close();
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
        <label for="side-menu-toggle" class="close-btn">�</label>
        <a href="../index.php" class="logo-link">
            <h2 class="logo"><img src="../assets/images/logo.jpeg" class="logo-img" alt="Logo"></h2>
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
                    <li><label for="side-menu-toggle" class="nav-toggle-btn">☰</label></li>
                </ul>
            </nav>

        </div>
    </header>

    <main class="product-main">
        <div class="product-header-row">
            <h2 class="section-title product-title">Valorant VP</h2>
            <a href="products.php" class="btn btn-back-product">Back to Products</a>
        </div>
        <div class="modal-content product-form-container">
            <h3>Valorant Points (VP)</h3>
            
            <form action="payment.php" method="get">
                <!-- Valorant Specific Inputs -->
                <div class="product-form-group">
                    <label for="user-id" class="product-form-label">Riot ID (Name#Tag):</label>
                    <input type="text" name="userid" id="user-id" placeholder="User#Tag" required class="product-form-input">
                </div>
                <div class="product-form-group">
                    <label class="product-form-label">Quantity:</label>
                    <div class="qty-controls">
                        <button type="button" id="qty-minus" class="btn-qty">-</button>
                        <input type="number" name="qty" id="quantity" value="1" min="1" readonly class="input-qty">
                        <button type="button" id="qty-plus" class="btn-qty">+</button>
                        <span class="stock-label">Stock: <span id="stock-count"><?php echo $stock; ?></span></span>
                    </div>
                </div>
                <input type="hidden" name="game" value="Valorant">
                <ul class="pricing-list" id="pricing-list">
                    <?php
                    // Security Hardening: Use prepared statements
                    $stmt = $conn->prepare("SELECT * FROM product_skus WHERE game = ?");
                    $stmt->bind_param("s", $game);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    $first = true;
                    while($row = $res->fetch_assoc()):
                        $radioId = "m" . $row['id'];
                    ?>
                    <li>
                        <input type="radio" name="product" value="<?php echo $row['item_name']; ?>|₱<?php echo number_format($row['price'], 2); ?>" 
                                 id="<?php echo $radioId; ?>" class="price-radio" 
                                 data-stock="<?php echo $row['stock']; ?>"
                                 <?php echo $first ? 'checked' : ''; ?>>
                        <label for="<?php echo $radioId; ?>">
                            <span><?php echo $row['item_name']; ?></span> 
                            <span>₱<?php echo number_format($row['price'], 2); ?></span>
                        </label>
                    </li>
                    <?php $first = false; endwhile; $stmt->close(); ?>
                </ul>
                <button type="submit" class="btn btn-primary btn-full mt-20">Proceed to Payment</button>
            </form>
        </div>
    </main>

    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col footer-col-left">
                    <a href="../index.php" class="logo-link">
                        <h2 class="logo-text-white"><img src="../assets/images/logo.jpeg" class="logo-img-small" alt="Logo"> Tech Noblade</h2>
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

    <script src="../assets/js/products.js?v=<?= time() ?>"></script>
<?php include '../shared/partials/auth-modal.php'; ?>
</body>

</html>

