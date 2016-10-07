<?php
    session_start();
    if (!isset($_SESSION['eid'])) 
        echo 'guest';
    elseif ($_SESSION['eid'] == 1 | $_SESSION['eid'] == 2) 
        echo 'authoritarian';
    else
        echo 'user';