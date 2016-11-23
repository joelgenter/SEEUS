<?php
session_start();

$_SESSION['currentuser']->sendVerificationCode();