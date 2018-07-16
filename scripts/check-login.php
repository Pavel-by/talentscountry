<?php
    @session_start();
    include($_SERVER['DOCUMENT_ROOT'] . '/system/db.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/scripts/error-script.php');
    if ($link){
        $arr = array(
            "error" => false,
            "texterror" => false,
            "href" => false
        );
        if (isset($_POST['email'])){
            $email = mysqli_real_escape_string($link, $_POST['email']);
            if (strlen($email) < 1){
                $arr['error'] = true;
                $arr['texterror'] = "Неверный E-mail.";
            }
        }
        else{
            $arr['error'] = true;
            $arr['texterror'] = "Поле E-mail не должно быть пустым.";
        }

        if (isset($_POST['password'])){
            $password = $_POST['password'];
            if (strlen($password) < 4){
                $arr['error'] = true;
                $arr['texterror'] = "Неверный пароль. Минимальная длина пароля 4 символа.";
            }
            else{
                $password = hash('sha512', $password);
            }
        }
        else{
            $arr['error'] = true;
            $arr['texterror'] = "Поле Пароль не должно быть пустым.";
        }

        if ($arr['error'] == false){
            $rez = mysqli_query($link, "SELECT `userkey`, `usertype`, `name` FROM `users` WHERE `email`='$email' and `password`='$password';");
            
            if ($rez and $rez = mysqli_fetch_array($rez)){
                $_SESSION['userkey'] = $rez['userkey'];
                $_SESSION['usertype'] = $rez['usertype'];
                $_SESSION['name'] = $rez['name'];

                if ($_SESSION['usertype'] != 2){
                    $arr['href'] = "http://" . $_SERVER['HTTP_HOST'] . "/user-info.php";
                }
                else {
                    $arr['href'] = "http://" . $_SERVER['HTTP_HOST'] . "/admin-add-permit.php";
                }
            }
            else{
                log::e('SQL: ' . mysqli_error($link));
                $arr['error'] = true;
                $arr['texterror'] = "Неверный логин или пароль.";
            }
        }

        echo json_encode($arr);

    }
    else{
        log::e('SQL: CONNECTION ERROR');
        $arr = array(
            "error" => true,
            "texterror" => "Ошибка при подключении к базе данных. Попробуйте войти позже."
        );
        echo json_encode($arr);
    }
?>