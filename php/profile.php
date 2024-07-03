<?php
require_once '../db/connect_mongo.php';
require_once 'redis_session.php';

// Function to get profile data
function getProfileData($userID) {
    global $mongo;
    $profileCollection = $mongo->mydb->profiles;
    $profile = $profileCollection->findOne(['userID' => $userID]);
    return $profile;
}

$sessionID = $_POST['sessionID'];
$response = [];

// Validate session ID and get user ID
$userID = getSession($sessionID);

if ($userID) {
    // Fetching profile data
    $profile = getProfileData($userID);
    if ($profile) {
        $response['success'] = true;
        $response['profile'] = $profile;
    } else {
        $response['success'] = false;
        $response['message'] = 'Please update your profile';
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Please login again';
}

echo json_encode($response);
?>
