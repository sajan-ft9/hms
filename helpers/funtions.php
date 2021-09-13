<?php

function clean($value) {
    $value = trim($value);            
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    return $value;
}

function checkLogin() {
    session_start();
    if(isset($_SESSION['logged']) && isset($_SESSION['role'])){
        return;
    }
    else{
        header("Location: ../adminlogin/hms-admin.php?err");
        die;
    }
}