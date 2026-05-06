<?php
// php/auth_login.php
// Handles both customer and admin login via POST
header('Content-Type: application/json');
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) $data = $_POST;

$email    = trim($data['email'] ?? '');
$password = $data['password'] ?? '';
$type     = $data['type'] ?? 'customer'; // 'customer' or 'admin'

if (!$email || !$password) {
    echo json_encode(['error' => 'Email and password are required.']);
    exit;
}

// ----- Admin login (hardcoded credentials, session-based) -----
if ($type === 'admin') {
    $admin_email = 'admin@technoblade.com';
    $admin_pass  = 'admin2026'; // Change this in production

    if ($email === $admin_email && $password === $admin_pass) {
        $_SESSION['role']       = 'admin';
        $_SESSION['admin_name'] = 'Admin';
        echo json_encode(['success' => true, 'redirect' => 'dashboard.php']);
    } else {
        echo json_encode(['error' => 'Invalid admin credentials.']);
    }
    exit;
}

// ----- Customer login -----
$stmt = $conn->prepare('SELECT id, full_name, email, password_hash FROM users WHERE email = ? AND role = "customer" LIMIT 1');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$user   = $result->fetch_assoc();
$stmt->close();

if (!$user || !password_verify($password, $user['password_hash'])) {
    echo json_encode(['error' => 'Invalid email or password.']);
    exit;
}

$_SESSION['customer_id']    = $user['id'];
$_SESSION['customer_name']  = $user['full_name'];
$_SESSION['customer_email'] = $user['email'];
$_SESSION['role']           = 'customer';

echo json_encode(['success' => true, 'redirect' => 'dashboard.php']);
$conn->close();
?>
