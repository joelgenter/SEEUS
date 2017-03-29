<?php
session_start();
require_once '../Class_Autoloader.php';

Security::assertUserIs(['authoritarian']);

//cleaning the input which is boolean
$setToActive = Security::cleanInput($_POST['setToActive']);

if ($setToActive == "true") {
    $setToActive = 1;
} else {
    $setToActive = 0;
}

Utility::connectDB();

$sql = 
    'UPDATE killswitch_settings
    SET isActive = ?';

$stmt = Utility::$dbConnection->prepare($sql);
$stmt->bind_param("i", $setToActive);

$stmt->execute();