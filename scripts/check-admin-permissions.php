<?php
    @session_start();
    if (!isset($_SESSION['usertype']) or $_SESSION['usertype'] != 2){
        header("Location:http://" . $_SERVER['HTTP_HOST'] . "/login.php");
    }
?>