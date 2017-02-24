<?php
session_start();
require_once 'Class_Autoloader.php';

$location = Security::cleanInput($_POST['location']);

Data_Validation::connectDB();

if (Data_Validation::locationExists($location)) {
    $sql = "SELECT pick_up_points.Name 
           FROM pick_up_points, campus_locations
           WHERE campus_locations.Name = '$location'
           AND pick_up_points.LocationID = campus_locations.ID";
           
    $sqlResult = Data_Validation::$dbConnection->query($sql);

    $listOfPickUpPoints = [];
    $index = 0;
    while($row = mysqli_fetch_assoc($sqlResult)) {
        $listOfPickUpPoints[$index] = $row['Name'];
        $index++;
    }
    echo json_encode($listOfPickUpPoints);
}