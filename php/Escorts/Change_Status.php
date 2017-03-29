<?php
    require '../Class_Autoloader.php';
    Utility::connectDB();

    $success = FALSE;
    
    $escortID = Security::cleanInput($_POST['escortID']);
    $newEscortStatusID = Security::cleanInput($_POST['newEscortStatusID']);

    $sql = 
        "UPDATE escorts
        SET StatusID = ?,
        DateTimeChanged = now()
        WHERE ID = ?";

    $stmt = Utility::$dbConnection->prepare($sql);
    if (
        $stmt->bind_param("ii", $newEscortStatusID, $escortID) &&
        $stmt->execute()
    ) {
        $success = TRUE;
    }

    echo $success;