<?php
// Database configuration
$db_host = 'localhost';      // Change to your database host
$db_name = 'u923426670_data_input';  // Change to your database name
$db_user = 'u923426670_Binlat';  // Change to your database username
$db_pass = '@Binlat2025';  // Change to your database password

// Create database connection
try {
    $db = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Upload directory configuration
$upload_dir = '../uploads/satpam_docs/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}
?>