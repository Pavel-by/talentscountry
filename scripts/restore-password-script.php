<?php
    @session_start();
    include_once($_SERVER['DOCUMENT_ROOT'] . "/system/db.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/scripts/error-script.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/scripts/break-script.php");
    require_once $_SERVER['DOCUMENT_ROOT'] . "/scripts/mail.php";

    $arr = array(
        'error' => false,
        'texterror' => false
    );

    if (isset($_SESSION['restore-userkey']) and isset($_GET['password'])){
        if (!$link){
            break_script("Ошибка подключения к базе данных. Попробуйте позже.");
        }
        $password = hash('sha512', $_GET['password']);
        $userkey = $_SESSION['restore-userkey'];
        $restore_key = $_SESSION['restorekey'];

        $rez = mysqli_query($link, "UPDATE `users` SET `password`='$password' WHERE `userkey`='$userkey'");
        if ($rez){
            unset($_SESSION['restore-userkey']);
            unset($_SESSION['restorekey']);
            @session_destroy();

            mysqli_query($link, "DELETE FROM `restore-password` WHERE `restorekey`='$restore_key'");
            $arr['message'] = "Вы успешно изменили пароль. Теперь Вы можете <a href='/login.php'>войти</a>, используя новый пароль.";
            echo json_encode($arr);
            exit();
        }
        else {
            break_script('Ошибка при попытке изменения пароля');
        }
        
    }

    if (!isset($_GET['email'])){
        break_script("В запросе отсутствует E-mail");
    }

    if ($link){
        $email = mysqli_real_escape_string($link, $_GET['email']);
        $rez = mysqli_query($link, "SELECT COUNT(*) as 'count', `userkey` FROM `users` WHERE `email`='$email'");
        if ($rez and $rez = mysqli_fetch_array($rez) and $rez['count'] > 0){
            $restore_key = hash("sha256", $email . time() . rand(0, 100));
            $userkey = $rez['userkey'];
            $date = date("Y-m-d H:i:s");

            mysqli_query($link, "INSERT INTO `restore-password`(`date`,`restorekey`,`userkey`) VALUES('$date','$restore_key','$userkey')");

            $message = "<!DOCTYPE html><html><body>"
                . '<h3 style="font-size: 18px; color: rgb(0, 101, 129); margin: 30px; margin-top: 20px; margin-bottom: 20px; padding: 0px;">Конкурс Пятерка</h3>'
                . "<p>Мы получили запрос на восстановление пароля. Для того, чтобы восстановить пароль, перейдите по ссылке <a href='http://konkurs-5erka.ru/restore-password.php?restorekey=$restore_key'>http://konkurs-5erka.ru/restore-password.php?restorekey=$restore_key</a>'"
                . "<p>С уважением, администрация проекта.</p>"
                . "<p>Данное письмо отправлено автоматически, на него не нужно отвечать.</p>"
                . "</body></html>";

            $message_data = array(
                'title' => 'Восстановление пароля',
                'to' => $email,
                'to_name' => '',
                'text' => $message,
                'unsubscribe' => array(
                    'link' => 'https://konkurs-5erka.ru/unsubscribe-one-click.php',
                    'email' => 'support@konkurs-5erka.ru'
                )
                );
        
            $mail = new mail();
            if (!$mail->send($message_data)){
                break_script("Ошибка при отправке письма на указанный Email. Попробуйте позже.");
            }
        }
        else{
            break_script("Пользователь с таким E-mail не найден. Проверьте правильность введенных данных.");
        }
    }
    else {
        log::e("restore-password: ERROR WITH CONNECTION TO DATABASE");
        break_script("Ошибка подключения к базе данных.");
    }
    $arr['message'] = "На почту <b>$email</b> было отправлено письмо с указанием дальнейших инструкций.";
    echo json_encode($arr);
?>