<?php
require 'database/connection.php';
session_start();
/*if (!isset($_SESSION['eid'])) {
    header('Location: ../index.php');
} else if ($_SESSION['eid'] <= 2) {
    header('Location: ../index.php');
}*/
$emailError = $passwordError = $phoneNumberError = $errorMessage = "";
function testInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //Error checking to validate data entered by user
        
    //Email error check
    if (isset($_POST['email'])) {
        if ($_POST['email'] != $_SESSION['email'])
            $emailError = "Incorrect email for this account";
        elseif ($_POST['newEmail'] != $_POST['confirmEmail'])
            $emailError = "The email addresses you entered do not match";
        elseif (empty($_POST['email']) | empty($_POST['newEmail']) | empty($_POST['confirmEmail']))
            $emailError = "An email field is blank";
        elseif (!filter_var($_POST['newEmail'], FILTER_VALIDATE_EMAIL))
            $emailError = "Invalid email";
        elseif ($con->query("SELECT Email from users WHERE Email = '".$_POST['newEmail']."' LIMIT 1")->num_rows == 1) 
            $emailError = "This email is already registered";
        else {
            $newEmail = testInput($_POST['newEmail']);
            $con->query("UPDATE users SET Email = \"".$newEmail."\" WHERE EID = \"".$_SESSION['eid']."\"");
            $_SESSION['email'] = $newEmail;
        }
    }
    
    
    //Password error check
    if (isset($_POST['password'])) {
        if ($_POST['password'] != $_SESSION['password'])
            $passwordError = "Incorrect password";
        elseif ($_POST['newPassword'] != $_POST['confirmPassword'])
            $passwordError = "The passwords you entered do not match";
        elseif (strlen($_POST['newPassword']) < 5 | strlen($_POST['newPassword']) > 30)
            $passwordError = "Your password must be 5-30 characters long";
        elseif (!ctype_alnum($_POST['newPassword']))
            $passwordError = "Your password must only contain numbers and letters"; 
        else {
            $newPassword = testInput($_POST['newPassword']);
            $con->query("UPDATE users SET Password = \"".$newPassword."\" WHERE EID = \"".$_SESSION['eid']."\"");
            $_SESSION['password'] = $newPassword;
        }
    }
    
    
    //Phone number error check
    if (isset($_POST['phoneNumber'])) {
        if (!is_numeric($_POST['newPhoneNumber']) & !empty($_POST['newPhoneNumber']) | !empty($_POST['newPhoneNumber']) & strlen($_POST['newPhoneNumber']) != 10)
            $phoneNumberError = "Invalid phone number";
        elseif ($_POST['phoneNumber'] != $_SESSION['phoneNumber'])
            $phoneNumberError = "Incorrect phone number."; 
        else {
            $newPhoneNumber = testInput($_POST['newPhoneNumber']);
            $con->query("UPDATE users SET PhoneNumber = \"".$newPhoneNumber."\" WHERE EID = \"".$_SESSION['eid']."\"");
            $_SESSION['phoneNumber'] = $newPhoneNumber;
        }
    }

    //Assembles $errorMessage to be displayed in errorDiv
    if ($emailError != "")
        $errorMessage .= $emailError . "<br>";
    if ($passwordError != "")
        $errorMessage .= $passwordError . "<br>";
    if ($phoneNumberError != "")
        $errorMessage .= $phoneNumberError;
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Welcome to SEEUS</title>
<link rel="stylesheet" type="text/css" href="css/content.css">
<script>
    parent.iframeMenu.changeMenu(
        "<?php 
            if (isset($_SESSION['eid']))
                echo $_SESSION['eid'];
        ?>");
</script>
</head>
<body>
<div id="pageTitle">Settings</div>
<div id="focusDiv">
    <div id="errorDivContainer">
        <div id="errorDiv"><?php echo $errorMessage; ?></div>
    </div>
    <div id="subMenuDiv">
        <div class="changeFormOption" onClick="changeForm('email');">Email</div>
        <div class="changeFormOption" onClick="changeForm('password');">Password</div>
        <div class="changeFormOption" onClick="changeForm('phoneNumber');">Phone Number</div>
    </div>
    <br>
    <form method = "post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <span id="changeFormContainer">
        </span> <!--changeFormContainer-->
        <br> <input type="submit" value="Submit">
    </form>
</div> <!--focusDiv-->


    
    
    
    

<script>
    var changeFormContainer = document.getElementById('changeFormContainer'),
        changeFormOptionArray = document.getElementsByClassName('changeFormOption');
        
    function changeForm(newForm) {
        if (newForm == "email") {
            changeFormContainer.innerHTML = "&nbsp<input type=\"text\" name=\"email\" placeholder=\"Current Email\" value=\"<?php if (isset($_POST['email']))?>\">" +
                "<br>" +
                "&nbsp<input type=\"text\" name=\"newEmail\" placeholder=\"New Email\" value=\"<?php if (isset($_POST['newEmail']))?>\">&nbsp" +
                "<br>" +
                "&nbsp<input type=\"text\" name=\"confirmEmail\" placeholder=\"Confirm New Email\" value=\"<?php if (isset($_POST['confirmEmail']))?>\">";
            makeActive(0);
        }
        else if (newForm == "password") {
            changeFormContainer.innerHTML = "&nbsp<input type=\"password\" placeholder=\"Current Password\" name=\"password\" value=\"<?php if (isset($_POST['password']))?>\">" +
                "<br>" +
                "&nbsp<input type=\"password\" placeholder=\"New Password\" name=\"newPassword\" value=\"<?php if (isset($_POST['newPassword'])) ?>\">&nbsp" +
                "<br>" +
                "&nbsp<input type=\"password\" placeholder=\"Confirm Password\" name=\"confirmPassword\" value=\"<?php if (isset($_POST['confirmPassword']))?>\">";
            makeActive(1);
        } 
        else if (newForm == "phoneNumber") {
            changeFormContainer.innerHTML = "&nbsp<input type=\"text\" name=\"phoneNumber\" placeholder=\"Current Phone Number\" value=\"<?php if (isset($_POST['phoneNumber']))?>\">" +
                "<br>" +
                "&nbsp<input type=\"text\" name=\"newPhoneNumber\" placeholder=\"New Phone Number\" value=\"<?php if (isset($_POST['newPhoneNumber']))?>\">";
            makeActive(2);
        }
    }
    
    function makeActive(option) {
        if (option == 0) {
            changeFormOptionArray[0].id = "active";
            changeFormOptionArray[1].removeAttribute("id");
            changeFormOptionArray[2].removeAttribute("id");
        } else if (option == 1) {
            changeFormOptionArray[1].id = "active";
            changeFormOptionArray[0].removeAttribute("id");
            changeFormOptionArray[2].removeAttribute("id");
        } else {
            changeFormOptionArray[2].id = "active";
            changeFormOptionArray[0].removeAttribute("id");
            changeFormOptionArray[1].removeAttribute("id");
        }
        
    }
    
    //Decides which page to display based on whether or not the PHP error message variables are set
    if ("<?php echo $emailError?>" != "") 
        changeForm("email");
    else if ("<?php echo $passwordError?>" != "") 
        changeForm("password")
    else if ("<?php echo $phoneNumberError?>" != "") 
        changeForm("phoneNumber")
    else 
        changeForm('email');
</script>
</body>
</html>