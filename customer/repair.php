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

    <main class="container section-padding">
        <div class="flex-between-center mb-25">
            <div>
                <h2 class="section-title mb-0">Tech Repair Hub</h2>
                <p>Professional tech repair services for your mobile devices.</p>
            </div>
            <a href="../index.php" class="btn btn-outline btn-pad-small fs-0-9">Back to Home</a>
        </div>
        <div class="repair-content">
            <div class="repair-info">
                <h3>Expert Mobile Device Repair</h3>
                <p>We provide fast and professional repair services. Supported brands:</p>
                <ul class="brand-list">
                    <li><img src="../assets/images/mobile.svg" class="feature-icon" alt=""> Samsung</li>
                    <li><img src="../assets/images/mobile.svg" class="feature-icon" alt=""> Cherry Mobile</li>
                    <li><img src="../assets/images/laptop.svg" class="feature-icon" alt=""> Lenovo</li>
                </ul>
            </div>

            <!-- Service Request Form -->
            <div class="repair-form-container">
                <h3>Service Request Form</h3>
                <form id="service-form" class="service-form">
                    <div class="form-group">
                        <label for="fname">Full Name:</label>
                        <input type="text" id="fname" name="fname" required>
                    </div>
                    <div class="form-group">
                        <label for="customer-contact">Contact Info:</label>
                        <input type="text" id="customer-contact" name="contact" required>
                    </div>
                    <div class="form-group">
                        <label for="device">Device Model:</label>
                        <input type="text" id="device" name="device" required>
                    </div>
                    <div class="form-group">
                        <label for="issue">Issue Description:</label>
                        <textarea id="issue" name="issue" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="shipping">Shipping / Pickup Method:</label>
                        <select id="shipping" name="shipping" required onchange="toggleAddress()">
                            <option value="" disabled selected>Select Shipping Method</option>
                            <option value="lalamove">Lalamove (Pickup)</option>
                            <option value="grab">Grab Delivery (Pickup)</option>
                            <option value="dropoff">Personal Drop-off (In-Store)</option>
                        </select>
                    </div>

                    <!-- New Fields -->
                    <div id="address-section" class="form-group hidden">
                        <label for="pickup_address">Pickup Address:</label>
                        <textarea id="pickup_address" name="pickup_address" rows="3" placeholder="Enter complete address for courier pickup"></textarea>
                    </div>

                    <div class="form-group flex gap-15">
                        <div class="flex-1">
                            <label for="schedule_date">Appointment Date:</label>
                            <input type="date" id="schedule_date" name="schedule_date" required min="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="flex-1">
                            <label for="schedule_time">Preferred Time:</label>
                            <input type="time" id="schedule_time" name="schedule_time" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notes">Additional Notes (Optional):</label>
                        <textarea id="notes" name="notes" rows="2" placeholder="Any other details?"></textarea>
                    </div>

                    <button type="submit" id="submit-btn" class="btn btn-primary btn-full">Generate Receipt</button>
                </form>
            </div>
        </div>
    </main>

    <script>
        function toggleAddress() {
            const method = document.getElementById('shipping').value;
            const section = document.getElementById('address-section');
            const field = document.getElementById('pickup_address');
            
            if (method === 'lalamove' || method === 'grab') {
                section.classList.remove('hidden');
                field.required = true;
            } else {
                section.classList.add('hidden');
                field.required = false;
            }
        }

        document.getElementById('service-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('submit-btn');
            const originalText = btn.innerText;
            
            // Basic validation
            if (!document.getElementById('shipping').value) {
                alert("Please select a shipping method.");
                return;
            }

            fetch('../api/api_check_auth.php')
                .then(res => res.json())
                .then(auth => {
                    if (!auth.logged_in) {
                        const modal = document.getElementById('auth-required-modal');
                        if (modal) modal.classList.remove('hidden');
                        return;
                    }
                    
                    // Proceed to process the request only if authenticated
                    btn.innerText = "Processing...";
                    btn.disabled = true;

                    const formData = new FormData(document.getElementById('service-form'));
                    const data = Object.fromEntries(formData.entries());

                    fetch('../api/api_services.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(data)
                    })
                    .then(res => res.json())
                    .then(result => {
                        if(result.success) {
                            const params = new URLSearchParams(data).toString();
                            window.location.href = `repair-receipt.php?${params}&ref=${result.reference_id}`;
                        } else {
                            alert("Error saving request: " + result.error);
                            btn.innerText = originalText;
                            btn.disabled = false;
                        }
                    })
                    .catch(err => {
                        alert("Network error. Please try again.");
                        btn.innerText = originalText;
                        btn.disabled = false;
                    });
                });
        });
    </script>

    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col footer-col-left">
                    <a href="../index.php" class="nav-link-brand-footer">
                        <h2 class="logo footer-logo"><img src="../assets/images/logo.jpeg" class="logo-img logo-img-footer" alt="Logo"> Tech Noblade</h2>
                    </a>
                    <p class="footer-tagline">"Smart Solutions for Phones and Gamers."</p>
                    
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


<?php include '../shared/partials/auth-modal.php'; ?>
</body>

</html>


