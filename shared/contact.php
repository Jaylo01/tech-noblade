<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Tech Noblade</title>
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
            <h2 class="logo side-logo-container"><img src="../assets/images/logo.jpeg" class="logo-img side-logo-img" alt="Tech Noblade Logo"></h2>
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
                    <li><label for="side-menu-toggle" class="nav-toggle-btn"><img src="../assets/images/icon-menu-bars.svg" class="icon-menu-img"></label></li>
                </ul>
            </nav>
        </div>
    </header>

    <input type="checkbox" id="msg-sent" class="msg-sent-toggle" hidden aria-hidden="true">
    <div class="tn-success-overlay">
        <div class="attractive-card success-card">
            <h2 class="success-title">Message Sent!</h2>
            <p class="success-text">Thank you for contacting Tech Noblade. We will get back to you shortly.</p>
            <label for="msg-sent" class="btn btn-primary">OK</label>
        </div>
    </div>

    <header class="page-header header-padding-contact">
        <div class="container">
            <h1>Contact Tech Noblade</h1>
            <p class="opacity-09 fs-1-1 mt-15">We're here to help you get back in the game.</p>
        </div>
    </header>

    <main class="contact-section section-padding-contact">
        <div class="container">
            <div class="contact-grid-main">
                <!-- Left: Contact Info & Map -->
                <div class="contact-info-wrapper">
                    <div class="attractive-card contact-info-card">
                        <div class="card-accent-line"></div>
                        <h2>Get in Touch</h2>
                        <div class="contact-item">
                            <img src="../assets/images/location.svg" class="contact-card-icon" alt="Location">
                            <div>
                                <h4 class="mb-0">Location</h4>
                                <p class="opacity-07">Cainta, Rizal, Philippines</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <img src="../assets/images/phone.svg" class="contact-card-icon" alt="Phone">
                            <div>
                                <h4 class="mb-0">Phone</h4>
                                <p class="opacity-07">+63 912 345 6789</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <img src="../assets/images/email.svg" class="contact-card-icon" alt="Email">
                            <div>
                                <h4 class="mb-0">Email</h4>
                                <p class="opacity-07">support@technoblade.topup</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <img src="../assets/images/clock.svg" class="contact-card-icon" alt="Clock">
                            <div>
                                <h4 class="mb-0">Business Hours</h4>
                                <p class="opacity-07">Mon - Sat: 9:00 AM - 9:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Contact Form -->
                <div class="contact-form-wrapper">
                    <div class="attractive-card">
                        <h2 class="mb-15">Send a Message</h2>
                        <p class="opacity-07 mb-25">Have a specific question about a repair or a purchase? Drop us a line!</p>
                        <form action="javascript:void(0)" class="contact-form" id="actual-contact-form">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" id="fb-name" placeholder="Juan Dela Cruz" required>
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" id="fb-email" placeholder="juan@email.com" required>
                            </div>
                            <div class="form-group">
                                <label>Topic</label>
                                <select id="fb-topic">
                                    <option>Game Top-Up Delivery</option>
                                    <option>Repair Status Update</option>
                                    <option>Business Partnership</option>
                                    <option>Others</option>
                                </select>
                            </div>
                            <div class="form-group mb-50">
                                <label>Your Message</label>
                                <textarea id="fb-message" rows="4" placeholder="How can we help you today?" required></textarea>
                            </div>
                            <button type="button" onclick="submitFeedback()" class="btn btn-primary btn-full">Submit Message</button>
                        </form>
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

<script>
    function submitFeedback() {
        const name = document.getElementById('fb-name').value.trim();
        const email = document.getElementById('fb-email').value.trim();
        const topic = document.getElementById('fb-topic').value;
        const message = document.getElementById('fb-message').value.trim();

        if(!name || !email || !message) {
            alert('Please fill out all required fields.');
            return;
        }

        fetch('../api/crud/api_feedback.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name, email, topic, message })
        }).then(res => res.json())
          .then(data => {
              if(data.success) {
                  document.getElementById('actual-contact-form').reset();
                  document.getElementById('msg-sent').checked = true;
              } else {
                  alert('There was an error sending your message. Please try again.');
              }
          })
          .catch(err => {
              console.error(err);
              alert('Connection error.');
          });
    }
</script>
</html>


