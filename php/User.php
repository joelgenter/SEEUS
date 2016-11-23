<?php
class User extends Utility{
    /*
    * declaration of local variables
    */
    private $dbConnection;      //database mysqli connection
    private $userInfo;          //results of db query in constructor
    private $email;             //the email used to initialize this object

    //the data ultimately returned to UI in JSON
    private $returnData = [
        "emailRegistered"           => NULL,
        "emailVerified"             => NULL,
        "passwordCorrect"           => NULL,
        "verificationCodeCorrect"   => NULL,
        "errorMessages"             => []
    ];


    /*
    * constructor function
    */
    public function __construct($dbConnection, $email) {
        $this->dbConnection = $dbConnection;
        $this->email = $this->cleanInput($email);
        $sql = 'SELECT
                    Password,
                    EID,
                    FirstName,
                    Verified,
                    VerificationCode,
                    Password,
                    EID,
                    FirstName
                FROM users 
                WHERE Email = "' . $this->email . '"';
        $result = $this->dbConnection->query($sql);
        $this->userInfo = mysqli_fetch_assoc($result);
    }


    /*
    * verification functions
    */
    public function checkEmailRegistration() { 
            if ($this->userInfo == FALSE) {
                $this->returnData['emailRegistered'] = FALSE;
                array_push($this->returnData['errorMessages'], "Email not registered");
            } else 
                $this->returnData['emailRegistered'] = TRUE;
    }

    public function checkEmailVerification() {
        if ($this->userInfo != FALSE) {
            if ($this->userInfo['Verified'] == 1)
                $this->returnData['emailVerified'] = TRUE;
            else
                $this->returnData['emailVerified'] = FALSE; 
        }
    }

    public function checkPassword($enteredPassword) {
        if ($this->userInfo != FALSE) {
            $enteredPassword = $this->cleanInput($enteredPassword);
            if ($this->userInfo['Password'] == $enteredPassword) 
                $this->returnData['passwordCorrect'] = TRUE;
            else {
                $this->returnData['passwordCorrect'] = FALSE;
                array_push($this->returnData['errorMessages'],
                    "Incorrect password"
                );
            }
        }
    }
    
    public function checkVerificationCode($enteredCode) {
        $enteredCode = cleanInput($enteredCode);
        if ($enteredCode == $this->userInfo["VerificationCode"])
            $this->returnData["verificationCodeCorrect"] == TRUE;
        else {
            $this->returnData["verificationCodeCorrect"] == FALSE;
            array_push($this->returnData['errorMessages'], 
                "Incorrect verification code"
            );                        
        }
    }


    /*
    * user actions
    */
    public function login() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['eid'] = $this->userInfo['EID'];
        $_SESSION['firstName'] = $this->userInfo['FirstName'];
        $_SESSION['password'] = $this->userInfo['Password'];
    }

    public function sendVerificationCode() {
        mail(
            $email,                         //recipient
            "SEEUS Verification Code",      //subject
            "Your verification code is: " . //message
                    $this->userInfo['VerificationCode']
        );
    }

    public function verifyEmail() {
        $sql = "UPDATE users
                SET Verified = 1
                WHERE Email = " . $email;
        $this->dbConnection->query($sql);
    }


    /*
    * get functions
    */
    public function getReturnData() {
        return $this->returnData;
    }


    /*
    * maintenance functions
    */
    public function clearErrorMessages() {
        $this->returnData['errorMessages'] = [];//clear out error messages        
    }
}