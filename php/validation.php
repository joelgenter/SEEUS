<?php

function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validate($datum, $criteria, $con) {
    $returnData['errorMessage'] = '';
    foreach ($criteria as $criterion => $criterionDetails) {
        switch ($criteria[$criterion]) {
            case 'emailRegistered':
                $sql = 'SELECT "" FROM users WHERE Email = "' . $datum . '"';
                $result = $con->query($sql);
                if ($result->num_rows == 0) {
                    $returnData['isRegistered'] = false;
                    $returnData['errorMessage'] .= 'Email not registered<br>';
                } else 
                    $returnData['isRegistered'] = true;                    
                break;

            case 'emailVerified':
                $sql = 'SELECT "" FROM users WHERE Email = "' . $datum . '" AND Verified = true;';
                $result = $con->query($sql);
                if ($result->num_rows == 0) {
                    $returnData['isVerified'] = false;
                } else 
                    $returnData['isVerified'] = true;                    
                break;
            default:
                $returnData['errorMessage'] .= 'An error occurred<br>';
        }
    }
    return $returnData;
}