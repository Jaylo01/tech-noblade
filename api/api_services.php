<?php
// api/api_services.php
header("Content-Type: application/json");
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['ref'])) {
            $stmt = $conn->prepare("SELECT * FROM service_requests WHERE reference_id = ? LIMIT 1");
            $stmt->bind_param('s', $_GET['ref']);
            $stmt->execute();
            $res = $stmt->get_result();
            echo json_encode($res->fetch_assoc() ?: ["error" => "Not found"]);
            $stmt->close();
        } else {
            // Security Hardening: Use prepared statements even for simple selects if parameters are ever added
            $sql    = "SELECT * FROM service_requests ORDER BY created_at DESC";
            $result = $conn->query($sql);
            $rows   = [];
            while ($row = $result->fetch_assoc()) $rows[] = $row;
            echo json_encode($rows);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) $data = $_POST;

        $ref            = 'SR-' . strtoupper(substr(uniqid(), 7));
        $name           = $data['fname'] ?? $data['customer_name'] ?? '';
        $contact        = $data['contact']  ?? '';
        $device         = $data['device']   ?? '';
        $issue          = $data['issue']    ?? '';
        $shipping       = $data['shipping'] ?? '';
        $customer_id    = !empty($_SESSION['customer_id']) ? (int)$_SESSION['customer_id'] : null;
        
        // New Fields
        $pickup_address = $data['pickup_address'] ?? '';
        $schedule_date  = $data['schedule_date']  ?? null;
        $schedule_time  = $data['schedule_time']  ?? null;
        $notes          = $data['notes']          ?? '';

        $stmt = $conn->prepare(
            "INSERT INTO service_requests (reference_id, customer_name, contact, device, issue, shipping, customer_id, pickup_address, schedule_date, schedule_time, notes)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param('ssssssissss', $ref, $name, $contact, $device, $issue, $shipping, $customer_id, $pickup_address, $schedule_date, $schedule_time, $notes);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "reference_id" => $ref]);
        } else {
            echo json_encode(["error" => $conn->error]);
        }
        $stmt->close();
        break;

    case 'PATCH':
        $data   = json_decode(file_get_contents("php://input"), true);
        $id     = (int)($data['id']     ?? 0);
        $status = $data['status'] ?? '';
        $quote  = isset($data['diagnostic_quote']) ? (float)$data['diagnostic_quote'] : null;
        $quote_status = $data['quote_status'] ?? null;

        if ($quote !== null || $quote_status !== null) {
            // Admin is updating quote/diagnostic info
            $stmt = $conn->prepare("UPDATE service_requests SET status = ?, diagnostic_quote = ?, quote_status = ? WHERE id = ?");
            $stmt->bind_param('sdsi', $status, $quote, $quote_status, $id);
        } else {
            // Simple status update
            $stmt = $conn->prepare("UPDATE service_requests SET status = ? WHERE id = ?");
            $stmt->bind_param('si', $status, $id);
        }

        echo json_encode($stmt->execute() ? ["success" => true] : ["error" => $conn->error]);
        $stmt->close();
        break;

    case 'DELETE':
        $id   = (int)($_GET['id'] ?? 0);
        $stmt = $conn->prepare("DELETE FROM service_requests WHERE id = ?");
        $stmt->bind_param('i', $id);
        echo json_encode($stmt->execute() ? ["success" => true] : ["error" => $conn->error]);
        $stmt->close();
        break;
}

$conn->close();
?>
