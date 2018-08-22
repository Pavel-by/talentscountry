<?php

session_start();

if (!defined("ROOT")) define("ROOT", $_SERVER['DOCUMENT_ROOT']);

require_once $_SERVER['DOCUMENT_ROOT'] . '/system/configuration.php';
if (conf["payment-for-download"] and (!isset($_SESSION['userkey']) or !isset($_SESSION['usertype']) or $_SESSION['usertype'] != 1)){
    echo "<h1>Недостаночно прав</h1>";
    exit();
}

$userkey = $_SESSION['userkey'];

include($_SERVER['DOCUMENT_ROOT'] . "/system/db.php");

$filesFolder = $_SERVER['DOCUMENT_ROOT'] . "/files/task/";

if (!$link){
    echo "Ошибка подключения к базе данных";
    exit();
}

$rez = mysqli_query($link, "SELECT `classes`, `id` FROM `users` WHERE `userkey`='$userkey'");
if (!$rez or !($rez = mysqli_fetch_array($rez))){
    echo "Ошибка подключения к базе данных";
    exit();
}
$id = $rez['id'];

@mkdir(ROOT . "/temp");
$zipName = $_SERVER['DOCUMENT_ROOT'] . "/temp/Zadaniya_$id.zip";
$zip = new ZipArchive();
if ($zip->open($zipName, ZIPARCHIVE::CREATE) !== TRUE){
    echo "<h1>Ошибка</h1>";
    exit();
}

$competitions = json_decode($rez['classes'], true);
foreach ($competitions as $eng=>$rus){
    echo "ENG = $eng, RUS = $rus";
    $filesDir = $filesFolder . $eng;
    $zipDir = $rus;
    foreach (scandir($filesDir) as $file) {
        if ($file == "." or $file == "..") continue;
        $zip->addFile($filesDir . "/" . $file, $zipDir . "/" . $file);
        echo "ADD " . $filesDir . "/" . $file . " AS $zipDir/$file<br>";
    }
}
$zip->addFile(ROOT . "/files/blank_otvetov.png", "blank_otvetov.png");
echo ROOT . "/files/blank_otvetov.png";
$zip->close();
if (file_exists($zipName)){
    header('Content-type: application/zip');
    header('Content-Disposition: attachment; filename="zadaniya.zip"');
    readfile($zipName);
    unlink($zipName);
}
else{
    echo "<h1>Не удалось создать архив. Возможно, вы не указали ни одного класса при регистрации.</h1>";
}

