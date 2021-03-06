<?php
class Utility {
    public static $dbConnection;

    public static function connectDB() {
        $databaseCredentials = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/../.ini');
        static::$dbConnection = new mysqli(
            $databaseCredentials['host'],
            $databaseCredentials['user'],
            $databaseCredentials['password'], 
            $databaseCredentials['name']
        );
        
        if (mysqli_connect_error()) {
            die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
        }
    }

    public static function getCampusLocations() {
        $sql = 
            'SELECT
                Name
            FROM campus_locations
            WHERE Enabled = 1
            ORDER BY Name ASC';

        $sqlResult = static::$dbConnection->query($sql);

        $listOfLocations = [];
        $index = 0;
        while($row = mysqli_fetch_assoc($sqlResult)){
            $listOfLocations[$index] = $row['Name']; // Inside while loop
            $index++;
        }
        return $listOfLocations;
    }

    public static function killswitchIsActive() {
        $sql = 
            'SELECT
                isActive
            FROM killswitch_settings';

        $sqlResult = static::$dbConnection->query($sql);

        return mysqli_fetch_assoc($sqlResult)['isActive']; //echos a true or false value
    }

    public static function serviceIsOnline() {
        $serviceIsOnline = TRUE;
        if (static::killswitchIsActive()) {
            $serviceIsOnline = FALSE;
        } else {
            //get days of week and dates for yesterday and today
            $dayOfWeekYesterday = date('l', strtotime("-1 days"));
            $dayOfWeekToday     = date('l');
            $dateYesterday      = date('m/d/Y', strtotime("-1 days"));
            $dateToday          = date('m/d/Y');
            $sql = 
                'SELECT
                    DayOfWeek,
                    StartTime,
                    Duration
                FROM hours_of_operation
                WHERE DayOfWeek = "' . $dayOfWeekYesterday . '" OR DayOfWeek = "' . $dayOfWeekToday . '"';

            $sqlResult = static::$dbConnection->query($sql);

            //the vars I'm getting from the query
            $startTimeYesterday;
            $durationYesterday;
            $startTimeToday;
            $durationToday;
            while($row = mysqli_fetch_assoc($sqlResult)) {
                if ($row['DayOfWeek'] == $dayOfWeekYesterday) {
                    $startTimeYesterday = $row['StartTime'];
                    $durationYesterday = $row['Duration'];
                } else if ($row['DayOfWeek'] == $dayOfWeekToday) {
                    $startTimeToday = $row['StartTime'];
                    $durationToday = $row['Duration'];
                }
            }

            //all evaluate to seconds since 1/1/1970
            $now               = strtotime(date("m/d/Y H:i:s"));
            $yesterdayShiftEnd = strtotime($dateYesterday . " " . $startTimeYesterday . " + " . $durationYesterday . " minutes");
            $todayShiftStart   = strtotime($dateToday . " " . $startTimeToday);
            $todayShiftEnd     = strtotime($dateToday . " " . $startTimeToday . " + " . $durationToday . " minutes");


            // //TESTING
            // return "Today: " . date("m/d/Y H:i:s") . "\nYesterday's date: " . $dateYesterday . "\nYesterday's shift start time: " . $startTimeYesterday . "\nLength of Yesterday's shift: " . $durationYesterday;
            // return "Now: ". date("m/d/Y H:i:s", $now) . "\nYesterdayShiftEnd: " . date("m/d/Y H:i:s", $yesterdayShiftEnd) . "\nTodayShiftStart: " . date("m/d/Y H:i:s", $todayShiftStart) . "\nTodayShiftEnd: " . date("m/d/Y H:i:s", $todayShiftEnd) . "\nnow >= yesterdayShiftEnd: " . ($now < $yesterdayShiftEnd); //testing 
            // //TESTING
            

            if (
                !($now < $yesterdayShiftEnd) &&    //the shift that started yesterday has ended
                !($todayShiftStart < $now && $now < $todayShiftEnd)  //the shift that started today is not running
            ) {
                $serviceIsOnline = FALSE;
            }
        }
        return $serviceIsOnline;
    }

    public static function generateVerificationCode() {
        $verificationCode = "";
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        for ($i = 0; $i < 8; $i++) {
            $verificationCode .= $chars{rand(0, 61)};
        }
        return $verificationCode;
    }
}