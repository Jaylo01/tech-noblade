<?php
// api/auth_register.php
header('Content-Type: application/json');
if (session_status() === PHP_SESSION_NONE) session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) $data = $_POST;

$full_name = trim($data['full_name'] ?? '');
$email     = trim($data['email'] ?? '');
$password  = $data['password'] ?? '';
$confirm   = $data['confirm_password'] ?? '';

// --- Validation ---
if (!$full_name || !$email || !$password || !$confirm) {
    echo json_encode(['error' => 'All fields are required.']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['error' => 'Invalid email address.']);
    exit;
}
if (strlen($password) < 6) {
    echo json_encode(['error' => 'Password must be at least 6 characters.']);
    exit;
}
if ($password !== $confirm) {
    echo json_encode(['error' => 'Passwords do not match.']);
    exit;
}

// --- Check duplicate email ---
$stmt = $conn->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->close();
    echo json_encode(['error' => 'An account with that email already exists.']);
    exit;
}
$stmt->close();

// --- Insert user ---
$hash = password_hash($password, PASSWORD_BCRYPT);
$stmt = $conn->prepare('INSERT INTO users (full_name, email, password_hash, role) VALUES (?, ?, ?, "customer")');
$stmt->bind_param('sss', $full_name, $email, $hash);
if ($stmt->execute()) {
    $user_id = $stmt->insert_id;
    $stmt->close();

    // Auto-login after registration
    $_SESSION['customer_id']   = $user_id;
    $_SESSION['customer_name'] = $full_name;
    $_SESSION['customer_email']= $email;
    $_SESSION['role']          = 'customer';

    // Canonical redirect
    echo json_encode(['success' => true, 'redirect' => 'dashboard.php']);
} else {
    echo json_encode(['error' => 'Registration failed. Please try again.']);
}
$conn->close();
?>
