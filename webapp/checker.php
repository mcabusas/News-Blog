<?php
session_start();

if(!(isset($_SESSION['username']))){
    $message = "YOU MUST BE LOGGED IN!";
    echo "<script type='text/javascript'>alert('$message');</script>";
    header("refresh:0.0; url=home.php");
}
?>