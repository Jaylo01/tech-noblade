<?php
/**
 * api_products.php - Handles inventory management and product CRUD operations.
 */
header("Content-Type: application/json");
require_once 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['game'])) {
            $stmt = $conn->prepare("SELECT id, item_name, price, stock FROM product_skus WHERE game = ?");
            $stmt->bind_param("s", $_GET['game']);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $result = $conn->query("SELECT * FROM product_skus ORDER BY game");
        }
        
        $skus = [];
        while ($row = $result->fetch_assoc()) {
            $skus[] = $row;
        }
        echo json_encode($skus);
        if (isset($stmt)) $stmt->close();
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) { echo json_encode(["error" => "Invalid data"]); break; }

        $game = $data['game'] ?? '';
        $item = $data['item_name'] ?? '';
        $price = (float)($data['price'] ?? 0);
        $stock = (int)($data['stock'] ?? 0);

        if (isset($data['id']) && !empty($data['id'])) {
            $id = (int)$data['id'];
            $stmt = $conn->prepare("UPDATE product_skus SET item_name=?, price=?, stock=? WHERE id=?");
            $stmt->bind_param("sdii", $item, $price, $stock, $id);
        } else {
            $stmt = $conn->prepare("INSERT INTO product_skus (game, item_name, price, stock) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssdi", $game, $item, $price, $stock);
        }
        
        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["error" => $conn->error]);
        }
        $stmt->close();
        break;

    case 'DELETE':
        $id = (int)($_GET['id'] ?? 0);
        $stmt = $conn->prepare("DELETE FROM product_skus WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["error" => $conn->error]);
        }
        $stmt->close();
        break;
}

$conn->close();
?>
