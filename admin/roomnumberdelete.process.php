<?php 
require_once "../includes/init.php";
checkLogin();
session_start();
if($_SESSION['role'] === 'admin'){
$roomNumber = new RoomNumber();

if ($_GET['send'] === 'del') {
    
    $roomnumber = $_GET['id'];
    $roomNumber->delete($roomnumber);


    header("location:roomnumber.php");
    die;
}    
else{
    header("location:roomnumber.php");
    die;
}
}else{
    header("location:roomnumber.php");
    die;
}