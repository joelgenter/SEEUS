<?php
session_start();

require_once 'Class_Autoloader.php';

$email = Security::cleanInput($_POST['email']);

$errorMessages = [];

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

    if (!$currentUser->sendVerificationCode()) {
        array_push($errorMessages, "Could not send email. Try again in 12 hours.");
    }

    $_SESSION['currentUser'] = serialize($currentUser);
}

$errorMessages = array_merge($errorMessages, User::getErrorMessages());

echo json_encode($errorMessages);