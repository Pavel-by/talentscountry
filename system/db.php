<?php
    $host = 'localhost';
	$user = 'root';
	$password_link = '';
	$db_name = 'accountantandscolar';
    $link = mysqli_connect($host, $user, $password_link, $db_name);
    if ($link){
        mysqli_query($link, "SET NAMES 'utf8';");
        mysqli_query($link, "SET CHARACTER SET 'utf8';");
    }
?>