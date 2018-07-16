<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/system/db.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/scripts/error-script.php');
    if ($link){
        $arr = array();
        $arr['error'] = false;
        $email = mysqli_real_escape_string($link, $_GET['email']);
        $date = date("Y-m-d H:i:s");
        if (isset($_GET['type'])){
            $type = $_GET['type'];
            switch ($type){
                case 'subscribe':
                    $rez = mysqli_query($link, "INSERT IGNORE INTO subscribed(`email`, `date`) VALUES('$email', '$date')");
                    
                    if (!$rez){
                        log::e(mysqli_error($link));   
                        $arr['error'] = true;
                    }
                    break;
                case 'unsubscribe':
                    $rez = mysqli_query($link, "INSERT IGNORE INTO unsubscribed(`email`, `date`) VALUES('$email', '$date')");
                    
                    if (!$rez){
                        log::e(mysqli_error($link));   
                        $arr['error'] = true;
                    }
                    break;
                default:
                    $arr['error'] = true;
                    log::e("subscribe-script.php: тип имеет некорректное значение");
            }
        }
        else{
            $arr['error'] = true;
            log::e("subscribe-script.php: Не задан тип");
        }
        echo json_encode($arr);
    }
    else{
        $arr = array();
        $arr['error'] = true;
        echo json_encode($arr);
        log::e("subscribe-script.php: отсутствие подключения к базе");
    }
?>