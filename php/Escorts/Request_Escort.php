<?php
session_start();

require_once '../Class_Autoloader.php';
Data_Validation::connectDB();

$errorMessages = [];

$sql =
    'SELECT 
        1
    FROM escorts 
    INNER JOIN status_labels ON escorts.StatusID = status_labels.ID 
    WHERE status_labels.StatusLabel = "Requested" AND EID = "' . $_SESSION['eid'] . '"
    LIMIT 1';
$sqlResult = Data_Validation::$dbConnection->query($sql);

if ($sqlResult->num_rows > 0)
    array_push($errorMessages, "You already have a pending escort request");
else if (Data_Validation::serviceIsOnline()) {
    $numberInParty  = Utility::cleanInput($_POST['numberInParty']);
    $location       = Utility::cleanInput($_POST['location']);
    $destination    = Utility::cleanInput($_POST['destination']);
    $comments       = Utility::cleanInput($_POST['comments']);
    $phoneNumber    = Utility::cleanInput($_POST['phoneNumber']);

    Data_Validation::checkNumberInParty($numberInParty);
    Data_Validation::checkLocationDestination($location, $destination);
    Data_Validation::checkComments($comments);
    Data_Validation::checkPhoneNumber($phoneNumber);

    $errorMessages = Data_Validation::getErrorMessages();

    if (count($errorMessages) == 0) {
        $sql = "INSERT INTO escorts (
                    EID, 
                    NumberInParty, 
                    LocationID, 
                    DestinationID, 
                    Comments, 
                    PhoneNumber
                ) VALUES ('" . 
                    $_SESSION['eid'] . "', '" .
                    $numberInParty . "', " . 
                    "(SELECT ID FROM campus_locations WHERE Name = '" . $location . "'), " . 
                    "(SELECT ID FROM campus_locations WHERE Name = '" . $destination . "'), '" . 
                    $comments . "', '" . 
                    $phoneNumber . "'" .
                ")";

        if (!Data_Validation::$dbConnection->query($sql)) {
            array_push($errorMessages, $sql);
            // array_push($errorMessages, "Server error");
        }
    }
} else //service is offline
    array_push($errorMessages, "Service is currently offline");

echo json_encode($errorMessages);