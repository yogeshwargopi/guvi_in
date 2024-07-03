<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'redis_session.php';

$response = [];

if (isset($_POST['sessionID'])) {
    $sessionID = $_POST['sessionID'];

    // Clear session in Redis
    $redis->del($sessionID);

    // Destroy the session
    session_start();
    session_unset();
    session_destroy();

    $response['success'] = true;
    $response['message'] = 'Logged out successfully!';
} else {
    $response['success'] = false;
    $response['message'] = 'Session ID not provided!';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
