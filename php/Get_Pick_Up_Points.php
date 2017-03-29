<?php
session_start();
require_once 'Class_Autoloader.php';

$location = Security::cleanInput($_POST['location']);

Data_Validation::connectDB();

if (Data_Validation::locationExists($location)) {
    $sql = 
        "SELECT pick_up_points.Name 
        FROM pick_up_points, campus_locations
        WHERE campus_locations.Name = ?
        AND pick_up_points.LocationID = campus_locations.ID
        AND pick_up_points.Enabled = 1";
    
    $stmt = Utility::$dbConnection->prepare($sql);
    $stmt->bind_param("s", $location);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($pickUpPoint);

    $listOfPickUpPoints = [];
    while ($stmt->fetch()) {
        array_push($listOfPickUpPoints, $pickUpPoint);
    }
    
    echo json_encode($listOfPickUpPoints);
}