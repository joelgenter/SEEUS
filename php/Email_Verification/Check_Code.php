<?php
session_start();

$enteredCode = cleanInput($_POST['enteredCode']);

$_SESSION['currentuser']->clearErrorMessages();
$_SESSION['currentuser']->checkVerificationCode($_POST['enteredCode']);

$returnData = $currentUser->getReturnData();

if ($returnData['verificationCodeCorrect']) {
        $currentUser->verifyEmail();
        $currentUser->login();
        unset($_SESSION['currentuser']);
}

echo json_encode($returnData);