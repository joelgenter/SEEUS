<!doctype html>
<html>
<head>
<style>
    ul {
        position: absolute;
        bottom: 0;
        list-style-type: none;
        margin: 0;
        padding: 0;
        font-size: 20px;
        font-weight: 900;        
        font-family: monospace;
        width: 100%;
    }
    li a {
        display: block;
        color: black; 
        padding: 8px 0 8px 16px;
        text-decoration: none;
    }
    li a.active {
        background-color: #4CAF50;
        color: white;
    }
    li a:hover:not(.active) {
        background-color: black;
        color: white;
        opacity: 1;
    }
</style>
</head>
<body>
<div id="containerDiv"></div>
<script>
    var containerDiv = document.getElementById("containerDiv");
    function changeMenu(eid) {
        eid = parseInt(eid);
        if (isNaN(eid)) {
            containerDiv.innerHTML =
                "<ul>" + 
                    "<li><a href=\"#\" onclick=\"menuHome();\">Home</a></li>" + 
                    "<li><a href=\"#\" onclick=\"menuLogin();\">Login</a></li>" + 
                    "<li><a href=\"#\" onclick=\"menuRegister();\">Register</a></li>" + 
                "</ul>";
                parent.currentMenu = "guest";
        } else if (eid <= 2) { //supervisor or dispatcher
            containerDiv.innerHTML =
                "<ul>" +
                    "<li><a href=\"#\" onclick=\"menuHome();\">Home</a></li>" +
                    "<li><a href=\"#\" onclick=\"menuDispatch();\">Dispatch</a></li>" +
                    "<li><a href=\"#\" onclick=\"menuArchive();\">Archive</a></li>" +
                    "<li><a href=\"#\" onclick=\"logout();\">Logout</a></li>" +
                "</ul>";
                parent.currentMenu = "authoritarian";
        } else {
            containerDiv.innerHTML =
                "<ul>" +
                    "<li><a href=\"#\" onclick=\"menuHome();\">Home</a></li>" +
                    "<li><a href=\"#\" onclick=\"menuRequestEscort();\">Request Escort</a></li>" +
                    "<li><a href=\"#\" onclick=\"menuMyEscorts();\">My Escorts</a></li>" +
                    "<li><a href=\"#\" onclick=\"menuSettings();\">Settings</a></li>" +
                    "<li><a href=\"#\" onclick=\"logout();\">Logout</a></li>" +
                "</ul>";
                parent.currentMenu = "user";
        }
        
    }
</script>
<?php
    // if (!isset($_SESSION['eid'])) {
    //     echo "<ul> 
    //         <li><a href=\"#\" onclick=\"menuHome();\">Home</a></li>
    //         <li><a href=\"#\" onclick=\"menuLogin();\">Login</a></li>
    //         <li><a href=\"#\" onclick=\"menuRegister();\">Register</a></li>
    //         </ul>";
    // } else if ($_SESSION['eid'] <= 2) { //supervisor eid is 1 and dispatcher eid is 2
    //     echo "<ul> 
    //         <li><a href=\"#\" onclick=\"menuHome();\">Home</a></li>
    //         <li><a href=\"#\" onclick=\"menuDispatch();\">Dispatch</a></li>
    //         <li><a href=\"#\" onclick=\"menuArchive();\">Archive</a></li>
    //         <li><a href=\"#\" onclick=\"menuLogout();\">Logout</a></li>
    //         </ul>";
    // } else { 
    //     echo "<ul> 
    //         <li><a href=\"#\" onclick=\"menuHome();\">Home</a></li>
    //         <li><a href=\"#\" onclick=\"menuRequestEscort();\">Request Escort</a></li>
    //         <li><a href=\"#\" onclick=\"menuMyEscorts();\">My Escorts</a></li>
    //         <li><a href=\"#\" onclick=\"menuSettings();\">Settings</a></li>
    //         <li><a href=\"#\" onclick=\"menuLogout();\">Logout</a></li>    
    //         </ul>";
    // }
?>
<script>
    //The following allows the menu to control the page content('iframeContent')
    iframeContent = parent.iframeContent;
    iframeMenu = parent.iframeMenu;
    function menuHome() {
        iframeContent.src = "http://localhost/seeus/iframe/index.php";
    }
    function menuLogin() {
        iframeContent.src = "http://localhost/seeus/iframe/login.php";
    }
    function menuRegister() {
        iframeContent.src = "http://localhost/seeus/iframe/register.php";
    }
    function menuDispatch() {
        iframeContent.src = "http://localhost/seeus/iframe/escorts/dispatch.php";
    }
    function menuArchive() {
        iframeContent.src = "http://localhost/seeus/iframe/escorts/archive.php";
    }
    function menuRequestEscort() {
        iframeContent.src = "http://localhost/seeus/iframe/escorts/request.php";
    }
    function menuMyEscorts() {
        iframeContent.src = "http://localhost/seeus/iframe/escorts/user.php";
    }
    function menuSettings() {
        iframeContent.src = "http://localhost/seeus/iframe/settings.php";
    }
    
    //!!!!!!Check to see if GET would be faster!!!!!!
    function logout() {
        var serverRequest = new XMLHttpRequest();
        serverRequest.open("POST", "ajax/logout.php", true);
        serverRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        serverRequest.onreadystatechange = function() {
                if (serverRequest.readyState == 4) {
                    iframeContent.src = "http://localhost/seeus/iframe/index.php";
                }
        }
        serverRequest.send("");
    }
</script>
</body>
</html>