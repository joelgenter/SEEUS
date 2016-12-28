<?php
class Data_Validation extends Utility{

    private static $errorMessages = [];

    /*
    * data validation methods
    */
    public static function checkEmail($email) {
        //if empty
        if (empty($email))
            array_push(static::$errorMessages, "An email is required");
        //if not valid format
        else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            array_push(static::$errorMessages, "Invalid email");
        //if not emich domain
        else if (substr($email, -10) != "@emich.edu")
            array_push(static::$errorMessages, "Email must have emich.edu domain");
        //already registered
        elseif (static::$dbConnection->query("SELECT Email from users WHERE Email = '" . 
                $email . "'")->num_rows > 0)
            array_push(static::$errorMessages, " is already registered");
            
    }

    public static function checkPasswords($password, $confirmPassword) {
        //if empty
        if (empty($password))
            array_push(static::$errorMessages, "A password is required");
        //length not 5 - 30 characters
        elseif (strlen($password) < 5 || strlen($password) > 30)
            array_push(static::$errorMessages, "A password must be 5-30 characters long");
        //not alphanumeric
        elseif (!ctype_alnum($password))
            array_push(static::$errorMessages, "Your password must only contain numbers and letters");
        //passwords don't match
        elseif ($password != $confirmPassword)
            array_push(static::$errorMessages, "The passwords you entered do not match");
    }

    public static function checkFirstName($firstName) {
        //if empty
        if (empty($firstName))
            array_push(static::$errorMessages, "Your first name is required");
        //if not alpha
        elseif (!ctype_alpha($firstName))
            array_push(static::$errorMessages, "Invalid first name");
        //if not between 2 - 50 characters
        elseif (strlen($firstName) < 2 || strlen($firstName) > 50)
            array_push(static::$errorMessages, "Invalid first name");
            
    }

    public static function checkLastName($lastName) {
        //if empty
        if (empty($lastName))
            array_push(static::$errorMessages, "Your last name is required");
        //if not alpha
        elseif (!ctype_alpha($lastName))
            array_push(static::$errorMessages, "Invalid last name");
        //if not between 2 - 50 characters
        elseif (strlen($lastName) < 2 || strlen($lastName) > 50)
            array_push(static::$errorMessages, "Invalid last name");
            
    }

    public static function checkEID($eid) {
        //if empty
        if (empty($eid))
            array_push(static::$errorMessages, "Your EID is required");
        //if not 8 characters
        elseif (strlen($eid) != 8)
            array_push(static::$errorMessages, "Invalid EID");
        //if not numeric
        elseif (!(is_numeric($eid)))
            array_push(static::$errorMessages, "Invalid EID");
        elseif (static::$dbConnection->query("SELECT Email from users WHERE EID = '" .
                $eid . "'")->num_rows > 0)
            array_push(static::$errorMessages, "EID is already registered");
            
    }

    public static function checkPhoneNumber($phoneNumber) {
        //if empty
        if (empty($phoneNumber))
            array_push(static::$errorMessages, "A phone number required");
        //if not empty and not numeric
        elseif (!is_numeric($phoneNumber))
            array_push(static::$errorMessages, "Invalid phone number");
        //if not empty and not 10 characters
        elseif (strlen($phoneNumber) != 10)
            array_push(static::$errorMessages, "Invalid phone number");

    }

    public static function checkNumberInParty($numberInParty) {
        //if empty
        if (empty($numberInParty))
            array_push(static::$errorMessages, "A number in party is required");
        elseif ($numberInParty > 3)
            array_push(static::$errorMessages, "The maximum number in party is 3");
        elseif ($numberInParty < 1)
            array_push(static::$errorMessages, "The minimum number in party is 1");
        elseif (!is_numeric($numberInParty) || strlen($numberInParty) > 1)
            array_push(static::$errorMessages, "Invalid number in party");
    }

    //i need more data validation for specific locations on campus
    public static function checkLocationDestination($location, $destination) {
        $campusLocations = static::getCampusLocations();
        if (!in_array($location, $campusLocations))
            array_push(static::$errorMessages, "Invalid location");
        else if (!in_array($destination, $campusLocations))
            array_push(static::$errorMessages, "Invalid destination");
        else if ($location == $destination) {
            array_push(static::$errorMessages, "Location and destination cannot be the same");
        }
    }

    public static function checkComments($comments) {
        
        if (!empty($comments) && strlen($comments) > 100)
            array_push(static::$errorMessages, "Comments can be a maxmium of 100 characters");

    }

    public static function checkLocationName($locationName) {
        if (empty($locationName)) 
            array_push(static::$errorMessages, "A location name is required");
        else if (strlen($locationName) < 2) 
            array_push(static::$errorMessages, "Location names must be more than 2 characters");
        else if (strlen($locationName) > 30) 
            array_push(static::$errorMessages, "Location names must be no more than 30 characters");
    }

    public static function timeFormatCorrect($time) {
        //if in military time format
        if (preg_match("/([01][0-9]|2[0-3]):[0-5][0-9]/", $time)) {
            return TRUE;
        } else {
            array_push(static::$errorMessages, "Invalid time format");
            return FALSE;
        }
    }

    /*
    * returns the accumulated error messages from validation methods
    */
    public static function getErrorMessages() {
        return static::$errorMessages;
    }
}