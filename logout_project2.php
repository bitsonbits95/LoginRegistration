<?php
session_start();
$_SESSION = array();
session_destroy();
header("location: login_project2.php");
exit;
?>