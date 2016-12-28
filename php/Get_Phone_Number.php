<?php
session_start();
require_once 'Class_Autoloader.php';

Security::assertUserIs(['authoritarian', 'user']);

Utility::connectDB();

$sql = 
    'SELECT
        PhoneNumber
    FROM escorts
    WHERE EID = "' . $_SESSION['eid'] . '"';

$sqlResult = Utility::$dbConnection->query($sql);

echo mysqli_fetch_assoc($sqlResult)['PhoneNumber'];