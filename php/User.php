<?php
class User extends Utility {
    /*
    * declaration of local variables
    */
    public $userInfo;          //results of db query in constructor
    private $email;             //the email used to initialize this object
    private static $errorMessages = []; 

    /*
    * private helper methods
    */

    /*
    * magic methods
    */
    public function __construct($email) {
        static::connectDB();
        $this->email = $email;
        $sql = 'SELECT
                    PasswordHash,
                    EID,
                    FirstName,
                    Verified,
                    VerificationCode,
                    LastName
                FROM users 
                WHERE Email = ?';

        $stmt = Utility::$dbConnection->prepare($sql);
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result(
            $this->userInfo["PasswordHash"],
            $this->userInfo["EID"],
            $this->userInfo["FirstName"],
            $this->userInfo["Verified"],
            $this->userInfo["VerificationCode"],
            $this->userInfo["LastName"]
        );
        $stmt->fetch();
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
        $sql = "SELECT
                    1
                FROM users 
                WHERE Email = ?";

        $stmt = static::$dbConnection->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result(
            $exists
        );
        $stmt->fetch();

        if ($exists) {
            return TRUE;
        } else {
            array_push(static::$errorMessages, "Email not registered");
            return FALSE;
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
            if (password_verify($enteredPassword, $this->userInfo['PasswordHash'])) 
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

    //return true if successful or false if failed
    public function sendVerificationCode() {
        require_once "../vendor/autoload.php";

        //PHPMailer Object
        $mail = new PHPMailer;

        //From email address
        $mail->From = "noreply@seeus.com";
        $mail->FromName = "SEEUS EMU";

        //To address
        $mail->addAddress($this->email);

        //Send HTML or Plain Text email
        $mail->isHTML(true);

        $mail->Subject = "SEEUS Verification Code";
        $mail->Body = "<h1>SEEUS</h1><p>Here is your verification code: <strong>" . $this->userInfo['VerificationCode'] . "</strong>";
        $mail->AltBody = "This is the plain text version of the email content";

        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }

    public function verifyEmail() {
        $sql = 'UPDATE users
                SET Verified = 1
                WHERE EID = ?';

        $stmt = static::$dbConnection->prepare($sql);
        $stmt->bind_param("s", $this->userInfo['EID']);
        $stmt->execute();
    }

    public function changePassword($newPassword) {
        $sql = 'UPDATE users
                SET PasswordHash = ?
                WHERE EID = ?';

        $stmt = static::$dbConnection->prepare($sql);
        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt->bind_param("ss", $passwordHash, $this->userInfo['EID']);
        $stmt->execute();
    }

    public static function changePhoneNumber($newPhoneNumber) {
        $sql = 'UPDATE users
                SET PhoneNumber = ?
                WHERE EID = ?';

        $stmt = static::$dbConnection->prepare($sql);
        if (
            !$stmt->bind_param("ss", $newPhoneNumber, $_SESSION['eid']) ||
            !$stmt->execute()
        ) {
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
}