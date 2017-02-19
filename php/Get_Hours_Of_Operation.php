<?php
session_start();
require_once 'Class_Autoloader.php';

Security::assertUserIs(['authoritarian']);

Utility::connectDB();

$sql = 
    'SELECT
        DayOfWeek,
        StartTime,
        Duration
    FROM hours_of_operation';

$sqlResult = Utility::$dbConnection->query($sql);

function calculateEndTime($startTime, $duration) {
    return date('H:i',strtotime('+' . $duration . ' minutes', strtotime($startTime)));
}

$hoursOfOperation = [];
while($row = mysqli_fetch_assoc($sqlResult)) {
    switch($row['DayOfWeek']) {
        case 'Sunday':
            $hoursOfOperation['sundayStart'] = $row['StartTime'];
            $hoursOfOperation['sundayEnd'] = calculateEndTime($row['StartTime'], $row['Duration']);
            break;
        case 'Monday':
            $hoursOfOperation['mondayStart'] = $row['StartTime'];
            $hoursOfOperation['mondayEnd'] = calculateEndTime($row['StartTime'], $row['Duration']);
            break;
        case 'Tuesday':
            $hoursOfOperation['tuesdayStart'] = $row['StartTime'];
            $hoursOfOperation['tuesdayEnd'] = calculateEndTime($row['StartTime'], $row['Duration']);
            break;
        case 'Wednesday':
            $hoursOfOperation['wednesdayStart'] = $row['StartTime'];
            $hoursOfOperation['wednesdayEnd'] = calculateEndTime($row['StartTime'], $row['Duration']);
            break;
        case 'Thursday':
            $hoursOfOperation['thursdayStart'] = $row['StartTime'];
            $hoursOfOperation['thursdayEnd'] = calculateEndTime($row['StartTime'], $row['Duration']);
            break;
        case 'Friday':
            $hoursOfOperation['fridayStart'] = $row['StartTime'];
            $hoursOfOperation['fridayEnd'] = calculateEndTime($row['StartTime'], $row['Duration']);
            break;
        case 'Saturday':
            $hoursOfOperation['saturdayStart'] = $row['StartTime'];
            $hoursOfOperation['saturdayEnd'] = calculateEndTime($row['StartTime'], $row['Duration']);
            break;
    }
}

echo json_encode($hoursOfOperation);