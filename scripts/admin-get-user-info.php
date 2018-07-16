<?php
    @session_start();
    include($_SERVER['DOCUMENT_ROOT'] . '/system/db.php');
    require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/error-script.php';
    $arr = array(
        'error' => false,
        'texterror' => false,
        'data' => false
    );

    if (!isset($_SESSION['usertype']) or $_SESSION['usertype'] != 2){
        $arr['error'] = true;
        $arr['texterror'] = "Недостаточно прав. You have not enough permission.";
        echo json_encode($arr);
        exit();
    }

    if (!isset($_POST['id']) or empty($_POST['id'])){
        $arr['error'] = true;
        $arr['texterror'] = "Некорректные входные данные. Incorrect input data.";
        echo json_encode($arr);
        exit();
    }

    $id = mysqli_real_escape_string($link, $_POST['id']);

    if ($link){
        $rez = mysqli_query($link, "SELECT `id`,`usertype`,`name`,`region`,`city`,`school`,`postcode`,`classes`,`email`,`phone` FROM `users` WHERE `id`=$id");
        if ($rez){
            if ($rez = mysqli_fetch_array($rez)){
                $rez['classes'] = json_decode($rez['classes']);
                $arr['data'] = array(
                    'name' => "",
                    'region' => "",
                    'city' => "",
                    'school' => "",
                    'postcode' => "",
                    'classes' => "",
                    'email' => "",
                    'phone' => ""
                );
                foreach ($rez as $key=>$val){
                    $arr['data'][$key] = $val;
                }
            }
        }
        else {
            $arr['error'] = true;
            $arr['texterror'] = "Ошибка при подключении к базе данных. Error with connect to DataBase.";
            log::e("SQL: " . mysqli_error($link));
        }
    }
    else {
        $arr['error'] = true;
        $arr['texterror'] = "Ошибка при подключении к базе данных. Error with connect to DataBase.";
        log::e("SQL: CONNECTION ERROR");
    }
    echo json_encode($arr);

    function utf8_urldecode($str) {
        $str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;", urldecode($str));
        return html_entity_decode($str,null,'UTF-8');;
    }
?>