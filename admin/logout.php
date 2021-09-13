<?php 
session_start();

if(isset($_SESSION['logged']) && $_SESSION['role']) {
    session_destroy();
    header("location:../adminlogin/hms-admin.php");
    die;
}