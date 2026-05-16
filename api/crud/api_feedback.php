<?php
session_start();
require_once "../db.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Only admin can view all feedback
    if (empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        http_response_code(403);
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    }
    $res = $conn->query("SELECT * FROM feedback ORDER BY id DESC");
    $data = [];
    while($row = $res->fetch_assoc()) $data[] = $row;
    echo json_encode($data);
}
elseif ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $name = $input['name'] ?? 'Guest';
    $email = $input['email'] ?? '';
    $topic = $input['topic'] ?? '';
    $message = $input['message'] ?? '';
    
    $stmt = $conn->prepare("INSERT INTO feedback (name, email, topic, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $topic, $message);
    if($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Failed to log feedback']);
    }
}
elseif ($method === 'DELETE') {
    if (empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        http_response_code(403);
        exit;
    }
    $id = intval($_REQUEST['id'] ?? 0);
    $stmt = $conn->prepare("DELETE FROM feedback WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    if($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'No record deleted. ID might be invalid or already removed.', 'id_received' => $id]);
    }
}
?>
