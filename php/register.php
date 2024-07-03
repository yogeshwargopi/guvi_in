<?php
require_once '../db/connect_mysql.php';

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

$stmt = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $password);

$response = [];
if ($stmt->execute()) {
    $response['success'] = true;
    $response['message'] = 'Registration successful!';
} else {
    $response['success'] = false;
    $response['message'] = 'Registration failed!';
}

$stmt->close();
$mysqli->close();

echo json_encode($response);
?>
