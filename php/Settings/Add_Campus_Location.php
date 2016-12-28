<?php
session_start();
require_once '../Class_Autoloader.php';

$campusLocationToAdd  = Utility::cleanInput($_POST['campusLocationToAdd']);

Utility::connectDB();

Data_Validation::checkLocationName($campusLocationToAdd);

$errorMessages = Data_Validation::getErrorMessages();

if (count($errorMessages) == 0) {
    $sql = 'SELECT
                1
            FROM campus_locations
            WHERE Name = "' . $campusLocationToAdd . '"';
    $sqlResult = Utility::$dbConnection->query($sql);
    
    if ($sqlResult->num_rows > 0) { //the name already exists, enable it
        $sql = 'UPDATE campus_locations
                SET Enabled = 1
                WHERE Name = "' . $campusLocationToAdd . '"';
        Utility::$dbConnection->query($sql);

    } else {    //the name doesn't exist yet
        $sql = "INSERT INTO campus_locations (
                Name, 
                Enabled
            ) VALUES ('" . 
                $campusLocationToAdd . "', 
                1
            )";
        Utility::$dbConnection->query($sql);
    }
}

echo json_encode($errorMessages);