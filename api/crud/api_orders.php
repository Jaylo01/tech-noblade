<?php
// php/api_orders.php
header("Content-Type: application/json");
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../db.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ? LIMIT 1");
            $stmt->bind_param('s', $_GET['id']);
            $stmt->execute();
            $res = $stmt->get_result();
            echo json_encode($res->fetch_assoc() ?: ["status" => "error", "message" => "Order not found"]);
            $stmt->close();
        } else {
            // Admin: all orders; customer: own orders only
            if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                $result = $conn->query("SELECT * FROM orders ORDER BY timestamp DESC");
            } elseif (!empty($_SESSION['customer_id'])) {
                $stmt = $conn->prepare("SELECT * FROM orders WHERE customer_id = ? ORDER BY timestamp DESC");
                $cid  = (int)$_SESSION['customer_id'];
                $stmt->bind_param('i', $cid);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
            } else {
                http_response_code(403);
                echo json_encode(["error" => "Forbidden"]);
                break;
            }
            $orders = [];
            while ($row = $result->fetch_assoc()) $orders[] = $row;
            echo json_encode($orders);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) { echo json_encode(["error" => "Invalid data"]); break; }

        $order_id    = $data['id']          ?? null;
        $game        = $data['game']        ?? '';
        $item        = $data['item']        ?? '';
        $qty         = (int)($data['qty']    ?? 0);
        
        // --- 🚨 SECURITY PATCH: Server-Side Price Calculation ---
        // Never trust client-provided pricing data. Form total based on SKUs table.
        $stmt_price = $conn->prepare("SELECT price FROM product_skus WHERE game = ? AND item_name = ? LIMIT 1");
        $stmt_price->bind_param('ss', $game, $item);
        $stmt_price->execute();
        $price_row = $stmt_price->get_result()->fetch_assoc();
        $stmt_price->close();

        if (!$price_row || (float)$price_row['price'] <= 0) {
            echo json_encode(["error" => "Invalid product selected or item is unavailable."]);
            break;
        }

        $price = (float)$price_row['price'];
        $total = $price * $qty;
        // ---------------------------------------------------------

        $pmethod     = $data['method']      ?? '';
        $userid      = $data['userid']      ?? '';
        $zoneid      = $data['zoneid']      ?? '';
        $payment_ref = $data['payment_ref'] ?? null;
        $customer_id = !empty($_SESSION['customer_id']) ? (int)$_SESSION['customer_id'] : null;

        if ($customer_id !== null) {
            $stmt = $conn->prepare(
                "INSERT INTO orders (order_id, game, item, price, qty, total, method, userid, zoneid, payment_ref, customer_id)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->bind_param('sssdidssssi',
                $order_id, $game, $item, $price, $qty, $total,
                $pmethod, $userid, $zoneid, $payment_ref, $customer_id
            );
        } else {
            $stmt = $conn->prepare(
                "INSERT INTO orders (order_id, game, item, price, qty, total, method, userid, zoneid, payment_ref)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->bind_param('sssdidssss',
                $order_id, $game, $item, $price, $qty, $total,
                $pmethod, $userid, $zoneid, $payment_ref
            );
        }

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "id" => $order_id]);
        } else {
            echo json_encode(["error" => $conn->error]);
        }
        $stmt->close();
        break;

    case 'PATCH':
        if (empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(["error" => "Forbidden. Admin access required."]);
            break;
        }

        $data     = json_decode(file_get_contents("php://input"), true);
        $order_id = $data['id']     ?? '';
        $status   = $data['status'] ?? '';

        if ($status === 'Confirmed') {
            $stmt = $conn->prepare("SELECT game, item, qty FROM orders WHERE order_id = ? LIMIT 1");
            $stmt->bind_param('s', $order_id);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            if ($row) {
                $qty   = (int)$row['qty'];
                $stmt2 = $conn->prepare("UPDATE product_skus SET stock = GREATEST(0, stock - ?) WHERE game = ? AND item_name = ?");
                $stmt2->bind_param('iss', $qty, $row['game'], $row['item']);
                $stmt2->execute();
                $stmt2->close();
            }
        }

        if (isset($data['payment_ref'])) {
            $stmt = $conn->prepare("UPDATE orders SET status = ?, payment_ref = ? WHERE order_id = ?");
            $stmt->bind_param('sss', $status, $data['payment_ref'], $order_id);
        } else {
            $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
            $stmt->bind_param('ss', $status, $order_id);
        }
        echo json_encode($stmt->execute() ? ["success" => true] : ["error" => $conn->error]);
        $stmt->close();
        break;

    case 'DELETE':
        if (empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(["error" => "Forbidden. Admin access required."]);
            break;
        }

        $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
        $stmt->bind_param('s', $_GET['id']);
        echo json_encode($stmt->execute() ? ["success" => true] : ["error" => $conn->error]);
        $stmt->close();
        break;
}

$conn->close();
?>
