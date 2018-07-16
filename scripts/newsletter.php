<?php
    exit();
    include($_SERVER['DOCUMENT_ROOT'] . "/scripts/check-email-for-spam.php");
    $TIME = 60 * 60 * 24;

    $index = 0;
    $valid = array(
        array("konkurs-5erkab@rambler.ru", "pohjuava"),
        array("konkurs-5erkaa@rambler.ru", "pohjuava"),
        array("konkurs-5erkac@rambler.ru", "pohjuava"),
        array("konkurs-5erkad@rambler.ru", "pohjuava"),
        array("konkurs-5erkaf@rambler.ru", "pohjuava"),
        array("konkurs-5erkag@rambler.ru", "pohjuava"),
        array("konkurs-5erkah@rambler.ru", "pohjuava"),
        array("konkurs-5erkai@rambler.ru", "pohjuava"),
        array("konkurs-5erkaj@rambler.ru", "pohjuava"),
        array("konkurs-5erkak@rambler.ru", "pohjuava")
    );

    set_time_limit($TIME + 240);

    include($_SERVER['DOCUMENT_ROOT'] . '/system/db.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/scripts/error-script.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/scripts/mail.php');

    $true = true;
    $lastMessages = array();

    for ($i = 0; $i < 25; $i++){
        $lastMessages[] = $i;
    }

    function updateLastMessages($count = 25){
        global $lastMessages, $index;
        $startCount = count($lastMessages);
        $newArray = array();

        if ($count == $startCount){
            return;
        }

        for ($i = 0; $i < $count - $startCount; $i++){
            $newArray[] = 0;
        }
        for ($i = 0; $i < $count and $i < $startCount; $i++){
            $newArray = $lastMessages[$i];
        }
        $lastMessages = $newArray;
    }

    function put($val){
        global $lastMessages;
        $lastMessages = array_slice($lastMessages, 1, count($lastMessages));
        $lastMessages[] = $val;
    }

    $lastCheckTime = 0;
    function checkEmailsForSpam(){
        global $lastCheckTime, $valid, $index;
        if (time() - $lastCheckTime < 60 * 60){
            return;
        }
        $i = 0;
        while ($i < count($valid)){
            if (checkEmailForSpam($valid[$i][0], $valid[$i][1])){
                $i++;
            }
            else {
                log::e("EMAIL UNDER SPAM <" . $valid[$i][0] . ">");
                log::newsletter("EMAIL UNDER SPAM <" . $valid[$i][0] . ">");
                array_splice($valid, $i, 1);
                if ($i <= $index) {
                    $index = 0;
                }
            }
        }
        if (count($valid) == 0) {
            log::e("РАССЫЛКА ЗАКОНЧЕНА. ВСЕ EMAIL ПОД ПОДОЗРЕНИЕМ НА СПАМ");
            log::newsletter("РАССЫЛКА ЗАКОНЧЕНА. ВСЕ EMAIL ПОД ПОДОЗРЕНИЕМ НА СПАМ");
            exit();
        }
        $lastCheckTime = time();
        updateLastMessages();
    }

    function send($email, $to_name = "Участнику конкурса") {
        global $lastMessages, $valid, $index;
        if (time() - $lastMessages[0] <= 60){
            sleep(60 - (time() - $lastMessages[0]) + 1);
        }
        //checkEmailsForSpam();
        put(time());
        updateLastMessages((int) 150 * count($valid) / 60);

        $data = file_get_contents("../email-letter.html");

        $data = preg_replace('/__EMAIL__/m', $email, $data);
        $data = preg_replace('/__NAME__/m', $to_name, $data);

        $username = $valid[$index][0];
        $password = $valid[$index][1];

        $message_data = array(
            "username" => $username,
            "password" => $password,
            'title' => 'Конкурс "Пятерка" приглашает к участию всех желающих',
            'to' => $email,
            'to_name' => $to_name,
            'text' => $data,
            'unsubscribe' => array(
                'link' => "http://konkurs-5erka.ru/unsubscribe-one-click.php?email=$email",
                'email' => 'support@konkurs-5erka.ru'
            )
        );

        $mail = new mail();
        $index++;
        if ($index >= count($valid)){
            $index = 0;
        }
        sleep(20);
        if ($mail->send($message_data)){
            log::newsletter("SUCCESS SENDED EMAIL ON <$email> FROM <$username>");
            return true;
        }
        else {
            log::newsletter("FAILED WITH SENDING EMAIL ON <$email> FROM <$username>");
            sleep(200);
            return false;
        }
    }
    
    updateLastMessages();
    
    $sended = array();

    $start = time();
    $end = $start + $TIME;

    $sql = mysqli_query($link, "SELECT COUNT(*) as 'count' FROM `sended-emails`");
    if (!$sql){
        log::e("CANNOT START NEWSLETTER; CANNOT GET COUNT FROM SENDED");
        log::newsletter("CANNOT START NEWSLETTER; CANNOT GET COUNT FROM SENDED");
        log::e('SQL: ' . mysqli_error($link));
        exit();
    }
    $sql = mysqli_fetch_array($sql);
    $currentRow = $sql['count'];

    while (time() < $end){
        $endRow = $currentRow + 50;
        $sql = mysqli_query($link, "SELECT `name`, `email` FROM `excel-emails1` WHERE `email` not in (SELECT `email` FROM `sended-emails`) and `email` not LIKE '%yandex.ru' and `email` not LIKE '%ya.ru' and `email` not LIKE '%rambler.ru' ORDER BY `id` LIMIT $currentRow, $endRow");
        if (!$sql){
            log::e("CANNOT GET EMAILS LIST FROM <excel-emails>");
            log::e('SQL: ' . mysqli_error($link));
            sleep(10);
        }
        else {
            while ($line = mysqli_fetch_array($sql)){
                $email = $line['email'];
                $name = $line['name'];
                $currentRow += 1;
                $date = date('Y-m-d H:i:s');
                if(send($email, $name)){
                    while (!mysqli_query($link, "INSERT IGNORE INTO `sended-emails`(`date`,`email`) VALUES('$date','$email')")){
                        log::e('SQL: ' . mysqli_error($link));
                        log::e("INSERT IGNORE INTO `sended-emails`(`date`,`email`) VALUES('$date','$email')");
                        sleep(10);
                    }
                }
                else {
                    while (!mysqli_query($link, "INSERT IGNORE INTO `sended-emails`(`date`,`email`,`success`) VALUES('$date','$email','false')")){
                        log::e('SQL: ' . mysqli_error($link));
                        log::e("INSERT IGNORE INTO `sended-emails`(`date`,`email`,`success`) VALUES('$date','$email','false')");
                        sleep(10);
                    }
                }
            }
        }
    }
?>