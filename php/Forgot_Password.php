<?php
session_start();

require_once 'Class_Autoloader.php';

$email = Utility::cleanInput($_POST['email']);


User::connectDB();
if (User::emailRegistered($email)) {
    $newVerificationCode = Utility::generateVerificationCode();
    Utility::connectDB();
    $sql = 'UPDATE users
            SET VerificationCode = "' . $newVerificationCode . '"
            WHERE Email = "' . $email . '"';
    Utility::$dbConnection->query($sql);

    $currentUser = new User($email);
    // $currentUser->sendVerificationCode();            //for sending out the verification code to the email
    $_SESSION['currentUser'] = serialize($currentUser);
}

$errorMessages = User::getErrorMessages();

echo json_encode($errorMessages);