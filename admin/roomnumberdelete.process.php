<?php 
require_once "../includes/init.php";

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