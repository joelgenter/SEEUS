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