
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/template.css">
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
        <iframe id="iframeMenu" src="menu.php" marginwidth="0" 
            marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="no"></iframe>
    </div>
    <iframe id="iframeContent" src="http://localhost/seeus/iframe/escorts/archive.php" 
        marginwidth="0" marginheight="0" hspace="0" vspace="0" frameborder="0" scrolling="no"></iframe>
    <div id="rightBorder"></div>
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
