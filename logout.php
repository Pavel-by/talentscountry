<?php
    @session_start();
    unset($_SESSION['userkey']);
    unset($_SESSION['usertype']);
    session_destroy();
    header('Location:login.php');
?>