<?php
require_once '../db/connect_mongo.php';
require_once 'redis_session.php';

// Function to update profile data
function updateProfileData($userID, $age, $dob, $contact) {
    global $mongo;
    $profileCollection = $mongo->mydb->profiles;
    $result = $profileCollection->updateOne(
        ['userID' => $userID],
        ['$set' => ['age' => $age, 'dob' => $dob, 'contact' => $contact]],
        ['upsert' => true]
    );
    return $result;
}

$sessionID = $_POST['sessionID'];
$response = [];

// Validate session ID and get user ID
$userID = getSession($sessionID);

// Debugging: Log session ID and userID
error_log("Session ID: " . $sessionID);
error_log("User ID: " . ($userID ? $userID : "Invalid"));

if ($userID) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Updating profile
        $age = $_POST['age'];
        $dob = $_POST['dob'];
        $contact = $_POST['contact'];
        $updateResult = updateProfileData($userID, $age, $dob, $contact);
        
        if ($updateResult->getMatchedCount() > 0 || $updateResult->getUpsertedCount() > 0) {
            $response['success'] = true;
            $response['message'] = 'Profile updated successfully!';
        } else {
            $response['success'] = false;
            $response['message'] = 'Failed to update profile!';
        }
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Invalid session!';
}

echo json_encode($response);
?>
