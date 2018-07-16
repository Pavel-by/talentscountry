<?php
    session_start();
    include($_SERVER['DOCUMENT_ROOT'] . '/system/db.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/scripts/error-script.php');
    $arr = array(
        'error' => false,
        'texterror' => false
    );

    $type = "";
    if (isset($_GET['type'])){
        switch ($_GET['type']){
            case 'payment':
                $type = "and `type`='payment'";
                break;
            case 'answer':
                $type = "and `type`='answer'";
        }
    }

    if (isset($_SESSION['userkey'])){
        $userkey = $_SESSION['userkey'];
        $arr['files'] = array();
        if ($link){
            $rez = mysqli_query($link, "SELECT * FROM `loaded-files` WHERE `userkey`='$userkey' $type");
            if ($rez){
                while ($fields = mysqli_fetch_array($rez)){
                    $date_time = new DateTime($fields["date"]);
                    $date = $date_time->format('Y-m-d H:i:s');
                    
                    $arr['files'][] = array(
                        'name' => $fields['name'],
                        'date' => $date
                    );
                }
            }
            else{
                $arr['error'] = true;
                $arr['texterror'] = "Ошибка подключения к базе данных.";
                log::e(mysqli_error($link));
            }
        }
        else{
            $arr['error'] = true;
            $arr['texterror'] = "Ошибка подключения к базе данных.";
        }
    } 
    else{
        $arr['error'] = true;
        $arr['texterror'] = "Ошибка авторизации. <a href='login.php'>Войдите</a> в систему";
    }
    echo json_encode($arr);
?>