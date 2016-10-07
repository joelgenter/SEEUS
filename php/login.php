<?php
require 'validation.php';
require 'database_connection.php';

$email = cleanInput($_POST['email']);
$password = cleanInput($_POST['password']);

$returnData = validate($email, 
    [
        'emailRegistered',
        'emailVerified'
    ], 
    $con
);



if ($returnData['errorMessage'] == '') {
    $sql = 'SELECT
        VerificationCode,
        Password, 
        EID, 
        FirstName
        FROM users 
        WHERE Email = "' . $email . '"';
    $result = $con->query($sql);
    $row = mysqli_fetch_assoc($result);
    if ($password == $row['Password']) {
        session_start();
        if (!$returnData['isVerified']) {
            $_SESSION['verificationCode'] = $row['VerificationCode'];
        } else {
            $_SESSION['eid'] = $row['EID'];
            $_SESSION['firstName'] = $row['FirstName'];
            $_SESSION['password'] = $row['Password'];
        }
    } else {
        $returnData['errorMessage'] .= 'Incorrect email and/or password<br>';        
    }
}
echo json_encode($returnData);