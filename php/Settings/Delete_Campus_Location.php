<?php
session_start();
require_once '../Class_Autoloader.php';

$campusLocationToDelete  = Utility::cleanInput($_POST['campusLocationToDelete']);


Utility::connectDB();



$errorMessages = [];

$sql = 'UPDATE campus_locations
        SET Enabled = 0
        WHERE Name = "' . $campusLocationToDelete . '"';

if (!Utility::$dbConnection->query($sql)) {
    array_push($errorMessages, "Error deleting campus location");
}  

echo json_encode($errorMessages);