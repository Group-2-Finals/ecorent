<?php
if (isset($_COOKIE['userCredentials'])) {
    $userJson = $_COOKIE['userCredentials'];
    $userData = json_decode($userJson, true);

    $userID = $userData['userID'];
    $userQuery = "SELECT * FROM users WHERE userID = '$userID'";
    $userResult = executeQuery($userQuery);

    if (mysqli_num_rows($userResult) > 0) {
        header("Location: index.php");
    }
}
?>