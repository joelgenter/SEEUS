<?php
session_start();
require_once '../Class_Autoloader.php';

Security::assertUserIs(['authoritarian']);

$campusLocation  = Security::cleanInput($_POST['campusLocation']);
$oldPickUpPoint  = Security::cleanInput($_POST['oldPickUpPoint']);

Utility::connectDB();

$sql = "UPDATE pick_up_points
        SET Enabled = 0
        WHERE Name = '$oldPickUpPoint'
        AND LocationID = (
            SELECT ID
            FROM campus_locations
            WHERE Name = '$campusLocation'
        )";

$errorMessages = [];

if (!Utility::$dbConnection->query($sql)) {
    // array_push($errorMessages, "Error deleting pick-up point");
    array_push($errorMessages, $sql);
} 

echo json_encode($errorMessages);