<?php
// customer/dashboard.php
require_once '../api/auth_guard.php';  // Redirects to login if not a customer

$customer_name  = htmlspecialchars($_SESSION['customer_name']);
$customer_email = htmlspecialchars($_SESSION['customer_email']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard – Tech Noblade</title>
    <link rel="icon" type="image/jpeg" href="../assets/images/logo.jpeg">
    <link rel="stylesheet" href="../assets/css/main-bundle.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/css/dashboard-customer.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../assets/css/responsive.css?v=<?= time() ?>">
</head>
<body class="portal-body">

    <!-- === MOBILE HEADER (visible ≤600px) === -->
    <div class="cp-mobile-header">
        <a href="../index.php" class="brand"><img src="../assets/images/logo.jpeg" alt="Logo"></a>
        <a href="../api/auth_logout.php" class="cp-mobile-logout">Logout</a>
    </div>

    <!-- === BOTTOM NAV BAR (visible ≤600px) === -->
    <nav class="cp-bottom-nav">
        <div class="cp-bottom-nav-inner">
            <button class="cp-bnav-item active" onclick="showTab('overview'); setCpNav(this)">
                <span class="nav-icon-text">&#9673;</span> Home
            </button>
            <button class="cp-bnav-item" onclick="showTab('orders'); setCpNav(this)">
                <span class="nav-icon-text">&#9633;</span> Orders
            </button>
            <button class="cp-bnav-item" onclick="showTab('repairs'); setCpNav(this)">
                <span class="nav-icon-text">&#9881;</span> Repairs
            </button>
        </div>
    </nav>

    <!-- === SIDEBAR === -->
    <aside class="cp-sidebar">
        <div class="cp-sidebar-header">
            <div class="cp-logo-box">
                <img src="../assets/images/logo.jpeg" alt="Logo">
            </div>
            <p class="cp-portal-label">Customer Portal</p>
        </div>
        <div class="cp-user-info">
            <div class="name"><?= $customer_name ?></div>
            <div class="email"><?= $customer_email ?></div>
        </div>
        <nav class="cp-sidebar-nav">
            <button class="cp-nav-item active" onclick="showTab('overview')" id="tab-overview">
                <span class="icon">&#9673;</span> Dashboard
            </button>
            <button class="cp-nav-item" onclick="showTab('orders')" id="tab-orders">
                <span class="icon">&#9633;</span> My Top-Up Orders
            </button>
            <button class="cp-nav-item" onclick="showTab('repairs')" id="tab-repairs">
                <span class="icon">&#9881;</span> My Repair Requests
            </button>
        </nav>
        <div class="cp-sidebar-footer">
            <a href="../index.php" class="cp-back-btn"><span>&#8962;</span> View Website</a>
            <a href="../api/auth_logout.php" class="cp-logout-btn"><span>&#8594;</span> Logout</a>
        </div>
    </aside>

    <!-- === MAIN === -->
    <main class="cp-main">

        <div class="cp-page-header">
            <div>
                <h1 id="cp-page-title">Dashboard Overview</h1>
                <p>Your personal Tech Noblade hub.</p>
            </div>
            <span class="cp-date"><?= date('F d, Y') ?></span>
        </div>

        <!-- Overview Tab -->
        <div class="cp-tab active" id="section-overview">
            <div class="cp-welcome">
                <h2>Hello, <?= $customer_name ?>!</h2>
                <p>Welcome to your dashboard. Track your top-up orders and repair requests below.</p>
            </div>
            <div class="cp-stats-row">
                <div class="cp-stat">
                    <h4>Total Orders</h4>
                    <div class="val" id="stat-total-orders">—</div>
                </div>
                <div class="cp-stat">
                    <h4>Processing</h4>
                    <div class="val" id="stat-processing">—</div>
                </div>
                <div class="cp-stat">
                    <h4>Confirmed</h4>
                    <div class="val" id="stat-confirmed">—</div>
                </div>
                <div class="cp-stat">
                    <h4>Repair Requests</h4>
                    <div class="val" id="stat-repairs-count">—</div>
                </div>
            </div>

            <!-- Recent orders mini-table -->
            <div class="cp-card">
                <h2>Recent Top-Up Orders</h2>
                <div class="overflow-x-auto">
                    <table class="cp-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Game</th>
                                <th>Item</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody id="overview-orders-body">
                            <tr><td colspan="6" class="text-center color-bbb p-30">Loading…</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- My Orders Tab -->
        <div class="cp-tab" id="section-orders">
            <div class="cp-card">
                <h2>My Top-Up Orders</h2>
                <div class="overflow-x-auto">
                    <table class="cp-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Game</th>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody id="orders-body">
                            <tr><td colspan="8" class="text-center color-bbb p-30">Loading…</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- My Repairs Tab -->
        <div class="cp-tab" id="section-repairs">
            <div class="cp-card">
                <h2>My Repair Requests</h2>
                <div class="overflow-x-auto">
                    <table class="cp-table">
                        <thead>
                            <tr>
                                <th>Reference ID</th>
                                <th>Device</th>
                                <th>Issue</th>
                                <th>Shipping</th>
                                <th>Status</th>
                                <th>Submitted</th>
                            </tr>
                        </thead>
                        <tbody id="repairs-body">
                            <tr><td colspan="6" class="text-center color-bbb p-30">Loading…</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>

    <script>
        const tabButtons = document.querySelectorAll('.cp-nav-item');
        function showTab(name) {
            document.querySelectorAll('.cp-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.cp-nav-item').forEach(b => b.classList.remove('active'));
            document.getElementById('section-' + name).classList.add('active');
            document.getElementById('tab-' + name).classList.add('active');
            const titles = { overview: 'Dashboard Overview', orders: 'My Top-Up Orders', repairs: 'My Repair Requests' };
            document.getElementById('cp-page-title').textContent = titles[name] || 'Dashboard';
        }

        function badge(status) {
            const map = {
                'Processing':  'badge-processing',
                'Confirmed':   'badge-confirmed',
                'Cancelled':   'badge-cancelled',
                'Pending':     'badge-pending',
                'In Review':   'badge-inreview',
                'In Progress': 'badge-inprogress',
                'Completed':   'badge-completed'
            };
            return `<span class="badge ${map[status] || ''}">${status}</span>`;
        }

        function fmtDate(str) {
            return str ? new Date(str).toLocaleDateString('en-PH', { year:'numeric', month:'short', day:'numeric' }) : '—';
        }

        async function loadOrders() {
            const res  = await fetch('../api/crud/api_customer.php?type=orders');
            const data = await res.json();
            if (!Array.isArray(data)) return;

            document.getElementById('stat-total-orders').textContent = data.length;
            document.getElementById('stat-processing').textContent   = data.filter(o => o.status === 'Processing').length;
            document.getElementById('stat-confirmed').textContent    = data.filter(o => o.status === 'Confirmed').length;

            const ovEl = document.getElementById('overview-orders-body');
            if (data.length === 0) {
                ovEl.innerHTML = `<tr><td colspan="6"><div class="cp-empty"><p>No orders yet. <a href="products.php" class="nav-link-brand">Browse Top-Up Products</a></p></div></td></tr>`;
            } else {
                ovEl.innerHTML = data.slice(0, 5).map(o => `
                    <tr>
                        <td data-label="Order ID"><code class="id-badge">${o.order_id}</code></td>
                        <td data-label="Game">${o.game}</td>
                        <td data-label="Item">${o.item}</td>
                        <td data-label="Total" class="font-weight-700">₱${parseFloat(o.total).toFixed(2)}</td>
                        <td data-label="Status">${badge(o.status)}</td>
                        <td data-label="Date">${fmtDate(o.timestamp)}</td>
                    </tr>`).join('');
            }

            const ordEl = document.getElementById('orders-body');
            if (data.length === 0) {
                ordEl.innerHTML = `<tr><td colspan="8"><div class="cp-empty"><p>No orders yet.</p></div></td></tr>`;
            } else {
                ordEl.innerHTML = data.map(o => `
                    <tr>
                        <td data-label="Order ID"><code class="id-badge">${o.order_id}</code></td>
                        <td data-label="Game">${o.game}</td>
                        <td data-label="Item">${o.item}</td>
                        <td data-label="Qty">${o.qty}</td>
                        <td data-label="Total" class="font-weight-700">₱${parseFloat(o.total).toFixed(2)}</td>
                        <td data-label="Method">${o.method}</td>
                        <td data-label="Status">${badge(o.status)}</td>
                        <td data-label="Date">${fmtDate(o.timestamp)}</td>
                    </tr>`).join('');
            }
        }

        async function loadRepairs() {
            const res  = await fetch('../api/crud/api_customer.php?type=services');
            const data = await res.json();
            if (!Array.isArray(data)) return;

            document.getElementById('stat-repairs-count').textContent = data.length;

            const el = document.getElementById('repairs-body');
            if (data.length === 0) {
                el.innerHTML = `<tr><td colspan="6"><div class="cp-empty"><p>No repair requests yet. <a href="repair.php" class="nav-link-brand">Request a Repair</a></p></div></td></tr>`;
            } else {
                el.innerHTML = data.map(r => `
                    <tr>
                        <td data-label="Ref ID"><code class="id-badge">${r.reference_id}</code></td>
                        <td data-label="Device">${r.device}</td>
                        <td data-label="Issue">${r.issue}</td>
                        <td data-label="Shipping">${r.shipping || '—'}</td>
                        <td data-label="Status">${badge(r.status)}</td>
                        <td data-label="Submitted">${fmtDate(r.created_at)}</td>
                    </tr>`).join('');
            }
        }

        function setCpNav(btn) {
            document.querySelectorAll('.cp-bnav-item').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }

        loadOrders();
        loadRepairs();
    </script>
</body>
</html>
