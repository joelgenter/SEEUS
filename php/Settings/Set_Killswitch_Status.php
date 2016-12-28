<?php
session_start();
require_once '../Class_Autoloader.php';

Security::assertUserIs(['authoritarian']);

//cleaning the input which is boolean
$setToActive = Security::cleanInput($_POST['setToActive']);

Utility::connectDB();

$sql = 
    'UPDATE killswitch_settings
    SET isActive = ' . $setToActive;
    
Utility::$dbConnection->query($sql);