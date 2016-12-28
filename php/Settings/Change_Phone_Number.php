<?php
session_start();
require_once '../Class_Autoloader.php';

Security::assertUserIs(['authoritarian', 'user']);

$newPhoneNumber  = Security::cleanInput($_POST['newPhoneNumber']);

Data_Validation::checkPhoneNumber($newPhoneNumber);

$errorMessages = Data_Validation::getErrorMessages();


if (count($errorMessages) == 0) {
    User::connectDB();
    User::changePhoneNumber($newPhoneNumber);
    $errorMessages = User::getErrorMessages();
}

echo json_encode($errorMessages);