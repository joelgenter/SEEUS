<?php
    if (!isset($_SESSION['eid'])) 
        echo 'guest but it worked';
    elseif ($_SESSION['eid'] == 1 | $_SESSION['eid'] == 2) 
        echo 'authoritarian';
    else
        echo 'user';