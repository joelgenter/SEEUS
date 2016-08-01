<?php

//http://maximus.freewha.com/ seeus.xp3.biz
/*$DB_NAME = '1103400';
$DB_HOST = 'localhost';
$DB_USER = '1103400';
$DB_PASS = 'seeusdevelopment';*/

#--Local Database Info--
$DB_NAME = 'seeusdb';
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';

#$DB_NAME = 'a6995183_SEEUS';
#$DB_HOST = 'mysql7.000webhost.com';
#$DB_USER = 'a6995183_Admin';
#$DB_PASS = 'testpass';	
$con = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} 


?>