<?php
session_start();
require_once '../Class_Autoloader.php';

Security::assertUserIs(['authoritarian']);

$campusLocation  = Security::cleanInput($_POST['campusLocation']);
$newPickUpPoint  = Security::cleanInput($_POST['newPickUpPoint']);

Utility::connectDB();

Data_Validation::checkPickUpPointName($newPickUpPoint);

$errorMessages = Data_Validation::getErrorMessages();

if (count($errorMessages) == 0) {
    if (Data_Validation::pickUpPointExists($campusLocation, $newPickUpPoint)) {
        $sql = 
            "UPDATE pick_up_points
            SET Enabled = 1
            WHERE Name = ?
            AND LocationID = (
                SELECT ID
                FROM campus_locations
                WHERE campus_locations.Name = ?
            )";
        $stmt = Utility::$dbConnection->prepare($sql);
        $stmt->bind_param("ss", $newPickUpPoint, $campusLocation);
    } else {    //the pick-up point doesn't exist yet
        $sql =
            "INSERT INTO pick_up_points (
                LocationID,
                Name,
                Enabled
            ) VALUES (
                (
                    SELECT ID
                    FROM campus_locations
                    WHERE campus_locations.Name = ?
                ),
                ?,
                1
            )";
        $stmt = Utility::$dbConnection->prepare($sql);
        $stmt->bind_param("ss", $campusLocation, $newPickUpPoint);
    }
    $stmt->execute();
}

echo json_encode($errorMessages);