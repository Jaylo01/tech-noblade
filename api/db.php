<?php
// api/db.php
// Database connection configuration

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'tech_noblade_db';
$port = 3307; // Updated from 3306

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Set charset to utf8
$conn->set_charset("utf8");
?>
