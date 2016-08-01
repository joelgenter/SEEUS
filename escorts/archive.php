<?php  
    require '../database/connection.php';
    session_start();
    /*if (!isset($_SESSION['eid'])) {
        header('Location: ../index.php');
    } else if ($_SESSION['eid'] > 2) {
        header('Location: ../index.php');
    }*/
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/content.css">
<script>
    parent.iframeMenu.contentWindow.changeMenu(
        "<?php 
            if (isset($_SESSION['eid']))
                echo $_SESSION['eid'];
        ?>");
</script>
</head>
<body>
<div id="pageTitle">Current Escort Requests</div>
<div id="focusDiv">
	<?php
        $result = $con->query("SELECT escorts.DateTimeSubmitted, users.EID, 
            users.FirstName, users.LastName, escorts.NumberInParty, 
            escorts.Location, escorts.Destination, escorts.Comments, 
            escorts.PhoneNumber, escorts.ID, escorts.Status, escorts.DateTimeChanged 
            FROM escorts INNER JOIN users ON escorts.EID=users.EID 
            WHERE Status > 1 ORDER BY escorts.DateTimeSubmitted DESC LIMIT 4");
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
                if ($row['Status'] == 2) {
                    $status = 'Dispatched';
                } elseif ($row['Status'] == 3) {
                    $status = 'Canceled by Dispatccher';
                } else {
                    $status = 'Canceled by User';
                }
                echo " <tr> <td> " . $row['DateTimeSubmitted'] . "</td> 
                            <td> " . $row['Location'] . "</td>
                            <td> " . $row['Destination'] . "</td>
                            <td> " . $row['FirstName'] . "</td>
                            <td> " . $row['LastName'] . "</td>
                            <td> " . $row['EID'] . "</td>
                            <td> " . $row['NumberInParty'] . "</td>
                            <td> " . $row['PhoneNumber'] . "</td>
                            <td> " . $row['Comments'] . "</td>
                            <td> " . $status . " at " . $row['DateTimeChanged'] . "</td> </tr>";
            };
        } else {
            echo "No escorts"; 
        }
    ?>
</div> 
<script>
   setTimeout(reloadPage, 15000);
   function reloadPage() {
        location.reload(true);
    }
</script>
</body>
</html>
