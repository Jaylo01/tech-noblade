<?php
// php/api_stats.php
header("Content-Type: application/json");
require_once 'db.php';

$stats = [];

// 1. Total Revenue (Confirmed Orders)
$sql = "SELECT SUM(total) as revenue FROM orders WHERE status = 'Confirmed'";
$res = $conn->query($sql);
$stats['total_revenue'] = (float)($res->fetch_assoc()['revenue'] ?? 0);

// 2. Pending Orders
$sql = "SELECT COUNT(*) as pending FROM orders WHERE status = 'Processing'";
$res = $conn->query($sql);
$stats['pending_orders'] = (int)($res->fetch_assoc()['pending'] ?? 0);

// 3. Active Repair Requests
$sql = "SELECT COUNT(*) as active FROM service_requests WHERE status NOT IN ('Completed', 'Cancelled')";
$res = $conn->query($sql);
$stats['active_repairs'] = (int)($res->fetch_assoc()['active'] ?? 0);

// 4. Low Stock Items (< 10)
$sql = "SELECT COUNT(*) as low FROM product_skus WHERE stock < 10";
$res = $conn->query($sql);
$stats['low_stock_count'] = (int)($res->fetch_assoc()['low'] ?? 0);

// 5. Recent Activity (Latest 5 Orders)
$sql = "SELECT 'Order' as type, game, item, total as value, timestamp 
        FROM orders 
        ORDER BY timestamp DESC LIMIT 5";
$res = $conn->query($sql);
$activity = [];
while ($row = $res->fetch_assoc()) {
    $activity[] = $row;
}
$stats['recent_activity'] = $activity;

echo json_encode($stats);
$conn->close();
?>
