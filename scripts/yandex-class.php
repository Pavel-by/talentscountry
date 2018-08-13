<?php
if ( !defined( "ROOT" ) ) define( "ROOT", $_SERVER[ 'DOCUMENT_ROOT' ] );

require_once(ROOT . '/scripts/error-script.php');
require_once (ROOT . "/system/configuration.php");

class DiskOperations {

    /**
    *------Получить ссылку для загрузки файла------------------
    */

    public function __construct(){

    }

    public function GetLoadLink($path = ''){
        if ($path == ''){
            return false;
        }

        $url = 'https://cloud-api.yandex.net/v1/disk/resources/upload?path=' . urlencode($path);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: OAuth ' . conf['yandex.token'],
            'Content-Type: application/json; charset=utf-8'
        ));

        $output = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code == '200'){
            log::d('SUCCESSFULLY GET LINK FOR PATH ' . $path);
            curl_close($ch);
            return $output['href'];
        }
        else{
            $message = "GET HTTP CODE $http_code FOR PATH $path\r\n"
                        . var_dump($output);
            log::e($message);
            curl_close($ch);
            return false;
        }
    }

    /**
    *----------Загрузить файл------------------------------
    */
    public function LoadFile($loadpath = '', $filename = ''){
        if ($loadpath == '' or $filename == ''){
            return false;
        }

        $url = $this->GetLoadLink($loadpath);

        if ($url == false){
            return false;
        }

        $fp = fopen($filename, 'r');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: OAuth ' . conf['yandex.token']
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PUT, 1);
        curl_setopt($ch, CURLOPT_INFILE, $fp);
        curl_setopt($ch, CURLOPT_INFILESIZE, filesize($filename));

        $output = json_decode(curl_exec($ch), true);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_code == '201'){
            log::d('SUCCESSFULLY LOAD FILE ON PATH ' . $loadpath);
            return true;
        }
        else {
            $message = "PUT HTTP CODE $http_code WITH PATH $loadpath\r\n"
                        . var_dump($output);
            log::e($message);
            return false;
        }
    }

    /**
    *--------Создать папку------------------------------------------
    */
    public function CreateFolder($path = ''){
        if ($path == ''){
            return false;
        }
        $path = urlencode($path);
        $url = "https://cloud-api.yandex.net/v1/disk/resources?path=$path";
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PUT, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: OAuth ' . conf['yandex.token']
        ));

        $output = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code == '201'){
            log::d('SUCCESSFULLY CREATE FOLDER ON PATH ' . $path);
            curl_close($ch);
            return true;
        }
        else if ($http_code == '409'){
            log::d('FOLDER ALREADY EXIST ON PATH ' . $path);
            curl_close($ch);
            return true;
        }
        else{
            $message = "CREATE FOLDER HTTP CODE $http_code FOR PATH \"$url\"\r\n"
                        . json_encode($output);
            log::e($message);
            curl_close($ch);
            return false;
        }
    }
}
