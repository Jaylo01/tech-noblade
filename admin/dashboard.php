<?php
// admin/dashboard.php — requires active admin session
require_once '../api/auth_admin_guard.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Tech Noblade</title>
    <link rel="icon" type="image/jpeg" href="../assets/images/logo.jpeg">
    <link rel="stylesheet" href="../assets/css/main-bundle.css?v=<?= time() ?>">
</head>
<body class="portal-body">

    <!-- === MOBILE HEADER (Synced with Customer Portal) === -->
    <div class="cp-mobile-header">
        <a href="../index.php" class="brand"><img src="../assets/images/logo.jpeg" alt="Logo"></a>
        <a href="../api/auth_logout.php" class="cp-mobile-logout">Logout</a>
    </div>

    <!-- Bottom Navigation Bar (Admin Restricted to relevant tabs) -->
    <nav class="admin-bottom-nav">
        <div class="admin-bottom-nav-inner">
            <button class="bnav-item active" onclick="showTab('overview'); setActiveNav(this)">
                <img src="../assets/images/icon-dashboard.svg" alt="Dashboard" class="nav-icon"> Home
            </button>
            <button class="bnav-item" onclick="showTab('orders'); setActiveNav(this)">
                <img src="../assets/images/icon-orders.svg" alt="Orders" class="nav-icon"> Orders
            </button>
            <button class="bnav-item" onclick="showTab('references'); setActiveNav(this)">
                <img src="../assets/images/icon-verification.svg" alt="Verify" class="nav-icon"> Verify
            </button>
            <button class="bnav-item" onclick="showTab('inventory'); setActiveNav(this)">
                <img src="../assets/images/icon-inventory.svg" alt="Inventory" class="nav-icon"> Stock
            </button>
            <button class="bnav-item" onclick="showTab('repairs'); setActiveNav(this)">
                <img src="../assets/images/icon-repairs.svg" alt="Repairs" class="nav-icon"> Repairs
            </button>
        </div>
    </nav>

    <!-- Modern Sidebar (Synced with Customer Portal Profile look) -->
    <aside class="cp-sidebar">
        <div class="cp-sidebar-header">
            <a href="dashboard.php" class="cp-logo-container">
                <img src="../assets/images/logo.jpeg" class="cp-logo-img" alt="Logo">
            </a>
            <p class="cp-portal-label">Admin Portal</p>
        </div>
        <div class="cp-user-info">
            <div class="name">Admin</div>
        </div>
        <div class="cp-sidebar-nav">
            <div class="cp-nav-item active" onclick="showTab('overview')">
                <img src="../assets/images/icon-dashboard.svg" class="icon-small-blue"> <span>Dashboard</span>
            </div>
            <div class="cp-nav-item" onclick="showTab('orders')">
                <img src="../assets/images/icon-orders.svg" class="icon-small-blue"> <span>Orders</span>
            </div>
            <div class="cp-nav-item" onclick="showTab('references')">
                <img src="../assets/images/icon-verification.svg" class="icon-small-blue"> <span>Verification</span>
            </div>
            <div class="cp-nav-item" onclick="showTab('inventory')">
                <img src="../assets/images/icon-inventory.svg" class="icon-small-blue"> <span>Inventory</span>
            </div>
            <div class="cp-nav-item" onclick="showTab('repairs')">
                <img src="../assets/images/icon-repairs.svg" class="icon-small-blue"> <span>Repairs</span>
            </div>
            <div class="cp-nav-item" onclick="showTab('reports')">
                <img src="../assets/images/icon-website.svg" class="icon-small-blue" style="filter: hue-rotate(45deg);"> <span>Reports</span>
            </div>
            <div class="cp-nav-item" onclick="showTab('feedback')">
                <img src="../assets/images/email.svg" class="icon-small-blue"> <span>Feedback</span>
            </div>
        </div>
        <div class="cp-sidebar-footer">
            <a href="../index.php" class="cp-back-btn"><img src="../assets/images/icon-website.svg" class="icon-tiny"> View Website</a>
            <a href="../api/auth_logout.php" class="cp-logout-btn"><span>&#8594;</span> Logout</a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="cp-main">
        <div class="cp-page-header">
            <div>
                <h1 id="page-title" class="admin-header-title">Dashboard Overview</h1>
                <p class="admin-header-subtitle">Control center for Tech Noblade.</p>
            </div>
            <div class="flex items-center gap-20">
                <div class="admin-header-date">
                    <?php echo date('F d, Y'); ?>
                </div>
                <button onclick="refreshData(event)" class="btn-refresh">
                    <span class="fs-1-2-rem">↻</span> Refresh
                </button>
                <a href="../api/auth_logout.php" class="btn-logout">Logout</a>
            </div>
        </div>

        <!-- Overview Tab -->
        <div id="overview-section" class="tab-content active">
            <div class="stats-grid">
                <div class="stat-card">
                    <h4>Total Revenue</h4>
                    <div class="val" id="stat-revenue">₱0</div>
                </div>
                <div class="stat-card">
                    <h4>Pending Orders</h4>
                    <div class="val" id="stat-pending">0</div>
                </div>
                <div class="stat-card">
                    <h4>Active Repairs</h4>
                    <div class="val" id="stat-repairs">0</div>
                </div>
                <div class="stat-card" id="card-low-stock" onclick="highlightLowStock()">
                    <h4>Low Stock Alert <span class="fs-0-8-em opacity-0-7">(Click to view)</span></h4>
                    <div class="val" id="stat-low-stock">0</div>
                </div>
            </div>
            
            <div class="admin-card">
                <h3>Recent Activity Log</h3>
                <div class="admin-table-container">
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Category</th>
                                <th>Details</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody id="recent-activity-body">
                            <tr><td colspan="4" class="text-center">Loading activity...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Orders Tab -->
        <div id="orders-section" class="tab-content">
            <div class="admin-card">
                <div class="flex flex-between-center mb-25">
                    <span class="ref-badge-alt">
                        <span id="pending-count">0</span> Pending
                    </span>
                </div>
                <div class="admin-table-container">
                    <table class="order-table table-fixed w-full">
                        <thead>
                            <tr>
                                <th class="w-15-p">Order ID</th>
                                <th class="w-15-p">Game</th>
                                <th class="w-15-p">Amount</th>
                                <th class="w-12-p">Total Price</th>
                                <th class="w-18-p">Payment Ref</th>
                                <th class="w-10-p">Status</th>
                                <th class="w-15-p">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="orders-body">
                            <tr><td colspan="7" class="text-center">Loading orders...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Payment References Tab -->
        <div id="references-section" class="tab-content">
            <div class="admin-card">
                <div class="flex flex-between-center mb-25">
                    <div>
                        <p class="color-666 fs-0-9">Match these reference numbers with your GCash/Maya receipts.</p>
                    </div>
                </div>
                <div class="admin-table-container">
                    <table class="order-table table-fixed w-full">
                        <thead>
                            <tr>
                                <th class="w-15-p">Order ID</th>
                                <th class="w-15-p">Method</th>
                                <th class="w-25-p">Ref Number</th>
                                <th class="w-15-p">Amount</th>
                                <th class="w-10-p">Status</th>
                                <th class="w-20-p">Submitted At</th>
                            </tr>
                        </thead>
                        <tbody id="references-tab-body">
                            <tr><td colspan="6" class="text-center">Loading references...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Product Items (Inventory) Tab -->
        <div id="inventory-section" class="tab-content">
            <div class="admin-card">
                <div class="flex flex-between-center mb-25">
                    <div>
                        <p class="color-tech-blue fs-0-9">Manage specific pricing tiers and stock levels.</p>
                    </div>
                    <button class="btn btn-primary br-12 btn-pad-small" onclick="showAddProductModal()">+ Add New Item</button>
                </div>
                <div id="products-container" class="flex flex-column gap-20">
                    <div class="text-center p-40 color-666">Loading items...</div>
                </div>
            </div>
        </div>

        <!-- Repairs Tab -->
        <div id="repairs-section" class="tab-content">
            <div class="admin-card">
                <h2 class="font-weight-700 mb-20">Repair Service Requests</h2>
                <div class="admin-table-container">
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th>Ref ID</th>
                                <th>Customer</th>
                                <th>Device</th>
                                <th>Shipping</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="repairs-body">
                             <tr><td colspan="6" class="text-center">Loading requests...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Reports Tab -->
        <div id="reports-section" class="tab-content">
            <div class="admin-card">
                <div class="flex flex-between-center mb-25">
                    <div>
                        <h2 class="font-weight-700">Business Analytics & Reports</h2>
                        <p class="fs-0-9 color-666">Generate periodic summaries for sales and services.</p>
                    </div>
                    <div class="flex gap-10">
                        <select id="report-period" class="stock-input w-150" onchange="loadReport(this.value)">
                            <option value="today">Today</option>
                            <option value="week">Past 7 Days</option>
                            <option value="month" selected>Past 30 Days</option>
                            <option value="all">All Time</option>
                        </select>
                        <button onclick="window.print()" class="btn btn-primary">Print Report</button>
                    </div>
                </div>

                <div id="report-printable-area">
                    <div class="print-only-header" style="display: none;">
                        <img src="../assets/images/logo.jpeg" class="w-120 mb-10">
                        <h1 style="white-space: nowrap;">TECH NOBLADE & TOP UP</h1>
                        <p>Analytical Performance Report - Generated on <?php echo date('F d, Y'); ?></p>
                    </div>

                    <div class="report-grid">
                        <div class="stat-card">
                            <h4>Period Revenue</h4>
                            <div class="val" id="rep-revenue">₱0</div>
                        </div>
                        <div class="stat-card">
                            <h4>Total Orders</h4>
                            <div class="val" id="rep-orders">0</div>
                        </div>
                        <div class="stat-card">
                            <h4>Repairs Completed</h4>
                            <div class="val" id="rep-repairs">0</div>
                        </div>
                        <div class="stat-card">
                            <h4>Top Trending Category</h4>
                            <div class="val val-small" id="rep-game">---</div>
                        </div>
                    </div>

                    <h3 class="fs-1-0-rem mb-15 font-weight-700">Detailed Sales Log (Period)</h3>
                    <div class="admin-table-container">
                        <table class="order-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Game</th>
                                    <th>Item</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="report-body">
                                <tr><td colspan="5" class="text-center">Generate a report to see data</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Feedback Tab -->
        <div id="feedback-section" class="tab-content">
            <div class="admin-card">
                <h2 class="font-weight-700 mb-25">Customer Feedback & Inquiries</h2>
                <div class="admin-table-container">
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Topic</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="feedback-body">
                             <tr><td colspan="6" class="text-center">Loading feedback...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <div id="product-modal" class="admin-modal-overlay">
        <div class="admin-modal-card">
            <h2 id="modal-title">Add Product Item</h2>
            <div class="form-group-admin">
                <label>Game Category</label>
                <select id="p-game" class="stock-input">
                    <option value="Mobile Legends">Mobile Legends</option>
                    <option value="Roblox (Robux)">Roblox (Robux)</option>
                    <option value="Call of Duty: Mobile">Call of Duty: Mobile</option>
                    <option value="Honor of Kings">Honor of Kings</option>
                    <option value="Valorant">Valorant</option>
                    <option value="League of Legends: Wild Rift">League of Legends: Wild Rift</option>
                </select>
            </div>
            <div class="form-group-admin">
                <label>Option Name</label>
                <input type="text" id="p-name" class="stock-input">
            </div>
            <div class="form-group-admin">
                <label>Price (PHP)</label>
                <input type="number" id="p-price" class="stock-input">
            </div>
            <div class="form-group-admin">
                <label>Stock Count</label>
                <input type="number" id="p-stock" class="stock-input">
            </div>
            <input type="hidden" id="p-id">
            <div class="flex gap-10 mt-20">
                <button class="btn btn-primary flex-1" id="save-p-btn">Save</button>
                <button class="btn flex-1 btn-cancel" onclick="closeProductModal()">Cancel</button>
            </div>
        </div>
    </div>

    <script src="../assets/js/admin.js?v=<?= time() ?>"></script>
</body>
</html>
