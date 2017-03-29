<?php
session_start();
require_once '../Class_Autoloader.php';

$start = Security::cleanInput($_POST['start']);
$maxRows = Security::cleanInput($_POST['maxRows']);

Utility::connectDB();

//if user is authoritarian or dispatcher, exclude where clause of sql statement
if ($_SESSION['eid'] == 1 || $_SESSION['eid'] == 2) 
    $whereClause = "";
else
    $whereClause = "WHERE escorts.EID = '" . $_SESSION['eid'] . "'";

$sql = 
    'SELECT 
        users.EID, 
        users.FirstName, 
        users.LastName,
        escorts.NumberInParty, 
        cl1.Name AS "Location",  
        cl2.Name AS "Destination", 
        pick_up_points.Name AS "PickUpPoint",
        escorts.PhoneNumber, 
        escorts.ID,
        escorts.DateTimeChanged,
        status_labels.StatusLabel,
        CASE status_labels.StatusLabel
            WHEN "Requested" THEN 0
            ELSE 1
        END AS "PrimaryOrder"
    FROM escorts 
    INNER JOIN users ON escorts.EID=users.EID
    INNER JOIN status_labels ON escorts.StatusID = status_labels.ID 
    INNER JOIN campus_locations cl1 ON escorts.LocationID = cl1.ID
    INNER JOIN campus_locations cl2 ON escorts.DestinationID = cl2.ID 
    INNER JOIN pick_up_points ON escorts.PickUpPointID = pick_up_points.ID '
    . $whereClause .
    ' ORDER BY PrimaryOrder ASC, escorts.DateTimeChanged DESC
    LIMIT ?, ?';



$stmt = Utility::$dbConnection->prepare($sql);
$stmt->bind_param("ii", $start, $maxRows);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result(
    $eid,
    $firstName,
    $lastName,
    $numberInParty,
    $location,
    $destination,
    $pickUpPoint,
    $phoneNumber,
    $id,
    $dateTimeChanged,
    $statusLabel,
    $primaryOrder       //not used
);


$escortList = [];
$numberOfResult = $stmt->num_rows;
for ($i = 0; $i < $numberOfResult; $i++) {
    $stmt->fetch();
    $escortList[$i] = [];
    $escortList[$i]['dateTimeChanged']  = $dateTimeChanged;
    $escortList[$i]['location']         = $location;
    $escortList[$i]['destination']      = $destination;
    $escortList[$i]['firstName']        = $firstName;
    $escortList[$i]['lastName']         = $lastName;
    $escortList[$i]['eid']              = $eid;
    $escortList[$i]['numberInParty']    = $numberInParty;
    $escortList[$i]['phoneNumber']      = $phoneNumber;
    $escortList[$i]['pickUpPoint']      = $pickUpPoint;
    $escortList[$i]['status']           = $statusLabel;
    $escortList[$i]['id']               = $id;
}
echo json_encode($escortList);
// echo json_encode($numberOfResult);
