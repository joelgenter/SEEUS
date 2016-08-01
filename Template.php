<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/template.css">
</style>
</head>
<body onblur="pauseVideo()" onfocus="playVideo()">
<div id="videoContainer"> 
    <video id="video" preload autoplay loop>
        <source src="compressed_shorter_video.mp4" type="video/mp4">
    </video>
</div>

<div id="centerPane">
    <div id="leftPane">
        <img id="seeusLogo" src="seeus_logo_transparent.png">
        <div id="menu">
            <?php //include 'menu.php'?> 
            <ul> 
                <li><a href = \"http://seeus.xp3.biz\">Home</a></li>
                <li><a href = \"http://seeus.xp3.biz/escorts/request.php\">Request Escort</a></li>
                <li><a href = \"http://seeus.xp3.biz/escorts/user.php\">My Escorts</a></li>
                <li><a href = \"http://seeus.xp3.biz/settings.php\">Settings</a></li>
                <li><a href = \"http://seeus.xp3.biz/logout.php\">Logout</a></li>    
            </ul>
        </div>
    </div>
    <div id="rightPane">
        <div id="pageTitle">Register</div>
        <div id="mainContainer">
            <div id="focusDiv">
                <form method = "post"">
                    &nbsp<input type="text" name="email" placeholder="Email" ><span class=error>*</span><br>
                    &nbsp<input type="password" placeholder="Password" name="password"><span class=error>*</span><br>
                    &nbsp<input type="password" placeholder="Confirm Password" name="passwordConfirm" ><span class=error>*</span><br>
                    &nbsp<input type="text" placeholder="First Name" name="firstName"><span class=error>*</span><br>
                    &nbsp<input type="text" placeholder="Last Name" name="lastName"><span class=error>*</span><br>
                    E<input type="text" placeholder="EID" name="eid"><span class=error>*</span><br>
                    &nbsp<input type="text" placeholder="Phone Number" name="phoneNumber"><span class=error>*</span><br>
                    <input type="submit" value="Register">
                </form>
            </div>
    </div>
    </div>
        <div id="rightBorder"></div>
</div>

<script>
    var video = document.getElementById("video");
    function pauseVideo() {
        video.pause();
    }
    function playVideo() {
        video.play();
    }
    
</script>

</body>
</html>
