<?php
session_start();
$_SESSION['name'] = $_POST['username'];
$_SESSION['password'] = $_POST['password'];
header("location:list.php");
?>