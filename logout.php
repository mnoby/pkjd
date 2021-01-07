<?php
session_start();

if(isset($_SESSION['Nama'])){
    unset($_SESSION["login"]);
    unset($_SESSION["id"]);
    unset($_SESSION["Username"]);
    unset($_SESSION["Nama"]);
    session_destroy();
    header('location:login.php');
    exit();
    
}else{

    echo "failed";
}

//kembali/redirect ke halaman login.php

?>