<?php
class Security {
    public static function cleanInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public static function getUserType() {
        if (!isset($_SESSION['eid'])) 
            return 'guest';
        elseif ($_SESSION['eid'] == 1 | $_SESSION['eid'] == 2) 
            return 'authoritarian';
        else
            return 'user';
    }

    public static function assertUserIs($allowedUserTypes) {
        if (!in_array(static::getUserType(), $allowedUserTypes))
            exit("Access Denied");
    }
}