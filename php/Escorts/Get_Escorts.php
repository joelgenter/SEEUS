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
    $whereClause = 'WHERE escorts.EID = "' . $_SESSION['eid'] . '"';

$sql = 
    'SELECT 
        users.EID, 
        users.FirstName, 
        users.LastName,
        escorts.NumberInParty, 
        cl1.Name AS "Location",  
        cl2.Name AS "Destination", 
        escorts.Comments, 
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
    INNER JOIN campus_locations cl2 ON escorts.DestinationID = cl2.ID '
    . $whereClause .
    ' ORDER BY PrimaryOrder ASC, escorts.DateTimeChanged DESC
    LIMIT ' . $start . ', ' . $maxRows;

$escortList = [];
$sqlResult = Utility::$dbConnection->query($sql);
$numberOfResult = $sqlResult->num_rows;
for ($i = 0; $i < $numberOfResult; $i++) {
    $nextRow = mysqli_fetch_assoc($sqlResult);
    $escortList[$i] = [];
    $escortList[$i]['dateTimeChanged']  = $nextRow['DateTimeChanged'];
    $escortList[$i]['location']         = $nextRow['Location'];
    $escortList[$i]['destination']      = $nextRow['Destination'];
    $escortList[$i]['firstName']        = $nextRow['FirstName'];
    $escortList[$i]['lastName']         = $nextRow['LastName'];
    $escortList[$i]['eid']              = $nextRow['EID'];
    $escortList[$i]['numberInParty']    = $nextRow['NumberInParty'];
    $escortList[$i]['phoneNumber']      = $nextRow['PhoneNumber'];
    $escortList[$i]['comments']         = $nextRow['Comments'];
    $escortList[$i]['status']           = $nextRow['StatusLabel'];
    $escortList[$i]['id']               = $nextRow['ID'];
}
echo json_encode($escortList);
// echo $sql;