<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/system/db.php');
    @session_start();
    if ($link and isset($_SESSION['userkey'])){
        $userkey = $_SESSION['userkey'];
        $rez = mysqli_query($link, "SELECT `usertype`, `name` FROM `users` WHERE `userkey`='$userkey'");
        if ($rez){
            $rez = mysqli_fetch_array($rez);
            $_SESSION['usertype'] = $rez['usertype'];
            $_SESSION['name'] = $rez['name'];
        }
    }
?>