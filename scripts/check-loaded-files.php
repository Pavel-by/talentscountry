<?php
    set_time_limit(60 * 50);

    require_once $_SERVER['DOCUMENT_ROOT'] . "/scripts/yandex-class.php";
    require_once $_SERVER['DOCUMENT_ROOT'] . "/scripts/error-script.php";

    $disk = new DiskOperations();
    $countAll = 0;
    $countLoaded = 0;

    $loadpath = "payment/";
    $files = scandir("payment");
    foreach ($files as $file){
        if ($file == "." or $file == ".."){
            continue;
        }
        $countAll++;
        
        if ($disk->LoadFile($loadpath . $file, "payment/" . $file)){
            unlink("payment/$file");
            $countLoaded++;
        }
    }

    $loadpath = "answer/";
    $files = scandir("answer");
    foreach ($files as $file){
        if ($file == "." or $file == ".."){
            continue;
        }
        $countAll++;
        
        if ($disk->LoadFile($loadpath . $file, "answer/" . $file)){
            unlink("answer/$file");
            $countLoaded++;
        }
    }

    log::d(
        "\n------------------------------------------------------------------------------\n"
        . "-- CHECK SITE DIRECTORIES\n"
        . "-- ALL COUNT:$countAll\n"
        . "-- LOADED COUNT:$countLoaded\n"
        . "------------------------------------------------------------------------------\n"
    );
?>