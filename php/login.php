<?php
session_start();

require_once 'Class_Autoloader.php';

$email = Utility::cleanInput($_POST['email']);
$password = Utility::cleanInput($_POST['password']);
$currentUser = new User($email);

//all these return boolean values and add error messages
$isRegistered = User::emailRegistered($email);
$isVerified = $currentUser->emailVerified();
$passwordCorrect = $currentUser->passwordCorrect($password);

$errorMessages = $currentUser::getErrorMessages();

if ($isRegistered && $passwordCorrect) {
    if ($isVerified) {
        $currentUser->login();
    } else {
        $_SESSION['currentUser'] = serialize($currentUser);
    }
}

$returnData = [
    "emailVerified"  => $isVerified,
    "errorMessages"  => $errorMessages
];


echo json_encode($returnData);