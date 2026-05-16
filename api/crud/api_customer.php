<?php
// php/api_customer.php
// Returns orders and service requests for the currently logged-in customer ONLY.
header('Content-Type: application/json');

if (session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION['customer_id']) || ($_SESSION['role'] ?? '') !== 'customer') {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

require_once '../db.php';
$customer_id = (int) $_SESSION['customer_id'];
$type        = $_GET['type'] ?? 'orders';

if ($type === 'services') {
    // --- Fetch this customer's repair / service requests ---
    $stmt = $conn->prepare(
        'SELECT reference_id, device, issue, shipping, status, created_at
         FROM service_requests
         WHERE customer_id = ?
         ORDER BY created_at DESC'
    );
    $stmt->bind_param('i', $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows   = [];
    while ($row = $result->fetch_assoc()) $rows[] = $row;
    $stmt->close();
    echo json_encode($rows);
} else {
    // --- Fetch this customer's top-up orders ---
    $stmt = $conn->prepare(
        'SELECT order_id, game, item, price, qty, total, method, userid, zoneid, payment_ref, status, timestamp
         FROM orders
         WHERE customer_id = ?
         ORDER BY timestamp DESC'
    );
    $stmt->bind_param('i', $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows   = [];
    while ($row = $result->fetch_assoc()) $rows[] = $row;
    $stmt->close();
    echo json_encode($rows);
}

$conn->close();
?>
