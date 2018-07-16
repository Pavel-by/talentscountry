<?php
    ini_set ("display_errors", "1");

    error_reporting(E_ALL);
    /**
     * Получить определенную таблицу
     * АДМИН
     */
    setlocale(LC_ALL, 'ru_RU.CP1251');

    @session_start();
    if (!isset($_SESSION['usertype']) or $_SESSION['usertype'] != 2) {
        echo "Недостаточно прав";
        exit;
    }

    include_once($_SERVER['DOCUMENT_ROOT'] . "/system/db.php");
    include_once("error-script.php");
    require_once($_SERVER['DOCUMENT_ROOT'] . '/PHPExcel.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/PHPExcel/Writer/Excel5.php');

    if (!$link) {
        echo "Ошибка при подключении к базе данных";
        exit();
    }

    $date = date("Y m d");
    $table = (isset($_GET['table']) ? $_GET['table'] : "users");
    switch ($table) {
        case 'payment':
            $filename = "PAYMENT_ON_$date.xls";
            $fullPath = $filename;
            $sql_request = "SELECT `loaded-files`.`date`, `users`.`email`, `loaded-files`.`real-name`, `loaded-files`.`name` FROM `loaded-files`,`users` WHERE `loaded-files`.`type`='payment' and `loaded-files`.`userkey`=`users`.`userkey`";
            $firstFileSt = array(
                toWindow('Дата                   '), 
                toWindow('Email'),
                toWindow('Название на сервере    '),
                toWindow('Название               ') 
            );
            $cellWidth = array (
                "A" => 20,
                "B" => 30,
                "C" => 50,
                "D" => 50
            );
            break;

        case 'answers':
            $filename = "ANSWERS_ON_$date.xls";
            $fullPath = $filename;
            $sql_request = "SELECT `loaded-files`.`date`, users.email ,`loaded-files`.`real-name`, `loaded-files`.`name` FROM `loaded-files`,`users` WHERE `loaded-files`.`type`='answer' and `loaded-files`.`userkey`=`users`.`userkey`";
            $firstFileSt = array(
                toWindow('Дата                   '), 
                toWindow('Email'),
                toWindow('Название на сервере    '),
                toWindow('Название               ') 
            );
            $cellWidth = array (
                "A" => 20,
                "B" => 30,
                "C" => 50,
                "D" => 50
            );
            break;

        case 'subscribed':
            $filename = "SUBSCRIBED_ON_$date.xls";
            $fullPath = $filename;
            $sql_request = "SELECT `date`, `email` FROM `subscribed`";
            $firstFileSt = array(
                toWindow('Дата                   '), 
                toWindow('Email                  ')
            );
            $cellWidth = array(
                "A" => 20,
                "B" => 60
            );
            break;

        case 'unsubscribed':
            $filename = "UNSUBSCRIBED_ON_$date.xls";
            $fullPath = $filename;
            $sql_request = "SELECT `date`, `email` FROM `unsubscribed`";
            $firstFileSt = array(
                toWindow('Дата                   '), 
                toWindow('Email                  ')
            );
            $cellWidth = array(
                "A" => 20,
                "B" => 60
            );
            break;
        
        
        default:
            $filename = "USERS_ON_$date.xls";
            $fullPath = $filename;
            $sql_request = "SELECT `registerdate`, `name`, `region`, `city`, `school`, `email`,`phone`,`participants`,`teachers`,`post`,`postaddress`,`postname`,`postcode` FROM `users`";
            $firstFileSt = array(
                toWindow('Дата регистрации       '), 
                toWindow('Имя                    '), 
                toWindow('Регион                 '), 
                toWindow('Город                  '),
                toWindow('Школа                  '),
                toWindow('Email                  '),
                toWindow('Телефон                '),
                toWindow('Количество участников  '),
                toWindow('Количество учителей    '),
                toWindow('Получать почту в бумажном варианте (0 = нет, 1 = да)'),
                toWindow('Почтовый адрес         '),
                toWindow('Имя получателя         '),
                toWindow('Почтовый индекс        ')
            );
            $cellWidth = array(
                "A" => 20,
                "B" => 40,
                "C" => 30,
                "D" => 30,
                "E" => 40,
                "F" => 30,
                "G" => 16,
                "H" => 15,
                "I" => 15,
                "J" => 15,
                "K" => 80,
                "L" => 30,
                "M" => 20
            );
            break;
    }

    $sql = mysqli_query($link, $sql_request);

    if (!$sql) {
        echo "Ошибка при подключении к базе данных";
        log::e( mysqli_error($link) );
        exit();
    }

    //Начинаем создание файла
    $xls    = new PHPExcel();
    $xls    ->setActiveSheetIndex(0);
    $sheet  = $xls->getActiveSheet();
    $sheet  ->setTitle('Таблица');
    
    $column = 0;
    $row    = 1;

    foreach ($firstFileSt as $line) {
        $sheet->setCellValueByColumnAndRow(
            $column,
            $row,
            $line            
        );
        $column += 1;
    }

    $row    += 1;
    $column = 0;

    while ($line = mysqli_fetch_assoc($sql)) {
        $column = 0;
        foreach ($line as $item) {
            $sheet->setCellValueByColumnAndRow(
                $column,
                $row,
                $item            
            );
            $column += 1;
        }
        $row += 1;
    }

    foreach ($cellWidth as $cell=>$width) {
        $sheet->getColumnDimension($cell)->setWidth($width);
    }

    //Ставим заголовки
    header ( "Cache-Control: no-cache, must-revalidate" );
    header ( "Pragma: no-cache" );
    header ( "Content-type: application/vnd.ms-excel" );
    header ( "Content-Disposition: attachment; filename=$filename" );
    
    //Выводим
    $objWriter = new PHPExcel_Writer_Excel5($xls);
    $objWriter->save('php://output');

    function getSt($values) {
        return '"' . implode('";"', $values) . '";';
    }

    function toWindow($ii){
        return $ii;
        return iconv( "utf-8", "windows-1251",$ii);
    }
?>