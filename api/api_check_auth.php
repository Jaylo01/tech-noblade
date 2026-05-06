<?php
if (session_status() === PHP_SESSION_NONE) session_start();
echo json_encode(['logged_in' => (!empty($_SESSION['customer_id']) && ($_SESSION['role'] ?? '') === 'customer')]);
