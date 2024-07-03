<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../db/connect_mysql.php';
require_once 'redis_session.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Prepare a response array
$response = [];

if (empty($username) || empty($password)) {
    $response['success'] = false;
    $response['message'] = 'Username or password is empty!';
    echo json_encode($response);
    exit;
}

$stmt = $mysqli->prepare("SELECT id, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();
    if (password_verify($password, $hashed_password)) {
        // Start the session and generate a session ID
        session_start();
        $sessionID = session_id();

        // Store the session ID in Redis with the user ID
        $redis->set($sessionID, $id);

        $response['success'] = true;
        $response['message'] = 'Login successful!';
        $response['sessionID'] = $sessionID;
    } else {
        $response['success'] = false;
        $response['message'] = 'Invalid password!';
    }
} else {
    $response['success'] = false;
    $response['message'] = 'User not found!';
}

$stmt->close();
$mysqli->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
