<?php

if ( !defined( "ROOT" ) ) define( "ROOT", $_SERVER[ 'DOCUMENT_ROOT' ] );

@session_start();
include(ROOT . "/system/db.php");
include(ROOT . "/scripts/break-script.php");
include(ROOT . "/system/configuration.php");

if (!isset($_SESSION['userkey'])) {
    break_script("You have not admin privileges");
}

$curUserkey = $_SESSION['userkey'];
if (!($sqlResponse = mysqli_query($link, "SELECT * FROM users WHERE userkey='$curUserkey'"))) {
    break_script("Error while trying get user information");
}

$curUserPermission = intval(mysqli_fetch_array($sqlResponse)['usertype']);
if ($curUserPermission < conf['type.user']) {
    break_script("You have not admin privileges");
}

if (!isset($_REQUEST['email']) or !isset($_REQUEST['password']) or !isset($_REQUEST['name'])) {
    break_script("Not received email or password or name");
}

$name = mysqli_real_escape_string($link, $_REQUEST['name']);
$email = mysqli_real_escape_string($link, $_REQUEST['email']);
$usertype = conf['type.admin'];
$password = $_REQUEST['password'];
$confirmPassword = $_REQUEST['confirmPassword'];
$userkey = hash('sha512', date('Y-m-d H:i:s').$name);

if (strlen($name) == 0) {
    break_script("Поле Имя не должно быть пустым");
}
if (!checkEmail($email)) {
    break_script("Неверно введен Email");
}

if ($password !== $confirmPassword) {
    break_script("Пароли не совпадают");
}

if (strlen($password) < 4) {
    break_script("Минимальная длина пароля 4 символа");
}

$password = hash('sha512', $password);

$count = mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(*) FROM users WHERE email='$email'"))['COUNT(*)'];
if ($count > 0) {
    break_script("Пользователь с таким Email уже зарегистрирован");
}

if (!mysqli_query($link, "INSERT INTO users(`userkey`, `email`, `name`, `password`, `usertype`) VALUES('$userkey', '$email', '$name', '$password', $usertype)")) {
    break_script("Ошибка при добавлении пользователя");
}
end_script("Пользователь был успешно добавлен");

function checkEmail($email) {
    if ( strpos($email, '@') !== false ) {
        $split = explode('@', $email);
        return (strpos($split['1'], '.') !== false ? true : false);
    }
    else {
        return false;
    }
}