<?php
session_start();
require_once 'Class_Autoloader.php';
echo Security::getUserType();