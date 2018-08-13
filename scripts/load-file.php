<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/yandex-class.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/error-script.php';
    //use Yandex\Disk\DiskClient;

    @session_start();
    include($_SERVER['DOCUMENT_ROOT'] . '/system/db.php');

    $arr = array(
        'error' => false,
        'texterror' => false
    );

    if (!isset($_SESSION['userkey'])){
        $arr['error'] = true;
        $arr['texterror'] = "Ошибка авторизации. Пожалуйста, <a href='login.php'>войдите</a>.";
    } else{
        $userkey = $_SESSION['userkey'];
    }

    if (!$link){
        $arr['error'] = true;
        $arr['texterror'] = "Ошибка подключения к базе данных";
        SendError("ошибка подключения к БД");
    }

    if (count($_FILES) != 1){
        $arr['error'] = true;
        $arr['texterror'] = "Можно принять только один файл. Получено " . count($_FILES);
    }

    if (!isset($_POST['type'])){
        $arr['error'] = true;
        $arr['texterror'] = "Серверная ошибка. Не установлен тип полученного сообщения.";
    }
    else {
        switch ($_POST['type']){
            case 'payment':
                $dirname = 'payment';
                break;
            case 'answer':
                if (!isset($_SESSION['usertype']) or $_SESSION['usertype'] != 1){
                    $arr['error'] = true;
                    $arr['texterror'] = "Недостаточно прав.";
                }
                $dirname = 'answer';
                break;
            default:
                $arr['error'] = true;
                $arr['texterror'] = "Серверная ошибка. Не установлен тип полученного сообщения.";
                break;
        }
    }

    if ($arr['error'] == false){
        foreach ($_FILES as $key => $file){
            $sql_response = mysqli_query($link, "SELECT `id` FROM `users` WHERE `userkey`='$userkey'");

            if ($sql_response){
                $id = mysqli_fetch_array($sql_response)['id'];
                
                $ext = preg_split('/[.]/', basename($file['name']));
                $ext = count($ext) > 1 ? '.' . $ext[count($ext) - 1] : '';

                $name = "id=$id" . '_'
                    . 'time=' . date('Y-m-d+H-i-s')
                    . $ext;

                $diskDirectory = "/$dirname";
                $diskPath = $diskDirectory . '/' . $name;
                @mkdir($dirname);

                $filename = $dirname . '/' . $name;

                $disk = new DiskOperations();

                $disk->CreateFolder($dirname);
                $response = $disk->LoadFile($diskPath, $file['tmp_name']);

                if (!$response){
                    copy($file['tmp_name'], $filename);
                }

                $sqlDate = date('Y-m-d H:i:s');
                $sqlName = $file['name'];
                
                mysqli_query($link, "INSERT INTO `loaded-files`(`date`, `name`, `userkey`, `type`) VALUES('$sqlDate', '$sqlName', '$userkey','$dirname')");
            }
            else{
                $arr['error'] = true;
                $arr['texterror'] = "Ошибка подключения к базе данных";
                log::e(mysqli_error($link));
            }
        }
    }

    echo json_encode($arr);
?>