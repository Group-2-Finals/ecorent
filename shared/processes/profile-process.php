<?php
include(__DIR__ . "/../../connect.php");

$userID = $_COOKIE["userID"];

// Check if success is present in the query string indicating user info is updated successfully.
$profileUpdated = false;
if (isset($_GET['success']) && $_GET['success'] === 'true') {
    $profileUpdated = true;
}

$userInfoArray = array();
// Query to retrieve current user info.
$getUserInfoQuery = "SELECT firstName, lastName, email, contactNumber, gender, address FROM users WHERE userID = $userID";
$getUserInfoResult = executeQuery($getUserInfoQuery);

if (mysqli_num_rows($getUserInfoResult) > 0) {
    $userInfoArray = mysqli_fetch_assoc($getUserInfoResult);
} 

if (isset($_POST['btnSaveProfile'])) {
    $firstName = $_POST["firstName"] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $email = $_POST['email'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $contactNumber = $_POST['contactNumber'] ?? '';
    $address = $_POST['address'] ?? '';

    // Query to update user info.
    $updateUserInfo = "UPDATE users SET firstName = '$firstName', lastName = '$lastName', email = '$email', address = '$address', contactNumber = '$contactNumber', gender = '$gender' WHERE userID = $userID";
    executeQuery($updateUserInfo);

    header("Location: " . $_SERVER['PHP_SELF'] . "?success=true"); 

    }

?>