<?php
session_start();
require_once '../Class_Autoloader.php';

Security::assertUserIs(['authoritarian']);

$campusLocationToAdd  = Security::cleanInput($_POST['campusLocationToAdd']);

Utility::connectDB();

Data_Validation::checkLocationName($campusLocationToAdd);

$errorMessages = Data_Validation::getErrorMessages();

if (count($errorMessages) == 0) {
    if (Data_Validation::locationExists($campusLocationToAdd)) {
        $sql = 'UPDATE campus_locations
                SET Enabled = 1
                WHERE Name = ?';

        $stmt = Utility::$dbConnection->prepare($sql);
        $stmt->bind_param("s", $campusLocationToAdd);
    } else {    //the name doesn't exist yet
        $sql = 
            "INSERT INTO campus_locations (
                Name,
                Enabled
            ) VALUES (
                ?, 
                1
            )";

        $stmt = Utility::$dbConnection->prepare($sql);
        $stmt->bind_param("s", $campusLocationToAdd);
    }
    $stmt->execute();
}

echo json_encode($errorMessages);