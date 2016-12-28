<?php
session_start();
require_once 'Class_Autoloader.php';
Utility::connectDB();

$listOfLocations = Utility::getCampusLocations();

echo json_encode($listOfLocations);