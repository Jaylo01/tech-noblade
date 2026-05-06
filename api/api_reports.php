<?php
/**
 * api_reports.php - Professional Analytical Reporting API
 * Aggregates sales and service data for business intelligence.
 */
header("Content-Type: application/json");
require_once 'db.php';
require_once 'auth_admin_guard.php'; // Ensure only admins can access

$period = $_GET['period'] ?? 'all'; // all, today, week, month

$dateCondition = "";
if ($period === 'today') {
    $dateCondition = "AND DATE(timestamp) = CURDATE()";
} elseif ($period === 'week') {
    $dateCondition = "AND timestamp >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
} elseif ($period === 'month') {
    $dateCondition = "AND timestamp >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
}

$response = [
    "overview" => [
        "revenue" => 0,
        "orders" => 0,
        "repairs_total" => 0,
        "repairs_completed" => 0,
        "top_game" => "N/A"
    ],
    "sales_breakdown" => []
];

// 1. Revenue & Order Count
$orderQuery = "SELECT SUM(total) as revenue, COUNT(*) as count FROM orders WHERE status = 'Confirmed' $dateCondition";
$orderRes = $conn->query($orderQuery);
if ($row = $orderRes->fetch_assoc()) {
    $response["overview"]["revenue"] = (float)($row['revenue'] ?? 0);
    $response["overview"]["orders"] = (int)$row['count'];
}

// 2. Repair Stats
// Note: We use created_at for repairs
$repairDateCondition = str_replace("timestamp", "created_at", $dateCondition);
$repairQuery = "SELECT 
    COUNT(*) as total, 
    SUM(CASE WHEN LOWER(status) = 'completed' THEN 1 ELSE 0 END) as completed 
    FROM service_requests WHERE 1=1 $repairDateCondition";
$repairRes = $conn->query($repairQuery);
if ($row = $repairRes->fetch_assoc()) {
    $response["overview"]["repairs_total"] = (int)$row['total'];
    $response["overview"]["repairs_completed"] = (int)$row['completed'];
}

// 3. Top Game
$gameQuery = "SELECT game, COUNT(*) as count FROM orders WHERE status = 'Confirmed' $dateCondition GROUP BY game ORDER BY count DESC LIMIT 1";
$gameRes = $conn->query($gameQuery);
if ($row = $gameRes->fetch_assoc()) {
    $response["overview"]["top_game"] = $row['game'];
}

// 4. Sales Breakdown (Latest confirmed items for the report table)
$listQuery = "SELECT order_id, game, item, total, timestamp FROM orders WHERE status = 'Confirmed' $dateCondition ORDER BY timestamp DESC LIMIT 20";
$listRes = $conn->query($listQuery);
while ($row = $listRes->fetch_assoc()) {
    $response["sales_breakdown"][] = $row;
}

echo json_encode($response);
$conn->close();
?>
