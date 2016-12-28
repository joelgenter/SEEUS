<?php
session_start();
require_once 'Class_Autoloader.php';
Utility::connectDB();
echo Utility::killswitchIsActive();