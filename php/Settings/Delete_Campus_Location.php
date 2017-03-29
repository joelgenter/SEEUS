<?php
session_start();
require_once '../Class_Autoloader.php';

Security::assertUserIs(['authoritarian']);

$campusLocationToDelete  = Security::cleanInput($_POST['campusLocationToDelete']);

Utility::connectDB();

$sql = 'UPDATE campus_locations
        SET Enabled = 0
        WHERE Name = ?';

$stmt = Utility::$dbConnection->prepare($sql);
$stmt->bind_param("s", $campusLocationToDelete);

$errorMessages = [];

if (!$stmt->execute()) {
    array_push($errorMessages, "Error deleting campus location");
}  

echo json_encode($errorMessages);