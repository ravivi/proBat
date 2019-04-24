<?php session_start();
$_SESSION=array();
session_destroy();
// header('location :../index.php');
header("Location: workers.php");



?>