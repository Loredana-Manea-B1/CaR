<?php
session_start();
$_SESSION = array();
session_destroy();
header("location: ../pages-html/login.php");
exit;
?>