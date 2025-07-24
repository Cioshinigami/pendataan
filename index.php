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

4. upload.php (File upload endpoint)

<?php
header('Content-Type: application/json');
require_once 'functions.php';

// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        exit;
    }
    
    if (!isset($_FILES['file'])) {
        http_response_code(400);
        echo json_encode(['error' => 'No file uploaded']);
        exit;
    }
    
    $file = $_FILES['file'];
    
    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['error' => 'File upload error: ' . $file['error']]);
        exit;
    }
    
    // Check file size (max 5MB)
    if ($file['size'] > 5 * 1024 * 1024) {
        http_response_code(400);
        echo json_encode(['error' => 'File too large (max 5MB)']);
        exit;
    }
    
    // Check file type
    $allowed_types = ['application/xlx', 'application/msexcel', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'];
    if (!in_array($file['type'], $allowed_types)) {
        http_response_code(400);
        echo json_encode(['error' => 'File type not allowed']);
        exit;
    }
    
    // Upload file
    $result = uploadFile($file);
    echo json_encode($result);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>