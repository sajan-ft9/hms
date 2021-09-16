<?php 
require_once "../includes/init.php";
session_start();
checkLogin();
if($_SESSION['role'] === 'admin'){

    $rooms = new Rooms();

    if ($_GET['send'] === 'del') {
        
        $id = $_GET['id'];
        $img_del = $_GET['name'];
        $rooms->delete($id);

        unlink("uploads/$img_del");

        header("location:rooms.php");
        die;
    }    
    else{
        header("location:rooms.php?senderr");
        die;
    }
}else{
    header("location:rooms.php?adminerr");
    die;
}