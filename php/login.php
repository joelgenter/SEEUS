<?php

require_once 'Class_Autoloader.php';
require_once 'DB_Connection.php';

$currentUser = new User($dbConnection, $_POST['email']);

$currentUser->checkEmailRegistration();
$currentUser->checkEmailVerification();
$currentUser->checkPassword($_POST['password']);

$returnData = $currentUser->getReturnData();

if ($returnData['emailRegistered']) {
    if ($returnData['passwordCorrect']) {
        if ($returnData['emailVerified']) {
            $currentUser->login();
        } else {
            $_SESSION['currentUser'] = $currentUser;
        }
    }
}
echo json_encode($returnData);