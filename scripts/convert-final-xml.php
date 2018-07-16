<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/system/db.php');
    include('error-script.php');
    require_once ($_SERVER['DOCUMENT_ROOT'] . '/PHPExcel/IOFactory.php');
    set_time_limit (60 * 60);
    ini_set("memory_limit", "3000M");

    //*********** Открываем файл
    //$xls = PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT'] . '/testExcel/valid.xlsx');
    //*********** Устанавливаем индекс активного листа
    //$xls->setActiveSheetIndex(0);
    //*********** Получаем активный лист
    //$sheet = $xls->getActiveSheet();

    log::d("OPENED DOCUMENT");

    for ($i = 11; $i <= $sheet->getHighestRow(); $i++){
        $name = preg_split("/(,)/", $sheet->getCellByColumnAndRow(0, $i)->getValue())[0];
        $email = $sheet->getCellByColumnAndRow(1, $i)->getValue();
        $type = $sheet->getCellByColumnAndRow(4, $i)->getValue();
        
        $rez = mysqli_query($link, "INSERT IGNORE INTO `excel`(`name`, `email`, `type`) VALUES('$name', '$email','$type')");
        if (!$rez){
            log::d(mysqli_error($link));
            break;
        }
        if ($i % 100 == 0){
            log::d("INSERTED <$i> ROW");
        }
    }
    log::d("END");

    echo "<h1>END</h1>"
    
?>