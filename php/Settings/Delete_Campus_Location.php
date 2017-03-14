<?php
session_start();
require_once '../Class_Autoloader.php';

Security::assertUserIs(['authoritarian']);

$campusLocationToDelete  = Security::cleanInput($_POST['campusLocationToDelete']);

Utility::connectDB();

$sql = 'UPDATE campus_locations
        SET Enabled = 0
        WHERE Name = "' . $campusLocationToDelete . '"';

$errorMessages = [];

if (!Utility::$dbConnection->query($sql)) {
    array_push($errorMessages, "Error deleting campus location");
}  

echo json_encode($errorMessages);