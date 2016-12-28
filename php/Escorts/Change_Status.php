<?php
    require '../Class_Autoloader.php';
    Utility::connectDB();
    
    $escortID = Security::cleanInput($_POST['escortID']);
    $newEscortStatusID = Security::cleanInput($_POST['newEscortStatusID']);

    $sql = 
        'UPDATE escorts
        SET StatusID = ' . $newEscortStatusID . ',
            DateTimeChanged = now()
        WHERE ID = ' . $escortID;

    if (Utility::$dbConnection->query($sql))
        echo TRUE;
    else
        echo FALSE;