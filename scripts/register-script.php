<?php

@session_start();
include( $_SERVER['DOCUMENT_ROOT'] . '/system/db.php' );
include( $_SERVER['DOCUMENT_ROOT'] . '/scripts/error-script.php' );
include( "break-script.php" );
require_once "common-functions.php";


$arr                = array();
$arr['error']       = false;
$arr['texterror']   = false;

$min = 4;
$max = 255;

//ФИО
$name = mysqli_real_escape_string(
    $link,
    validateString($_GET['name'], $min, $max, "Неверно введено ФИО.")
);

//Область/край
$region = mysqli_real_escape_string(
    $link,
    validateString($_GET['region'], 0, $max, "Неверно введена область.")
);

//Город
$city = mysqli_real_escape_string(
    $link,
    validateString($_GET['city'], 0, $max, "Неверно введен город.")
);

//Школа
$school = mysqli_real_escape_string(
    $link,
    validateString($_GET['school'], $min, $max, "Неверно введено название школы.")
);

//Учителя
$teachers = mysqli_real_escape_string(
    $link,
    validateInt($_GET['teachers'], 0, 999999, "Неверное количество учителей.")
);

//Участники
$participants = mysqli_real_escape_string(
    $link,
    validateInt($_GET['participants'], 0, 999999, "Неверное количество участников.")
);

//Почта
$post           = 0;
$postcode       = "";
$postaddress    = "";
$postname       = "";
if (isset($_GET['post'])) {
    $post = 1;
    $postcode = mysqli_real_escape_string(
        $link,
        validateString($_GET['postcode'], 0, $max, "Неверно введен почтовый индекс.")
    );
    $postaddress = mysqli_real_escape_string(
        $link,
        validateString($_GET['postaddress'], 0, $max, "Неверно введен почтовый адрес.")
    );
    $postname = mysqli_real_escape_string(
        $link,
        validateString($_GET['postname'], 0, $max, "Неверно введено имя получателя.")
    );
}

//Номера классов
$classes = "{}";
if ( isset( $_GET[ 'competitions' ] ) ) {
    $classes = mysqli_real_escape_string($link, $_GET['competitions']);
}

//Телефон
$phone = mysqli_real_escape_string(
    $link,
    validateString($_GET['phone'], $min, $max, "Неверно введен номер телефона.")
);

//Пароль
$password = hash(
    'sha512',
    validateString($_GET['password'], $min, $max, "Неверно введен пароль.")
);

//E-mail
$email = mysqli_real_escape_string(
    $link,
    validateString($_GET['email'], $min, $max, "Неверно введен номер Email.")
);

if ($arr['error'] == false){
    $userkey = hash('sha512', date('Y-m-d H:i:s').$name);
    $rez = mysqli_query($link, "SELECT COUNT(*) FROM `users` WHERE `email`='$email'");
    if (!$rez){
        $arr['error'] = true;
        log::e(mysqli_error($link));
    }
    else{
        $rez = mysqli_fetch_array($rez);
        if ($rez['COUNT(*)'] > 0){
            $arr['error'] = true;
            $arr['texterror'] = "Пользователь с таким E-mail уже зарегистрирован!";
        }
        else{
            $request = "INSERT INTO `users`(`userkey`,`name`,`region`,`city`,`school`,`post`,`postaddress`,`postcode`,`postname`,`participants`,`teachers`,`classes`,`email`,`phone`,`password`) VALUES('$userkey','$name','$region','$city','$school',$post,'$postaddress','$postcode','$postname',$participants,$teachers,'$classes','$email','$phone','$password');";
            $rez = mysqli_query($link, $request);
            if (!$rez){
                log::e(mysqli_error($link));
                $arr['error'] = true;
            }
            if (!$arr['error']){
                $_SESSION['userkey'] = $userkey;
                $_SESSION['usertype'] = '0';
                $_SESSION['name'] = $name;
            }
        }
    }
    echo json_encode($arr);
}
else{
    echo json_encode($arr);
}

function validateString($value, $minLen = 0, $maxLen = 100, $ifNot = "") {
    if ( !isset($value)
        or strlen($value) < $minLen
        or strlen($value) > $maxLen) {
        break_script($ifNot);
    }
    return $value;
}

function validateInt($val, $min = 0, $max = 999999, $ifNot = "") {
    if ( strlen($val) == 0 ) {
        $val = '0';
    }
    if ( !isset($val)
        or !is_numeric($val)
        or $min > (int) $val
        or $max < (int) $val ) {
        break_script($ifNot);
    }
    return (int) $val;
}