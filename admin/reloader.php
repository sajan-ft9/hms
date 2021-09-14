<?php
require_once "../helpers/funtions.php";
$check = checkLogin();
if(isset($_GET['loc'])){
    $loc = $_GET['loc'];
    header("location:$loc");
    die;
}else{
    die;
}