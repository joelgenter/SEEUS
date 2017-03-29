<?php
session_start();
require_once '../Class_Autoloader.php';

Security::assertUserIs(['authoritarian']);

$campusLocation  = Security::cleanInput($_POST['campusLocation']);
$oldPickUpPoint  = Security::cleanInput($_POST['oldPickUpPoint']);

Utility::connectDB();

$sql = "UPDATE pick_up_points
        SET Enabled = 0
        WHERE Name = ?
        AND LocationID = (
            SELECT ID
            FROM campus_locations
            WHERE Name = ?
        )";

$stmt = Utility::$dbConnection->prepare($sql);
$stmt->bind_param("ss", $oldPickUpPoint, $campusLocation);

$errorMessages = [];

if (!$stmt->execute()) {
    array_push($errorMessages, "Error deleting pick-up point");
} 

echo json_encode($errorMessages);