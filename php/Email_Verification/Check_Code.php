<?php
session_start();
require_once '../Class_Autoloader.php';

$enteredCode = Utility::cleanInput($_POST['enteredCode']);

$currentUser = unserialize($_SESSION['currentUser']);
$currentUser->verificationCodeCorrect($enteredCode);

$errorMessages = $currentUser::getErrorMessages();

if (count($errorMessages) == 0) {
    $currentUser->verifyEmail();
    $currentUser->login();
    unset($_SESSION['currentUser']);
}

$returnData = [
    "errorMessages"  => $errorMessages
];

echo json_encode($returnData);