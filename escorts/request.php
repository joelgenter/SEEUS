<?php
    session_start();
require '../database/connection.php';
// if (!isset($_SESSION['eid'])) {
//     header('Location: ../index.php');
// } else if ($_SESSION['eid'] <= 2) {
//     header('Location: ../index.php');
// }
$eidError = $numInPartyError = $commentsError = $locationError = $destinationError = $phoneNumberError = $errorMessage = "";
function testInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //Error checking to validate data entered by user

    //Number in Party error check 
    if ($_POST['numberInParty'] > 3 | $_POST['numberInParty']< 1)
        $numInPartyError = "Invalid party size (must be 1 to 3 people)";
    else {
        $numInPartyError = "";
        $numInParty = testInput($_POST['numberInParty']);
    }
    
    //Location error check 
    if (strlen($_POST['location']) < 1)
        $locationError = "Please enter your current location";
    else {
        $locationError = "";
        $location = testInput($_POST['location']);
    }
        
    //Destination error check 
    if (strlen($_POST['destination']) < 1)
        $destinationError = "Please enter where you want to go";
    else {
        $destinationError = "";
        $destination = testInput($_POST['destination']);
    }
        
    //Comments error check 
        $commentsError = "";
        $comments = testInput($_POST['comments']);
    
    //Phone number error check
    if (empty($_POST['phoneNumber']))
        $phoneNumberError = "A phone number is required";
    else if (!is_numeric($_POST['phoneNumber']) | strlen($_POST['phoneNumber']) != 10)
        $phoneNumberError = "Invalid phone number";
    else {
        $phoneNumberError = "";
        $phoneNumber = testInput($_POST['phoneNumber']);
        }
    //$eidError == "" & 
    //If errors are clear, send data to the database
    if ($commentsError == "" & $numInPartyError == "" & $locationError == "" & $destinationError == "" & $phoneNumberError == "" ) {
        date_default_timezone_set("America/Detroit");
        $timeStamp = date("Y-m-d H:i:s");
        $sql = "INSERT INTO escorts (DateTimeSubmitted, EID, NumberInParty, Location, Destination, Comments, PhoneNumber) 
        VALUES ('".$timeStamp."', '".$_SESSION['eid']."', '".$numInParty."', '".$location."', '".$destination."', '".$comments."', '".$phoneNumber."')";
        //$sql = "INSERT INTO escorts (EID, FirstName, LastName, NumberInParty, Location, Destination, Comments, PhoneNumber, DateTimeSubmitted) 
        //VALUES ('$_POST[eid]', '$_POST[firstName]', '$_POST[lastName]', '$_POST[numberInParty]', '$_POST[location]', '$_POST[destination]', '$_POST[comments]', '$_POST[phoneNumber]', '$timeStamp')";
        $con->query($sql);
        header('Location: user.php');
    } else {
        if ($numInPartyError != "")
            $errorMessage .= $numInPartyError . "<br>";
        if ($locationError != "")
            $errorMessage .= $locationError . "<br>";
        if ($destinationError != "")
            $errorMessage .= $destinationError . "<br>";
        if ($phoneNumberError != "")
            $errorMessage .= $phoneNumberError . "<br>";
    }

}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/content.css">
</head>
<body>
<div id="pageTitle">Request an Escort</div>
<div id="focusDiv">
    <div id="errorDivContainer">
        <div id="errorDiv"><?php echo $errorMessage; ?></div>
    </div>
	<form method = "post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		&nbsp&nbsp<input type="text" name="numberInParty" placeholder="Number in Party" value="<?php if (isset($_POST['numberInParty'])) echo $_POST['numberInParty']?>"><span class=error>*</span>
		<br>
		&nbsp&nbsp<input type="text" name="location" placeholder="Location" maxlength="25" value="<?php if (isset($_POST['location'])) echo $_POST['location']?>"><span class=error>*</span>
		<br>
		&nbsp&nbsp<input type="text" name="destination" placeholder="Destination" maxlength="25" value="<?php if (isset($_POST['destination'])) echo $_POST['destination']?>"><span class=error>*</span>
		<br>
		&nbsp&nbsp<input type="text" name="comments" maxlength="100" placeholder="Comments" value="<?php if (isset($_POST['comments'])) echo $_POST['comments']?>">&nbsp
		<br>
		&nbsp&nbsp<input type="text" name="phoneNumber" placeholder="Phone Number" maxlength="10" value="<?php if (isset($_POST['phoneNumber'])) echo $_POST['phoneNumber']?>"><span class=error>*</span>
		<br>
		<input type="submit" name="submit" value="Submit">
	</form>
</div>
</body>
</html>