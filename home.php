<?php  
    require '/database/connection.php';
    session_start();
    $escortsRemaining = -1; //If it's -1, then the user isn't logged in
    if (isset($_SESSION['eid'])) 
        $escortsRemaining = $con->query("SELECT Status FROM escorts WHERE Status < 2")->num_rows;
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/content.css">
    <script>
        // parent.iframeMenu.contentWindow.changeMenu(
        //     "<?php 
        //         if (isset($_SESSION['eid']))
        //             echo $_SESSION['eid'];
        //     ?>");
            
        var pageContent = "";
        var escortsRemaining = <?php echo $escortsRemaining ?>;
        if (escortsRemaining == -1)
            pageContent = 
                "<div id=\"subMenuDiv\">" + 
                    "<button onclick=\"location.href='login.php'\" class=\"homeButton\">Login</button>" +
                    "<button onclick=\"location.href='register.php'\" class=\"homeButton\">Register</button>" +
                "</div>";
        else 
            pageContent = 
                ""
        
    </script>
</head>
<body>
<div id="pageTitle">Home</div>
<div id="focusDiv">
    Welcome to SEEUS 
    <div id="subMenuDiv">
        <script> //document.write(pageContent); </script>
        
        <button onclick="location.href='escorts/request.php'" class="homeButton">Request Escort</button>
        <button onclick="location.href='escorts/user.php'" class="homeButton">My Escorts</button>
    </div>
    
    
    <?php 
        // if (!isset($_SESSION['eid'])) {
        //     echo "<p>Welcome guest</p>";
        // }
        // elseif ($_SESSION['eid'] == 1 | $_SESSION['eid'] == 2) {
        //     echo "Welcome supervisor";
        // }
        // else {
        //     echo "Welcome user";
        // }
    ?>

</div> <!--focusDiv-->
</body>
</html>

<!--TO DO LIST

Restrict how many escorts they can request
Restrict requesting escorts when offline
Email validation
-->
    