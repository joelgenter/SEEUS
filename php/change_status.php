<?php
    require '../database/connection.php';
    date_default_timezone_set("America/Detroit");
    $timeStamp = date("Y-m-d H:i:s");
    $sql = "UPDATE escorts SET Status = " . $_POST['newStatus'] . ", DateTimeChanged = \"" . $timeStamp . "\" WHERE ID = " . $_POST['id']; 
    $con->query($sql);
?>