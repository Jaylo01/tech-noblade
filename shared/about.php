<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Tech Noblade</title>
    <link rel="icon" type="image/jpeg" href="../assets/images/logo.jpeg">
    <link rel="stylesheet" href="../assets/css/main-bundle.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/css/responsive.css?v=<?= time() ?>">
</head>

<body>
    <!-- Sidebar Toggle & Menu -->
    <input type="checkbox" id="side-menu-toggle" class="side-menu-toggle">
    <div class="side-menu-overlay"></div>
    <aside class="side-menu">
        <label for="side-menu-toggle" class="close-btn close-btn-pos">�</label>
        <a href="../index.php" class="logo-link">
            <h2 class="logo"><img src="../assets/images/logo.jpeg" class="logo-img" alt="Logo"></h2>
        </a>
        <a href="../index.php">Home</a>
        <a href="../customer/products.php">Top-Up Products</a>
        <a href="../customer/repair.php">Repair Services</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
    <?php include __DIR__.'/partials/side-nav-auth.php'; ?>
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
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><label for="side-menu-toggle" class="nav-toggle-btn">☰</label></li>
                </ul>
            </nav>
        </div>
    </header>

    <header class="page-header">
        <div class="container">
            <h1>About Us</h1>
        </div>
    </header>

    <main class="about-section">
        <div class="container">
            <div class="attractive-card">
                <h2>Our Mission</h2>
                <p class="fs-1-1 lh-2-5">
                    <strong>Tech Noblade & Top Up</strong> was created by a dedicated team of students who wanted to
                    bridge the gap between tech repairs and gaming needs. Whether you're dealing with a faulty battery
                    or just need a quick top-up for your next skin, we’ve got you covered.
                </p>
                <p class="fs-1-1 lh-2-5 mt-15">
                    We offer reliable mobile repairs for brands like Samsung and Lenovo, alongside secure game currency
                    for the biggest titles in the Philippines. Join us as we grow our skills and help you stay in the
                    game!
                </p>
            </div>

            <div class="attractive-card b-blue-thick">
                <h2>Why Choose Us?</h2>
                <div class="feature-small-grid">
                    <div>
                        <h4 class="mb-0">Fast Turnaround</h4>
                        <p class="opacity-07">Most repairs completed within 24-48 hours.</p>
                    </div>
                    <div>
                        <h4 class="mb-0">Secure Payments</h4>
                        <p class="opacity-07">Safe top-ups via GCash, Maya, and OTC.</p>
                    </div>
                    <div>
                        <h4 class="mb-0">Student-Led</h4>
                        <p class="opacity-07">Fresh motivation and dedication to tech excellence.</p>
                    </div>
                </div>
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
                        <li><a href="../customer/products.php">Game Top-Up</a></li>
                        <li><a href="../customer/repair.php">Tech Repair</a></li>
                    </ul>
                </div>

                <!-- Right Column: Company -->
                <div class="footer-col footer-col-right">
                    <h4>Company</h4>
                    <ul>
                        <li><a href="about.php">About</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Tech Noblade & Top Up. All rights reserved.</p>
        </div>
    </footer>


<?php include __DIR__.'/partials/auth-modal.php'; ?>
</body>

</html>


