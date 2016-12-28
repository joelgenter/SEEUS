<?php
session_start();
require_once '../Class_Autoloader.php';

//cleaning the input
$sundayStart    = Utility::cleanInput($_POST['sundayStart']);
$sundayEnd      = Utility::cleanInput($_POST['sundayEnd']);
$mondayStart    = Utility::cleanInput($_POST['mondayStart']);
$mondayEnd      = Utility::cleanInput($_POST['mondayEnd']);
$tuesdayStart   = Utility::cleanInput($_POST['tuesdayStart']);
$tuesdayEnd     = Utility::cleanInput($_POST['tuesdayEnd']);
$wednesdayStart = Utility::cleanInput($_POST['wednesdayStart']);
$wednesdayEnd   = Utility::cleanInput($_POST['wednesdayEnd']);
$thursdayStart  = Utility::cleanInput($_POST['thursdayStart']);
$thursdayEnd    = Utility::cleanInput($_POST['thursdayEnd']);
$fridayStart    = Utility::cleanInput($_POST['fridayStart']);
$fridayEnd      = Utility::cleanInput($_POST['fridayEnd']);
$saturdayStart  = Utility::cleanInput($_POST['saturdayStart']);
$saturdayEnd    = Utility::cleanInput($_POST['saturdayEnd']);

foreach ($_POST as $key => $value) {
    if (!Data_Validation::timeFormatCorrect($value)) {
        break;  //to prevent replicated errors
    }
}

function calculateDuration($startTime, $endTime) {
    $startTime = strtotime($startTime);
    $endTime = strtotime($endTime);
    $duration = ($endTime - $startTime) / 60;

    if ($endTime < $startTime)  //to take care of end time being before start time
        $duration += 1440;

    return $duration;
}

$errorMessages = Data_Validation::getErrorMessages();

if (count($errorMessages) == 0) {
    Utility::connectDB();
    
    $sql = 
        'INSERT INTO hours_of_operation 
            (DayOfWeek, StartTime, Duration) 
        VALUES 
            ("Sunday", "' . $sundayStart . '", ' . calculateDuration($sundayStart, $sundayEnd) . '),
            ("Monday", "' . $mondayStart . '", ' . calculateDuration($mondayStart, $mondayEnd) . '),
            ("Tuesday", "' . $tuesdayStart . '", ' . calculateDuration($tuesdayStart, $tuesdayEnd) . '),
            ("Wednesday", "' . $wednesdayStart . '", ' . calculateDuration($wednesdayStart, $wednesdayEnd) . '),
            ("Thursday", "' . $thursdayStart . '", ' . calculateDuration($thursdayStart, $thursdayEnd) . '),
            ("Friday", "' . $fridayStart . '", ' . calculateDuration($fridayStart, $fridayEnd) . '),
            ("Saturday", "' . $saturdayStart . '", ' . calculateDuration($saturdayStart, $saturdayEnd) . ')
        ON DUPLICATE KEY UPDATE StartTime = VALUES(StartTime), Duration = VALUES(Duration)';

        // array_push($errorMessages, $sql);
    
    $sqlResult = Utility::$dbConnection->query($sql);
}

echo json_encode($errorMessages);