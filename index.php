
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/template.css">
<script src="jquery/jquery-3.1.0.min.js"></script>
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
<!---------------------------------Javascript--------------------------------->
<script>  
    var iframeMenu = document.getElementById('iframeMenu');
    var iframeContent = document.getElementById('iframeContent');
    //In <body> there's a pointer to these functions
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
