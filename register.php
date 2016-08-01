<?php
require 'database/connection.php';
if (isset($_SESSION['eid'])) {
    header('Location: ../index.php');
}
$emailError = $passwordError = $firstNameError = $lastNameError = $eidError = $phoneNumberError =
    $errorMessage = "";
function testInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //Error checking to validate data entered by user
        
    //Email error check
    if (empty($_POST['email']))
        $emailError = "An email is required";
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        $emailError = "Invalid email";
	elseif ($con->query("SELECT Email from users WHERE Email = '".$_POST['email']."' LIMIT 1")->num_rows == 1) 
        $emailError = "This email is already registered";
    else {
        $emailError = "";
        $email = testInput($_POST['email']);
    }
    
    //Password error check
    if ($_POST['password'] != $_POST['passwordConfirm'])
            $passwordError = "The passwords you entered do not match";
    elseif (empty($_POST['password']))
            $passwordError = "A password is required";
    elseif (strlen($_POST['password']) < 5 | strlen($_POST['password']) > 30)
            $passwordError = "Your password must be 5-30 characters long";
    elseif (!ctype_alnum($_POST['password']))
            $passwordError = "Your password must only contain numbers and letters"; 
    else {
            $passwordError = "";
            $password = testInput($_POST['password']);
    }
    
    //First name error check
    if (empty($_POST['firstName']))
        $firstNameError = "Your first name is required";
    elseif ((!preg_match("#^[a-zA-Z ]+$#", $_POST['firstName']) | strlen($_POST['firstName']) < 2))
        $firstNameError = "Invalid first name";
    else {
        $firstNameError = "";
        $firstName = testInput($_POST['firstName']);
    }
       
    //Last name error check
    if (empty($_POST['lastName']))
        $lastNameError = "Your last name is required";
    elseif ((!preg_match("#^[a-zA-Z ]+$#", $_POST['lastName']) | strlen($_POST['lastName']) < 2))
        $lastNameError = "Invalid last name";
    else {
        $lastNameError = "";
        $lastName = testInput($_POST['lastName']);
    }
    
    //EID error check
    if (empty($_POST['eid']))
        $eidError = "Your EID is required";
    elseif (strlen($_POST['eid']) != 8 | !(is_numeric($_POST['eid'])))
        $eidError = "Invalid EID";
    elseif ($con->query("SELECT EID from users WHERE EID = '".$_POST['eid']."' LIMIT 1")->num_rows == 1) 
        $eidError = "This EID is already registered.";
    else {
        $eidError = "";
        $eid = testInput($_POST['eid']);
    }
    
    //Phone number error check
    if (!is_numeric($_POST['phoneNumber']) & !empty($_POST['phoneNumber']) | !empty($_POST['phoneNumber']) & strlen($_POST['phoneNumber']) != 10)
        $phoneNumberError = "Invalid phone number";
    else {
        $phoneNumberError = "";
        $phoneNumber = testInput($_POST['phoneNumber']);
        }
    
        
    //If errors are clear, send data to the database
    if ($emailError == "" & $passwordError == "" & $firstNameError == "" & $lastNameError == "" & $eidError == "" & $phoneNumberError == "") {
        date_default_timezone_set("America/Detroit");
        $timeStamp = date("Y-m-d H:i:s");
        $sql = "INSERT INTO users (EID, email, Password, FirstName, LastName, PhoneNumber, DateTimeCreated) 
        VALUES ('".$eid."', '".$email."', '".$password."', '".$firstName."', '".$lastName."', '".$phoneNumber."', '".$timeStamp."')";
        $con->query($sql);
        header('Location: login.php');
    } else {
        if ($emailError != "")
            $errorMessage .= $emailError . "<br>";
        if ($passwordError != "")
            $errorMessage .= $passwordError . "<br>";
        if ($firstNameError != "")
            $errorMessage .= $firstNameError . "<br>";
        if ($lastNameError != "")
            $errorMessage .= $lastNameError . "<br>";
        if ($eidError != "")
            $errorMessage .= $eidError . "<br>";
        if ($phoneNumberError != "")
            $errorMessage .= $phoneNumberError;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Welcome to SEEUS</title>
<link rel="stylesheet" type="text/css" href="css/content.css">

</head>
<body>
<div id="pageTitle">Register</div>
<div id="focusDiv">
    <div id="errorDivContainer">
        <div id="errorDiv"><?php echo $errorMessage; ?></div>
    </div>
	<form method = "post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		&nbsp&nbsp<input type="text" name="email" placeholder="Email" value="<?php if (isset($_POST['email'])) echo $_POST['email'];?>"><span class=error>*</span>
		<br> 
		&nbsp&nbsp<input type="password" name="password" placeholder="Password" value="<?php if (isset($_POST['password'])) echo $_POST['password']?>"><span class=error>*</span>
		<br>
		&nbsp&nbsp<input type="password" name="passwordConfirm" placeholder="Confirm Password" value="<?php if (isset($_POST['passwordConfirm'])) echo $_POST['passwordConfirm']?>"><span class=error>*</span>
		<br>
		&nbsp&nbsp<input type="text" name="firstName" placeholder="First Name" value="<?php if (isset($_POST['firstName'])) echo $_POST['firstName']?>"><span class=error>*</span>
		<br>
		&nbsp&nbsp<input type="text" name="lastName" placeholder="Last Name" value="<?php if (isset($_POST['lastName'])) echo $_POST['lastName']?>"><span class=error>*</span>
		<br>
		&nbspE<input type="text" name="eid" placeholder="EID" value="<?php if (isset($_POST['eid'])) echo $_POST['eid']?>"><span class=error>*</span>
		<br>
		&nbsp&nbsp<input type="text" name="phoneNumber" placeholder="Phone Number" value="<?php if (isset($_POST['phoneNumber'])) echo $_POST['phoneNumber']?>">&nbsp
		<br>
		<input type="submit" onClick="parent.changeMenu();" value="Register">
	</form>
    <div id="errorDiv">
    </div>
</div> 
</body>
</html>