<?php
    /*
    * Обновить общую таблицу результатов
    */

    @session_start();
    //Права администратора
    if ( !isset($_SESSION['usertype']) or $_SESSION['usertype'] != 2 ) {
        break_script("Недостаточно прав для выполнения операции.");
    }

    //Подключаем модули
    include( $_SERVER['DOCUMENT_ROOT'] . '/system/db.php' );
    include( 'error-script.php' );
    include( 'break-script.php' );
    require_once ( "common-functions.php" );
    require_once ( "error-script.php" );
    require_once ( $_SERVER['DOCUMENT_ROOT'] . '/PHPExcel/IOFactory.php' );

    //Константы
    define( "START_ROW",            100 );
    define( "ID_COLUMN",            101 );
    define( "NAME_COLUMN",          102 );
    define( "COMPETITION_COLUMN",   103 );
    define( "CLASS_COLUMN",         104 );
    define( "POINTS_COLUMN",        105 );
    define( "RATING_COLUMN",        106 );
    define( "PLACE_COLUMN",         107 );
    define( "INDEX_COLUMN",         108 );

    //Можно передать только 1 файл
    if ( count($_FILES) != 1 ) {
        break_script( "Некорректное количество входных файлов: можно передать только один файл" );
    }

    //_______ПИШЕМ ОСНОВНОЙ КОД________________________________________________________

    $params     = setGotValues();
    $fileInfo   = CF::convert_files( $_FILES )[0];

    $xls        = PHPExcel_IOFactory::load( $fileInfo['tmp_name'] );
    $xls        ->setActiveSheetIndex( 0 );
    $sheet      = $xls->getActiveSheet();
    $maxRow     = $sheet->getHighestRow();
    $maxColumn  = PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn());

    $insertedCount = 0;

    for ( $row = $params[START_ROW]; $row <= $maxRow; $row++ ) {
        //ID пользователя
        $forId          = mysqli_real_escape_string(
            $link,
            $sheet->getCellByColumnAndRow($params[ID_COLUMN], $row)->getValue()
        );
        //Имя участника
        $name           = mysqli_real_escape_string(
            $link,
            $sheet->getCellByColumnAndRow($params[NAME_COLUMN], $row)->getValue()
        );
        //Название конкурса
        $competition    = mysqli_real_escape_string(
            $link,
            $sheet->getCellByColumnAndRow($params[COMPETITION_COLUMN], $row)->getValue()
        );
        //Класс участника
        $class          = mysqli_real_escape_string(
            $link,
            $sheet->getCellByColumnAndRow($params[CLASS_COLUMN], $row)->getValue()
        );
        //Набранные баллы
        $points         = mysqli_real_escape_string(
            $link,
            $sheet->getCellByColumnAndRow($params[POINTS_COLUMN], $row)->getValue()
        );
        //Рейтинг (как я понял, % набранных баллов от общего кол-ва)
        $rating         = mysqli_real_escape_string(
            $link,
            $sheet->getCellByColumnAndRow($params[RATING_COLUMN], $row)->getValue()
        );
        //Занятое место
        $place          = mysqli_real_escape_string(
            $link,
            $sheet->getCellByColumnAndRow($params[PLACE_COLUMN], $row)->getValue()
        );
        //Индекс
        $index          = mysqli_real_escape_string(
            $link,
            $sheet->getCellByColumnAndRow($params[INDEX_COLUMN], $row)->getValue()
        );

        if (!isset($forId) or empty($forId)) {
            continue;
        }

        $sql = mysqli_query(
            $link,
            "INSERT INTO `results`(`forId`,`name`,`competition`,`class`,`points`,`rating`,`place`,`postindex`) "
            . "VALUES($forId, '$name', '$competition','$class','$points','$rating','$place','$index')"
        );
        log::e("INSERT INTO `results`(`forId`,`name`,`competition`,`class`,`points`,`rating`,`place`,`postindex`) "
            . "VALUES($forId, '$name', '$competition','$class','$points','$rating','$place','$index')");

        if ( !$sql ) {
            log::e( "CANNOT INSERT RESULT LINE: " . mysqli_error($link) );
            break_script( "Ошибка при попытке добавления очередной записи в базу данных. "
                . "Всего было добавлено записей: " . strval($insertedCount) );
        }

        $insertedCount += 1;
    }

    log::sql( $link, "Загрузка $insertedCount записей в таблицу результатов. ");
    end_script( "Загрузка завершена. Было добавлено записей: $insertedCount" );

    //__________КОНЕЦ ОСНОВНОГО КОДА___________________________________________________________

    //Возвращает полученные через POST параметры (или, при их отсутствии, значения
    //по умолчанию)
    function setGotValues() {
        $mas = array();

        $mas[START_ROW]             = validateValue( $_POST['startRow'], 1 );
        $mas[ID_COLUMN]             = PHPExcel_Cell::columnIndexFromString(
            validateValue( $_POST['idColumn'],          'A' )
        ) - 1;
        $mas[NAME_COLUMN]           = PHPExcel_Cell::columnIndexFromString(
            validateValue( $_POST['nameColumn'],        'B' )
        ) - 1;
        $mas[COMPETITION_COLUMN]    = PHPExcel_Cell::columnIndexFromString(
            validateValue( $_POST['competitionColumn'], 'C' )
        ) - 1;
        $mas[CLASS_COLUMN]          = PHPExcel_Cell::columnIndexFromString(
            validateValue( $_POST['classColumn'],       'D' )
        ) - 1;
        $mas[POINTS_COLUMN]         = PHPExcel_Cell::columnIndexFromString(
            validateValue( $_POST['pointsColumn'],      'E' )
        ) - 1;
        $mas[RATING_COLUMN]         = PHPExcel_Cell::columnIndexFromString(
            validateValue( $_POST['ratingColumn'],      'F' )
        ) - 1;
        $mas[PLACE_COLUMN]          = PHPExcel_Cell::columnIndexFromString(
            validateValue( $_POST['placeColumn'],       'G' )
        ) - 1;
        $mas[INDEX_COLUMN]          = PHPExcel_Cell::columnIndexFromString(
                validateValue( $_POST['indexColumn'],       'H' )
            ) - 1;

        return $mas;
    }

    function validateValue( $variable, $ifNot = 'A' ) {
        if ( !isset( $variable ) or empty( $variable ) ) {
            return $ifNot;
        }
        return ( strtoupper($variable) );
    }

    function clearTable ( $link, $userkey, $password ) {
        $pass = hash('sha512', $password);
        $sql = mysqli_query($link, "SELECT COUNT(*) FROM `users` WHERE `userkey`='$userkey' and `password`='$pass'");
        if (!$sql) {
            log::e("CONNECT FAILED: " . mysqli_error($link));
            break_script("Ошибка при подключении к базе данных");
        }

        $line = mysqli_fetch_array($sql);
        if ($line['COUNT(*)'] < 1) {
            break_script("Невозможно очистить таблицу: введен неверный пароль.");
        }
    }
?>