<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Noblade</title>
    <link rel="icon" type="image/jpeg" href="../assets/images/logo.jpeg">
    <link rel="stylesheet" href="../assets/css/main-bundle.css?v=<?= time() ?>">
</head>

<body class="bg-f8faff">
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

    <main class="section-padding text-center">
        <div class="container">
            <!-- Unified Status Tracker -->
            <div class="status-tracker">
                <div class="tracker-line-container">
                    <div class="tracker-line-bg"></div>
                    <div class="tracker-line-fill" id="status-progress"></div>
                    <img src="../assets/images/techno-walking_transparent.gif" id="walking-anim" class="walking-anim-pos" alt="Walking">
                </div>
                <div class="status-steps-overlay">
                    <div class="status-step active" id="step1">
                        <div class="step-circle">1</div>
                        <span class="step-label">Pending</span>
                    </div>
                    <div class="status-step" id="step2">
                        <div class="step-circle">2</div>
                        <span class="step-label">Verifying</span>
                    </div>
                    <div class="status-step" id="step3">
                        <div class="step-circle">3</div>
                        <span class="step-label">Completed</span>
                    </div>
                </div>
                <p id="status-text" class="status-label-main mt-20">Verifying your booking...</p>
            </div>

            <div class="receipt-box">
                <div class="receipt-header-clean">
                    <img src="../assets/images/logo.jpeg" alt="Logo" class="receipt-logo">
                    <h2 class="receipt-title">SERVICE RECEIPT</h2>
                </div>

                <div class="receipt-header-status">
                    <h1 class="receipt-status-success">Request Placed!</h1>
                    <p class="color-666">We've received your repair request. Please keep this copy.</p>
                </div>

                <!-- Transaction Metadata -->
                <div class="ref-meta-box">
                    <div class="ref-meta-row">
                        <span class="ref-meta-label">Status</span>
                        <span id="status-badge" class="ref-meta-badge">IN REVIEW</span>
                    </div>
                    <div class="ref-meta-row">
                        <span class="ref-meta-label">Service ID</span>
                        <span id="ref-no" class="ref-meta-val">---</span>
                    </div>
                    <div class="ref-meta-row mb-0">
                        <span class="ref-meta-label">Request Date</span>
                        <span id="datetime" class="font-weight-500">---</span>
                    </div>
                </div>

                <!-- Diagnostic Quote -->
                <div id="quote-card" class="product-summary-card mb-20 hidden">
                    <h4 class="fs-0-8 color-warning text-uppercase letter-spacing-1">Technician's Diagnostic Quote</h4>
                    <div id="quote-value" class="fs-2-0 font-weight-900 color-tech-dark">₱0.00</div>
                    <p class="fs-0-85 color-666">Please confirm via contact for final approval.</p>
                </div>

                <!-- Service Details -->
                <div id="dropoff-instructions" class="dropoff-box-clean hidden">
                    <h4 class="dropoff-header">Next Step: Personal Drop-off</h4>
                    <p class="dropoff-note">Please bring your device to our service center for assessment:</p>
                    <div class="dropoff-loc">
                        <img src="../assets/images/location.svg?v=<?= time() ?>" class="loc-icon" alt="Map">
                        <p class="loc-details"><strong>Tech Noblade Service Center</strong><br>Cainta, Rizal, Philippines<br><small>Mon - Sat | 9:00 AM - 9:00 PM</small></p>
                    </div>
                </div>

                <div class="product-summary-card">
                    <h3 class="summary-card-header">Service Summary</h3>
                    
                    <div class="flex-column mb-15 text-left">
                        <label class="color-888 fs-0-8 mb-4">Customer Name</label>
                        <span id="display-name" class="font-weight-800 color-333">---</span>
                    </div>

                    <div class="flex-between gap-30 mb-15">
                        <div class="flex-column flex-1 text-left">
                            <label class="color-888 fs-0-8 mb-4">Device Model</label>
                            <span id="display-device" class="font-weight-600 color-333">---</span>
                        </div>
                        <div class="flex-column flex-1 text-left">
                            <label class="color-888 fs-0-8 mb-4">Shipping Method</label>
                            <span id="display-shipping" class="font-weight-600 color-tech-blue text-capitalize">---</span>
                        </div>
                    </div>

                    <div id="display-address-row" class="hidden mb-15 text-left">
                        <span class="color-888 fs-0-8 mb-4 block">Pickup Address</span>
                        <span id="display-address" class="font-weight-600 color-333">---</span>
                    </div>

                    <div class="mb-15 text-left">
                        <span class="color-888 fs-0-8 mb-4 block">Appointment Schedule</span>
                        <span id="display-schedule" class="font-weight-600 color-333">---</span>
                    </div>

                    <div class="mb-15 text-left">
                        <span class="color-888 fs-0-8 mb-4 block">Issue Description</span>
                        <p id="display-issue" class="color-555 bg-fff p-10 br-8 b-1-eee fs-0-9">---</p>
                    </div>

                    <div class="summary-divider">
                        <p class="fs-0-85 color-666">Our technician will contact you within 24 hours at <span id="display-contact" class="font-weight-800 color-333">---</span> for the final assessment.</p>
                    </div>
                </div>

                <div class="btn-container-center">
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
                        <h2 class="color-fff"><img src="../assets/images/logo.jpeg" class="logo-img-small" alt="Logo"> Tech Noblade</h2>
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

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const refNo = urlParams.get('ref');
        
        document.getElementById('display-name').innerText = urlParams.get('fname') || 'N/A';
        document.getElementById('display-contact').innerText = urlParams.get('contact') || 'N/A';
        document.getElementById('display-device').innerText = urlParams.get('device') || 'N/A';
        document.getElementById('display-issue').innerText = urlParams.get('issue') || 'N/A';
        const shipping = urlParams.get('shipping') || 'Store Drop-off';
        document.getElementById('display-shipping').innerText = shipping;
        if (shipping.toLowerCase().includes('dropoff')) {
            const di = document.getElementById('dropoff-instructions');
            if (di) di.classList.remove('hidden');
        }
        
        if (urlParams.get('pickup_address')) {
            document.getElementById('display-address-row').classList.remove('hidden');
            document.getElementById('display-address').innerText = urlParams.get('pickup_address');
        }

        const schedule = (urlParams.get('schedule_date') || '') + ' at ' + (urlParams.get('schedule_time') || '');
        document.getElementById('display-schedule').innerText = schedule.trim() === 'at' ? 'Not Scheduled' : schedule;

        document.getElementById('ref-no').innerText = refNo || 'Pending...';
        
        const now = new Date();
        const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
        document.getElementById('datetime').innerText = now.toLocaleDateString('en-US', options).replace(',', ' |');

        const progress = document.getElementById('status-progress');
        const statusLabelText = document.getElementById('status-text');
        const statusBadge = document.getElementById('status-badge');
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const step3 = document.getElementById('step3');

        async function checkStatus() {
            if (!refNo) return;
            try {
                const response = await fetch(`../api/crud/api_services.php?ref=${encodeURIComponent(refNo)}`);
                const data = await response.json();
                
                if (data.error) return;

                document.getElementById('display-name').innerText = data.customer_name;
                document.getElementById('display-device').innerText = data.device;
                document.getElementById('display-shipping').innerText = data.shipping;
                if (data.pickup_address) {
                    document.getElementById('display-address-row').classList.remove('hidden');
                    document.getElementById('display-address').innerText = data.pickup_address;
                }
                const fullSchedule = (data.schedule_date || '') + ' at ' + (data.schedule_time || '');
                document.getElementById('display-schedule').innerText = fullSchedule.trim() === 'at' ? 'Not Scheduled' : fullSchedule;

                if (data.diagnostic_quote) {
                    document.getElementById('quote-card').classList.remove('hidden');
                    document.getElementById('quote-value').innerText = '₱' + parseFloat(data.diagnostic_quote).toLocaleString('en-PH', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                }

                const status = (data.status || 'pending').toLowerCase();
                const walker = document.getElementById('walking-anim');
                if (statusBadge) statusBadge.innerText = status.toUpperCase();

                if (data.shipping && data.shipping.toLowerCase().includes('dropoff')) {
                    document.getElementById('dropoff-instructions').classList.remove('hidden');
                }

                if (status === 'pending' || status === 'in review') {
                    if (progress) progress.style.width = '20%';
                    if (walker) walker.style.left = '20%';
                    if (statusLabelText) statusLabelText.innerText = 'Request received...';
                    if (step1) { step1.classList.add('active'); step1.classList.add('completed'); }
                } else if (status === 'verifying' || status === 'processing' || status === 'in progress') {
                    if (progress) progress.style.width = '60%';
                    if (walker) walker.style.left = '60%';
                    if (statusLabelText) statusLabelText.innerText = 'Technician is diagnosing the device...';
                    if (step1) step1.classList.add('completed');
                    if (step2) { step2.classList.add('active'); step2.classList.add('completed'); }
                } else if (status === 'completed' || status === 'confirmed' || status === 'done') {
                    if (progress) progress.style.width = '100%';
                    if (walker) walker.style.left = '100%';
                    if (statusLabelText) {
                        statusLabelText.innerText = 'Service Booked & Completed!';
                        statusLabelText.style.color = '#28a745';
                    }
                    if (step1) step1.classList.add('completed');
                    if (step2) step2.classList.add('completed');
                    if (step3) {
                        step3.classList.add('active');
                        step3.classList.add('completed');
                    }
                    if (statusBadge) {
                        statusBadge.style.background = '#e8f5e9';
                        statusBadge.style.color = '#2e7d32';
                    }
                }
            } catch (err) {
                console.error("Status check failed:", err);
            }
        }

        checkStatus(); 
        setInterval(checkStatus, 3000);
    </script>
<?php include '../shared/partials/auth-modal.php'; ?>
</body>

</html>

