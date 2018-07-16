<?php
    /**
     * Получить результаты конкурса
     * ПРАВА ПОЛЬЗОВАТЕЛЯ
     */

    include ( "break-script.php" );
    include ( $_SERVER['DOCUMENT_ROOT'] . "/system/db.php" );
    require_once ( "error-script.php" );
    require_once ( $_SERVER['DOCUMENT_ROOT'] . '/PHPExcel.php' );
    require_once ( $_SERVER['DOCUMENT_ROOT'] . '/PHPExcel/Writer/Excel5.php' );

    //Проверяем права
    @session_start ();
    if ( !isset( $_SESSION['usertype'] ) or $_SESSION['usertype'] != 1 ) {
        break_script("Недостаточно прав.");
    }

    $userkey = $_SESSION['userkey'];

    //Проверяем подключение 
    if ( !$link or !mysqli_ping( $link )) {
        echo "Отсутствует подключение к базе данных. Пожалуйста, попробуйте позже.";
        exit();
    }

    //Названия столбцов
    $firstFileSt = array(
        'Имя участника', 
        'Название конкурса', 
        'Класс участника', 
        'Набранные баллы',
        'Рейтинг',
        'Занятое место'
    );

    //Ширина столбцов
    $cellWidth = array(
        "A" => 20,
        "B" => 40,
        "C" => 30,
        "D" => 30,
        "E" => 20,
        "F" => 25
    );

    //Borders
    $border = array(
        'right'     => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
            '	rgb' => '808080'
            )
        ),
        'top'     => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'rgb' => '808080'
            )
        ),
        'left'     => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'rgb' => '808080'
            )
        ),
        'bottom'     => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array(
                'rgb' => '808080'
            )
        )
    );

    //Получаем общую информацию
    $sql = mysqli_query( $link, "SELECT * FROM `users` WHERE `userkey`='$userkey'" );

    $rez = mysqli_fetch_array( $sql );

    $school = $rez['school'];
    $id     = $rez['id'];

    //Создаем файлик
    $xls    = new PHPExcel();
    $xls    ->setActiveSheetIndex(0);
    $sheet  = $xls->getActiveSheet();
    $sheet  ->setTitle('Результаты');

    $sheet->mergeCells('A1:F1');
    $sheet->getStyle('A1')->getFont()->setBold('Bold');
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(
        PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->setCellValueByColumnAndRow( 0, 1, $school );

    //Ставим названия столбцов + Bold
    $row    = 3;
    $column = 0;
    foreach ($firstFileSt as $text) {
        $sheet->setCellValueByColumnAndRow(
            $column, 
            $row,
            $text
        );
        $sheet->getCellByColumnAndRow($column, $row)->getStyle()->getFont()->setBold('Bold');
        $sheet->getStyleByColumnAndRow( $column, $row )->getFill()->setFillType(
            PHPExcel_Style_Fill::FILL_SOLID);
        $sheet->getStyleByColumnAndRow( $column, $row )->getFill()->getStartColor()->setRGB('EEEEEE');
        $sheet->getStyleByColumnAndRow( $column, $row )->getBorders()->applyFromArray($border);
        $column++;
    }
    $column = 0;

    //Ставим ширину столбцов
    foreach ($cellWidth as $cell=>$width) {
        $sheet->getColumnDimension($cell)->setWidth($width);
    }

    $sql = mysqli_query( $link, "SELECT `name`,`competition`,`class`,`points`,`rating`,`place` FROM `results` WHERE `forId`=$id" );
    //Выводим в таблицу
    $row = 4;
    while ( $line = mysqli_fetch_assoc( $sql ) ) {
        $column = 0;
        foreach ( $line as $text ) {
            $sheet->setCellValueByColumnAndRow(
                $column, 
                $row,
                $text
            );
            $sheet->getStyleByColumnAndRow( $column, $row )->getFill()->getStartColor()->setRGB('EEEEEE');
            $sheet->getStyleByColumnAndRow( $column, $row )->getBorders()->applyFromArray($border);
            $column++;
        }
        $row += 1;
    }

    $filename = $school . ".xls";
    //Ставим заголовки
    header ( "Cache-Control: no-cache, must-revalidate" );
    header ( "Pragma: no-cache" );
    header ( "Content-type: application/vnd.ms-excel" );
    header ( "Content-Disposition: attachment; filename=$filename" );
    
    //Выводим
    $objWriter = new PHPExcel_Writer_Excel5($xls);
    $objWriter->save('php://output');

    /*$path       = $_SERVER['DOCUMENT_ROOT'] . "/images/diploma/2.jpg";
    $savePath   = $_SERVER['DOCUMENT_ROOT'] . "/images/diploma/test1.jpg";
    $font       = $_SERVER['DOCUMENT_ROOT'] . "/fonts/Firasansmedium.ttf";

    $tom = new TextOnImage($path);
    $tom->setFont ( $font, 60, "#383838" );
    $tom->write ( 1230, 1480, "Мирончик Павел", true );
    $tom->write ( 1230, 1675, "Бийск, КГБОУ БЛИК", true );
    $tom->write ( 1230, 1880, "Математика", true );
    $tom->output ( $savePath );

    function diploma ( $resourcePath, $savePath, $text, $settings ) {
        $tom = new TextOnImage($resourcePath);
        $tom->setFont ( $font, 60, "#383838" );
        $tom->write ( 1230, 1480, "Мирончик Павел", true );
        $tom->write ( 1230, 1675, "Бийск, КГБОУ БЛИК", true );
        $tom->write ( 1230, 1880, "Математика", true );
        $tom->output ( $savePath );
    }*/


    $dip = new Diploma ( $_SERVER['DOCUMENT_ROOT'] );
    $dip->diploma ( 
        false, 
        "images/test101.jpg",
        array (
            "КГБОУ \"Бийский лицей-интернат Алтайского края\"",
            "г.Бийск"
        ),
        Diploma::TYPE_THANKS_SCHOOL
    );
?>