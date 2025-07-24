<?php
header('Content-Type: application/json');
require_once 'functions.php';

// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

try {
    // Route API requests
    $method = $_SERVER['REQUEST_METHOD'];
    
    switch ($method) {
        case 'GET':
            // Get all data
            $data = getAllData();
            echo json_encode($data);
            break;
            
        case 'POST':
            // Get JSON data
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            
            if (!$data) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid JSON data']);
                break;
            }
            
            // Save data
            $result = saveData($data);
            http_response_code(201);
            echo json_encode($result);
            break;
            
        case 'DELETE':
            // Extract ID from URL
            $url_parts = explode('/', $_SERVER['REQUEST_URI']);
            $id = end($url_parts);
            
            if (!is_numeric($id)) {
                http_response_code(400);
                echo json_encode(['error' => 'Invalid ID']);
                break;
            }
            
            // Delete data
            $result = deleteData($id);
            echo json_encode(['success' => $result]);
            break;
            
               default:
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
