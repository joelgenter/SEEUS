<?php
session_start();
require_once '../Class_Autoloader.php';

$enteredCode = Security::cleanInput($_POST['enteredCode']);

$currentUser = unserialize($_SESSION['currentUser']);
$currentUser->verificationCodeCorrect($enteredCode);

$errorMessages = $currentUser::getErrorMessages();

if (count($errorMessages) == 0) {
    $currentUser->verifyEmail();
    $currentUser->login();
    unset($_SESSION['currentUser']);
}

echo json_encode($errorMessages);