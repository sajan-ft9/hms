<?php 
require_once "../includes/init.php";

$rooms = new Rooms();

if ($_GET['send'] === 'del') {
    
    $id = $_GET['id'];
    $rooms->delete($id);

    header("location:index.php");
    die;
}    
else{
    header("location:index.php");
    die;
}