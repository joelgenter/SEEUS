<?php  
    require '../database/connection.php';
    session_start();
    if (!isset($_SESSION['eid'])) {
        header('Location: ../index.php');
    } else if ($_SESSION['eid'] <= 2) {
        header('Location: ../index.php');
    }
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/content.css">
</head>
<body>
<div id="pageTitle">Your Escorts</div>  
<div id="focusDiv">    
    <?php
    $result = $con->query("SELECT escorts.DateTimeSubmitted, users.EID, 
        users.FirstName, users.LastName, escorts.NumberInParty, 
        escorts.Location, escorts.Destination, escorts.Comments, 
        escorts.PhoneNumber, escorts.ID, escorts.Status, escorts.DateTimeChanged 
        FROM escorts INNER JOIN users ON escorts.EID=users.EID 
        WHERE escorts.EID = \"" . $_SESSION['eid'] . "\" 
        ORDER BY escorts.DateTimeSubmitted DESC LIMIT 3");
    if ($result->num_rows > 0) {     
        echo "<table width=\"60%\" border=\"1px\">
                <tr>
                    <th>Time Requested</th>
                    <th>Location</th>
                    <th>Destination</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>EID</th>
                    <th>Number in Party</th>
                    <th>Phone Number</th>
                    <th>Comments</th>
                    <th>Status</th>
                </tr> ";
            while ($row = mysqli_fetch_assoc($result)) {
                $statusCheck = $row['Status'];
                if ($statusCheck <= 1)
                    $status = "Not yet dispatched <br> <button onClick=\"changeStatus(" . $row['ID'] . ", 4)\">Cancel</button>";
                elseif ($statusCheck == 2) 
                    $status = "Dispatched at " . $row['DateTimeChanged'];
                elseif ($statusCheck == 3) 
                    $status = "Canceled by Dispatcher at " . $row['DateTimeChanged'];
                else 
                    $status = "Canceled by " . $_SESSION['firstName'] . " at " . $row['DateTimeChanged'];
                
                echo " <tr> <td> " . $row['DateTimeSubmitted'] . "</td> 
                            <td> " . $row['Location'] . "</td>
                            <td> " . $row['Destination'] . "</td>
                            <td> " . $row['FirstName'] . "</td>
                            <td> " . $row['LastName'] . "</td>
                            <td> " . $row['EID'] . "</td>
                            <td> " . $row['NumberInParty'] . "</td>
                            <td> " . $row['PhoneNumber'] . "</td>
                            <td> " . $row['Comments'] . "</td>
                            <td> " . $status . "</td></tr>";
            };
    } else {
        echo "No escorts"; 
    }
    ?>
</div>

<script>
   setTimeout(reloadPage, 3000);
   function reloadPage() {
        location.reload(true);
    }
    
    function changeStatus(id, newStatus) {
        var information = "id=" + id + "&newStatus=" + newStatus;
        var serverRequest = new XMLHttpRequest();
        serverRequest.open("POST", "../ajax/change_status.php", true);
        serverRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        
        serverRequest.onreadystatechange = function() {
                if (serverRequest.readyState == 4) {
                    reloadPage();
                }
                
        }
        serverRequest.send(information);
    }
</script>

</body>
</html>
