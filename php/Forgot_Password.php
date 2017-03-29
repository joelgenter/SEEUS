<?php
session_start();

require_once 'Class_Autoloader.php';

$email = Security::cleanInput($_POST['email']);


User::connectDB();
if (User::emailRegistered($email)) {
    $newVerificationCode = Utility::generateVerificationCode();
    Utility::connectDB();

    $sql = 'UPDATE users
            SET VerificationCode = ?
            WHERE Email = ?';

    $stmt = Utility::$dbConnection->prepare($sql);
    $stmt->bind_param("ss", $newVerificationCode, $email);
    $stmt->execute();

    $currentUser = new User($email);
    // $currentUser->sendVerificationCode();            //for sending out the verification code to the email
    $_SESSION['currentUser'] = serialize($currentUser);
}

$errorMessages = User::getErrorMessages();

echo json_encode($errorMessages);