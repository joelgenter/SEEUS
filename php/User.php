<?php
class User extends Utility {
    /*
    * declaration of local variables
    */
    // private static $dbConnection;      //database mysqli connection
    public $userInfo;          //results of db query in constructor
    private $email;             //the email used to initialize this object
    private static $errorMessages = []; 

    /*
    * private helper methods
    */
    // private static function connectDB() {
    //      static::$dbConnection = new mysqli(
    //         static::$DB_HOST, static::$DB_USER, static::$DB_PASS, static::$DB_NAME
    //     );
    // }

    /*
    * magic methods
    */
    public function __construct($email) {
        static::connectDB();
        $this->email = $email;
        $sql = 'SELECT
                    Password,
                    EID,
                    FirstName,
                    Verified,
                    VerificationCode,
                    Password,
                    LastName
                FROM users 
                WHERE Email = "' . $this->email . '"';
        $result = static::$dbConnection->query($sql);
        $this->userInfo = mysqli_fetch_assoc($result);     
    }

    public function __sleep() {
        $this->userInfo = serialize($this->userInfo);
        $this->email = serialize($this->email);
        return array('email', 'userInfo');
        // unset(static::$dbConnection);
    }

    public function __wakeup() {
        $this->userInfo = unserialize($this->userInfo);
        $this->email = unserialize($this->email);        
        static::connectDB();
    }



    /*
    * verification functions
    * return boolean values and push strings to $errorMessages when relevant
    */
    public static function emailRegistered($email) {
        static::connectDB();
        $sql = 'SELECT
                    Email
                FROM users 
                WHERE Email = "' . $email . '"';
                
        $result = static::$dbConnection->query($sql);

        if ($result->num_rows == 0) {
            array_push(static::$errorMessages, "Email not registered");
            return false;
        } else {
            return true;
        }
    }

    public function emailVerified() {
        if ($this->userInfo != FALSE && $this->userInfo['Verified'] == 1) 
            return TRUE;
        else
            return FALSE; 
    }

    public function passwordCorrect($enteredPassword) {
        if ($this->userInfo != FALSE) {
            if ($this->userInfo['Password'] == $enteredPassword) 
                return TRUE;
            else {
                array_push(static::$errorMessages, "Incorrect password");
                return FALSE;
            }
        } else 
            return FALSE;
    }
    
    public function verificationCodeCorrect($enteredCode) {
        if ($enteredCode == $this->userInfo["VerificationCode"])
            return TRUE;
        else {
            array_push(static::$errorMessages, "Incorrect verification code");
            return FALSE;                        
        }
    }


    /*
    * user actions
    */
    public function login() {
        $_SESSION['eid'] = $this->userInfo['EID'];
        $_SESSION['email'] = $this->email;
        $_SESSION['firstName'] = $this->userInfo['FirstName'];
    }

    public function logout() {
        
    }

    public function sendVerificationCode() {
        mail(
            $this->email,                         //recipient
            "SEEUS Verification Code",      //subject
            "Your verification code is: " . //message
                    $this->userInfo['VerificationCode']
        );
    }

    public function verifyEmail() {
        $sql = 'UPDATE users
                SET Verified = 1
                WHERE EID = "' . $this->userInfo['EID'] . '"';
        static::$dbConnection->query($sql);
    }

    public function changePassword($newPassword) {
        $sql = 'UPDATE users
                SET Password = "' . $newPassword . '"
                WHERE EID = "' . $_SESSION['eid'] . '"';
        if (!static::$dbConnection->query($sql)) {
            array_push(static::$errorMessages, "Could not change password");
        }        
    }

    public static function changePhoneNumber($newPhoneNumber) {
        $sql = 'UPDATE users
                SET PhoneNumber = "' . $newPhoneNumber . '"
                WHERE EID = "' . $_SESSION['eid'] . '"';
        if (!static::$dbConnection->query($sql)) {
            array_push(static::$errorMessages, "Could not change phone number");
        }  
    }

    /*
    * get functions
    */
    public static function getErrorMessages() {
        $errorMessages = static::$errorMessages;
        return $errorMessages;
    }


    /*
    * maintenance functions
    */

}