<?php
session_start();
require_once '../Class_Autoloader.php';

//cleaning the input which is boolean
$setToActive = Utility::cleanInput($_POST['setToActive']);

Utility::connectDB();

$sql = 
    'UPDATE killswitch_settings
    SET isActive = ' . $setToActive;
    
Utility::$dbConnection->query($sql);