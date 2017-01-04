<?php
session_start();
require_once 'Class_Autoloader.php';

Security::assertUserIs(['guest']);

$email           = Security::cleanInput($_POST['email']);
$password        = Security::cleanInput($_POST['password']);
$confirmPassword = Security::cleanInput($_POST['confirmPassword']);
$firstName       = Security::cleanInput($_POST['firstName']);
$lastName        = Security::cleanInput($_POST['lastName']);
$eid             = Security::cleanInput($_POST['eid']);
$phoneNumber     = Security::cleanInput($_POST['phoneNumber']);

Data_Validation::connectDB();

Data_Validation::checkEmail($email);
Data_Validation::checkPasswords($password, $confirmPassword);
Data_Validation::checkFirstName($firstName);
Data_Validation::checkLastName($lastName);
Data_Validation::checkEID($eid);
Data_Validation::checkPhoneNumber($phoneNumber);

$errorMessages = Data_Validation::getErrorMessages();



if (count($errorMessages) == 0) {
    //generate verification code
    $verificationCode = Utility::generateVerificationCode();

    $sql = "INSERT INTO users (
                Email, 
                Password, 
                FirstName, 
                LastName, 
                VerificationCode,
                Verified,
                EID, 
                PhoneNumber
            ) VALUES ('" . 
                $email . "', '" .
                $password . "', '" . 
                $firstName . "', '" . 
                $lastName . "', '" . 
                $verificationCode . "', " .
                "0, '" .
                $eid . "', '" . 
                $phoneNumber . "'" .
            ")";

    Data_Validation::$dbConnection->query($sql);

    $currentUser = new User($email);

    // $currentUser->sendVerificationCode();            //for sending out the verification code to the email
    $_SESSION['currentUser'] = serialize($currentUser);

}

echo json_encode($errorMessages);