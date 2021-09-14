<?php 
require_once "../helpers/funtions.php";
session_start();
checkLogin();
if(isset($_SESSION['logged']) && $_SESSION['role']) {
    session_destroy();
    header("location:../adminlogin/hms-admin.php");
    die;
}