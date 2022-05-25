<?php
session_start();
session_destroy();

header('location:http://192.168.43.221/apkpenggajianguru/login.php');
?>