<?php
session_start();
require_once '../Class_Autoloader.php';

Security::assertUserIs(['authoritarian']);

//cleaning the input
$sundayStart    = Security::cleanInput($_POST['sundayStart']);
$sundayEnd      = Security::cleanInput($_POST['sundayEnd']);
$mondayStart    = Security::cleanInput($_POST['mondayStart']);
$mondayEnd      = Security::cleanInput($_POST['mondayEnd']);
$tuesdayStart   = Security::cleanInput($_POST['tuesdayStart']);
$tuesdayEnd     = Security::cleanInput($_POST['tuesdayEnd']);
$wednesdayStart = Security::cleanInput($_POST['wednesdayStart']);
$wednesdayEnd   = Security::cleanInput($_POST['wednesdayEnd']);
$thursdayStart  = Security::cleanInput($_POST['thursdayStart']);
$thursdayEnd    = Security::cleanInput($_POST['thursdayEnd']);
$fridayStart    = Security::cleanInput($_POST['fridayStart']);
$fridayEnd      = Security::cleanInput($_POST['fridayEnd']);
$saturdayStart  = Security::cleanInput($_POST['saturdayStart']);
$saturdayEnd    = Security::cleanInput($_POST['saturdayEnd']);

function calculateDuration($startTime, $endTime) {
    $startTime = strtotime($startTime);
    $endTime = strtotime($endTime);
    $duration = ($endTime - $startTime) / 60;

    if ($endTime < $startTime)  //to take care of end time being before start time
        $duration += 1440;

    return $duration;
}

$sundayDuration = calculateDuration($sundayStart, $sundayEnd);
$mondayDuration = calculateDuration($mondayStart, $mondayEnd);
$tuesdayDuration = calculateDuration($tuesdayStart, $tuesdayEnd);
$wednesdayDuration = calculateDuration($wednesdayStart, $wednesdayEnd);
$thursdayDuration = calculateDuration($thursdayStart, $thursdayEnd);
$fridayDuration = calculateDuration($fridayStart, $fridayEnd);
$saturdayDuration = calculateDuration($saturdayStart, $saturdayEnd);

$errorMessages = Data_Validation::getErrorMessages();

if (count($errorMessages) == 0) {
    Utility::connectDB();
    
    $sql = 
        'INSERT INTO hours_of_operation 
            (DayOfWeek, StartTime, Duration) 
        VALUES 
            ("Sunday", ?, ?),
            ("Monday", ?, ?),
            ("Tuesday", ?, ?),
            ("Wednesday", ?, ?),
            ("Thursday", ?, ?),
            ("Friday", ?, ?),
            ("Saturday", ?, ?)
        ON DUPLICATE KEY UPDATE StartTime = VALUES(StartTime), Duration = VALUES(Duration)';

    if (!$stmt = Utility::$dbConnection->prepare($sql)) {
        array_push($errorMessages, "jklfj;lk");
    }
    $stmt->bind_param("sisisisisisisi", 
        $sundayStart, $sundayDuration,
        $mondayStart, $mondayDuration,
        $tuesdayStart, $tuesdayDuration,
        $wednesdayStart, $wednesdayDuration,
        $thursdayStart, $thursdayDuration,
        $fridayStart, $fridayDuration,
        $saturdayStart, $saturdayDuration
    );
    if (!$stmt->execute()) {
        array_push($errorMessages, "Error changing hours of operation");
    }
}

echo json_encode($errorMessages);