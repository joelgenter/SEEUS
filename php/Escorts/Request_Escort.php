<?php
session_start();

require_once '../Class_Autoloader.php';
Data_Validation::connectDB();

$errorMessages = [];

$sql =
    'SELECT 1
    FROM escorts 
    INNER JOIN status_labels ON escorts.StatusID = status_labels.ID 
    WHERE status_labels.StatusLabel = "Requested" AND EID = "' . $_SESSION['eid'] . '"
    LIMIT 1';
$sqlResult = Data_Validation::$dbConnection->query($sql);

if ($sqlResult->num_rows > 0)
    array_push($errorMessages, "You already have a pending escort request");
else if (Data_Validation::serviceIsOnline()) {
    $numberInParty  = Security::cleanInput($_POST['numberInParty']);
    $location       = Security::cleanInput($_POST['location']);
    $destination    = Security::cleanInput($_POST['destination']);
    $pickUpPoint    = Security::cleanInput($_POST['pickUpPoint']);
    $phoneNumber    = Security::cleanInput($_POST['phoneNumber']);

    Data_Validation::checkNumberInParty($numberInParty);
    Data_Validation::checkLocationDestination($location, $destination);
    Data_Validation::checkPickUpPoint($location, $pickUpPoint);
    Data_Validation::checkPhoneNumber($phoneNumber);

    $errorMessages = Data_Validation::getErrorMessages();

    if (count($errorMessages) == 0) {
        $sql = 
            "INSERT INTO escorts (
                EID, 
                NumberInParty, 
                LocationID, 
                PickUpPointID,
                DestinationID, 
                PhoneNumber
            ) VALUES ( 
                ?,
                ?, 
                (SELECT ID FROM campus_locations WHERE Name = ?),
                (SELECT ID FROM pick_up_points WHERE Name = ?), 
                (SELECT ID FROM campus_locations WHERE Name = ?),
                ?
            )";

        $stmt = Data_Validation::$dbConnection->prepare($sql);
        $stmt->bind_param("sissss", $_SESSION['eid'], $numberInParty, $location, $pickUpPoint, $destination, $phoneNumber);
        

        if (!$stmt->execute()) {
            array_push($errorMessages, "Server error");
        }
    }
} else {
    array_push($errorMessages, "Service is currently offline");
}

echo json_encode($errorMessages);