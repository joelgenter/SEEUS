<?php
session_start();

require_once '../Class_Autoloader.php';

$currentPassword  = Utility::cleanInput($_POST['currentPassword']);
$newPassword      = Utility::cleanInput($_POST['newPassword']);
$confirmPassword  = Utility::cleanInput($_POST['confirmPassword']);

Data_Validation::checkPasswords($newPassword, $confirmPassword);

$errorMessages = Data_Validation::getErrorMessages();


if (count($errorMessages) == 0) {
    
    $currentUser = new User($_SESSION['email']);

    if ($currentUser->passwordCorrect($currentPassword))
        $currentUser->changePassword($newPassword);
        
    $errorMessages = $currentUser::getErrorMessages();
}
echo json_encode($errorMessages);