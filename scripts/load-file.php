<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/yandex-class.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/scripts/error-script.php';
    use Yandex\Disk\DiskClient;

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
            /*echo "\r\nCopy from " . $file['tmp_name']
                ."\r\nto " . $filename;
            
            
            $path = urlencode("/newfolder/");
            $url = "https://cloud-api.yandex.net/v1/disk/resources/upload?path=%2Fnewfolder%2F" . basename($file['name'])
                    . "&overwrite=true";
            
            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_URL, $url); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: OAuth AQAAAAAitvidAAS8bYO7ZUQy-U0gpaE0Yu4ixsQ',
                'Content-Type: application/json; charset=utf-8'
            ));
            
            $output = curl_exec($ch);  
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            log::d("GET HTTP CODE " . $http_code . " FOR FILE " . $file['name']);
            echo "GET HTTP CODE " . $http_code . " FOR FILE " . $file['name'];
            curl_close($ch);
            
            
            
            $outarr = json_decode($output, true);
            if ($http_code == '200'){
                
                $cfile = getCurlValue($filename, mime_content_type($filename), $file['name']);
                
               //NOTE: The top level key in the array is important, as some apis will insist that it is 'file'.
                $data = array('file' => $cfile);

                $fp = fopen($filename, 'r');
                    
                $ch = curl_init();
                SendError($outarr['href']);
                $target_url = $outarr['href'];                
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization: OAuth AQAAAAAitvidAAS8bYO7ZUQy-U0gpaE0Yu4ixsQ'
                ));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, $target_url);
                
                curl_setopt($ch, CURLOPT_PUT, 1);
                curl_setopt($ch, CURLOPT_INFILE, $fp);
                curl_setopt($ch, CURLOPT_INFILESIZE, filesize($filename));

                log::d("START PUT REQUEST");
                $result=curl_exec($ch);
                log::d("END PUT REQUEST");
                $header_info = curl_getinfo($ch,CURLINFO_HEADER_OUT);
                $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                
                $header = substr($result, 0, $header_size);
                $body = substr($result, $header_size);
                echo "\r\nPUT HTTP CODE: " . curl_getinfo($ch, CURLINFO_HTTP_CODE) . "\r\n";

                if (curl_errno($ch)) {
                    
                    $msg = curl_error($ch);
                }
                else {
                
                    $msg = 'File uploaded successfully.';
                }
                
                curl_close ($ch);
                
                $return = array('msg' => $msg);
                
                SendError(json_encode($return));
                
                SendError('http://c91309yz.beget.tech/' . $filename);                
            }
            else{
                SendError(var_dump($outarr));
            }

            SendError($output);

            var_export($output);*/
        }
    }

    echo json_encode($arr);
?>