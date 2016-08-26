<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/template.css">
<script src="jquery/jquery-3.1.0.min.js"></script>
<script src="js/general_js_functions.js"></script>
<script src="js/navigation.js"></script>
</head>
<body onblur="pauseVideo()" onfocus="playVideo()">
<div id="videoContainer"> 
    <video id="video" preload autoplay loop>
        <source src="media/compressed_shorter_video.mp4" type="video/mp4">
    </video>
</div>
<div id="centerPane">
    <div id="leftPane">
        <img id="seeusLogo" src="media/seeus_logo_transparent.png">
        <div id="menuContainer"></div>
    </div>
    <div id="contentContainer"></div>
    <div id="rightBorder"></div> <!--I should check to see if I can just add a border to the right side of '#centerPane'-->
</div>

<?php
    if (!isset($_SESSION['eid'])) 
        $userType = 'guest';
    elseif ($_SESSION['eid'] == 1 | $_SESSION['eid'] == 2) 
        $userType = 'authoritarian';
    else
        $userType = 'user';
?>

<script>  
    var userType = <?php echo "'" . $userType . "'" ?>;
    var $menuContainer = $('#menuContainer');
    var $contentContainer = $('#contentContainer');
    
    changeMenu($menuContainer, navigation, userType, $contentContainer);
    changeContent($contentContainer, navigation, 'home');

    // In <body> there's a pointer to these functions
    // var video = document.getElementById("video");
    // function pauseVideo() {
    //     video.pause();
    // }
    // function playVideo() {
    //     video.play();
    // }
</script>
</body>
</html>