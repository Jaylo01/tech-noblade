<?php
// php/update_ref.php — Update payment reference for an order (prepared statements)
header("Content-Type: application/json");
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['id']) || !isset($data['payment_ref'])) {
    echo json_encode(["success" => false, "error" => "Invalid data"]);
    exit;
}

$order_id    = $data['id'];
$payment_ref = $data['payment_ref'];

// Only update if status is 'Processing'
$stmt = $conn->prepare("SELECT status FROM orders WHERE order_id = ? LIMIT 1");
$stmt->bind_param('s', $order_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

if ($row) {
    if ($row['status'] !== 'Processing') {
        echo json_encode(["success" => false, "error" => "Order already confirmed or cancelled."]);
        exit;
    }
} else {
    echo json_encode(["success" => false, "error" => "Order not found."]);
    exit;
}

$stmt = $conn->prepare("UPDATE orders SET payment_ref = ? WHERE order_id = ?");
$stmt->bind_param('ss', $payment_ref, $order_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $conn->error]);
}
$stmt->close();
$conn->close();
?>
