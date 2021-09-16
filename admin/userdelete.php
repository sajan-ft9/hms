<?php 
require_once "../includes/init.php";
checkLogin();
if($_SESSION['role'] === 'admin'){
    if($_GET['senduser'] === 'delstaff'){
        $username = $_GET['name'];
        $admin = new Admin();
        if($_SESSION['logged'] === $username){
            header("location:index.php");
            die;
        }
        $admin->delete($username);
        header("location:userslist.php");

    }else{
        header("location:userslist.php");
    }
    
}else{
    header("location:rooms.php?adminerr");
    die;
}
