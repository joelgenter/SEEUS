<?php 
    require 'database/connection.php';
    /*if (isset($_SESSION['eid'])) {
        header('Location: ../index.php');
    }*/
    $persona = "";
    $loginError = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $result = $con->query("select Email, Password, EID, FirstName, LastName, PhoneNumber from users where Email = '".$_POST['email']."' LIMIT 1");
        $row = mysqli_fetch_assoc($result);
        if ($result->num_rows == 0 | $_POST['password'] != $row['Password'])
            $loginError = "Incorrect email and/or password";
        else {
            session_start();
            $_SESSION['eid'] = $row['EID'];
            $_SESSION['firstName'] = $row['FirstName'];
            $_SESSION['lastName'] = $row['LastName'];
            $_SESSION['phoneNumber'] = $row['PhoneNumber'];
            $_SESSION['email'] = $row['Email'];
            $_SESSION['password'] = $row['Password'];
            header('Location: index.php');
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
<div id="pageTitle">Login</div>
<div id="focusDiv">
    <div id="errorDivContainer">
        <div id="errorDiv"><?php echo $loginError; ?></div>
    </div>
	<form method = "post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		&nbsp<input type="text" name="email" placeholder="Email" value="<?php if (isset($_POST['email'])) echo $_POST['email'];?>">
		<br>
		&nbsp<input type="password" name="password" placeholder="Password" value="<?php if (isset($_POST['password'])) echo $_POST['password']?>">
		<br>
		<input type="submit"  value="Login">
	</form>
</div> 
</body>
</html>