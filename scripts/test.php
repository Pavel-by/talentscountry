<?php

if (!defined("ROOT")) define("ROOT", $_SERVER['DOCUMENT_ROOT']);

ini_set("display_errors", "1");

error_reporting(E_ALL);

set_time_limit(60 * 60 * 2);

echo json_encode(array(), JSON_UNESCAPED_UNICODE);

/*include(ROOT . "/class/diploma.php");

$diploma = new Diploma(ROOT);

$diploma->diploma(false, ROOT . "/test/school.png", array("Pavel", "Liceum"), Diploma::TYPE_THANKS_TEACHER);


/*
TESTING NEWSLETTER

include(ROOT . "/scripts/newsletter-script.php");

$newsletter = new Newsletter();
$newsletter->setHost("smtp.beget.ru");
$newsletter->setLogin("help@stranatalantow.ru");
$newsletter->setPassword("kJsr4ioE");
$newsletter->setTitle("Пробуем");
$newsletter->setFrom("help@stranatalantow.ru");
$newsletter->setFromName("Pavel");

$data = [
    "email" => "meyejebew@poly-swarm.com",
    "unsubscribe" => [
        "link" => "stranatalantow.ru/unsubscribe-one-click.php",
        "email" => "help@stranatalantow.ru"
    ],
    "name" => "Alex",
    "text" => file_get_contents(ROOT . "/newsletter/newsletter-list-inline-css.html")
];

echo($newsletter->send($data) ? "true" : "false");
*/

/**require_once ROOT . "/class/Tasks.php";
 *
 * @mkdir(ROOT . "/temp");
 * $f = fopen(ROOT . "/temp/map.txt", "w");
 *
 * foreach(scandir(ROOT . "/files/task") as $dir) {
 * fwrite($f, "\"$dir\"=>\"\",\n");
 * }
 *
 * fclose($f);*/


/*require_once "diploma.php";
$dip = new Diploma($_SERVER['DOCUMENT_ROOT']);
if(!$dip->diploma(
    false,
    "images/test4.jpg",
    array("Павел", "Бийский лицей", "Математика", 100),
    Diploma::TYPE_SERTIFICATE
)) echo "FALSE<br>";*/

/*function toEn($string)
{
    $arStrES = array("ае","уе","ое","ые","ие","эе","яе","юе","ёе","ее","ье","ъе","ый","ий");
    $arStrOS = array("аё","уё","оё","ыё","иё","эё","яё","юё","ёё","её","ьё","ъё","ый","ий");
    $arStrRS = array("а$","у$","о$","ы$","и$","э$","я$","ю$","ё$","е$","ь$","ъ$","@","@");

    $replace = array("А"=>"A","а"=>"a","Б"=>"B","б"=>"b","В"=>"V","в"=>"v","Г"=>"G","г"=>"g","Д"=>"D","д"=>"d",
                     "Е"=>"Ye","е"=>"e","Ё"=>"Ye","ё"=>"e","Ж"=>"Zh","ж"=>"zh","З"=>"Z","з"=>"z","И"=>"I","и"=>"i",
                     "Й"=>"Y","й"=>"y","К"=>"K","к"=>"k","Л"=>"L","л"=>"l","М"=>"M","м"=>"m","Н"=>"N","н"=>"n",
                     "О"=>"O","о"=>"o","П"=>"P","п"=>"p","Р"=>"R","р"=>"r","С"=>"S","с"=>"s","Т"=>"T","т"=>"t",
                     "У"=>"U","у"=>"u","Ф"=>"F","ф"=>"f","Х"=>"Kh","х"=>"kh","Ц"=>"Ts","ц"=>"ts","Ч"=>"Ch","ч"=>"ch",
                     "Ш"=>"Sh","ш"=>"sh","Щ"=>"Shch","щ"=>"shch","Ъ"=>"","ъ"=>"","Ы"=>"Y","ы"=>"y","Ь"=>"","ь"=>"",
                     "Э"=>"E","э"=>"e","Ю"=>"Yu","ю"=>"yu","Я"=>"Ya","я"=>"ya","@"=>"y","$"=>"ye");

    $string = str_replace($arStrES, $arStrRS, $string);
    $string = str_replace($arStrOS, $arStrRS, $string);

    return iconv("UTF-8","UTF-8//IGNORE",strtr($string,$replace));
}*/


//Распарсим файлы и получим названия для вставки в PHP
/*$dir = $_SERVER['DOCUMENT_ROOT'] . "/files/task";
$out = fopen($_SERVER['DOCUMENT_ROOT'] . "/files/test.txt", 'w');
echo $_SERVER['DOCUMENT_ROOT'] . "/files/test.txt";

func($dir);
function func($dir) {
    global $out;
    $files = scandir($dir);
    $j = cut($dir);
    fwrite($out, "\"$j\"=>array(\n");
    foreach ($files as $file) {
        if ($file == '.' or $file == '..') {
            continue;
        }

        if (is_dir("$dir/$file")) {
            func("$dir/$file");
            continue;
        }
        $i = parse($file);

        $temp = explode(".", $file);

        $newName = createName(basename($dir), parse($i), end($temp));

        copy("$dir/$file", "$dir/$newName");
        unlink("$dir/$file");
        fwrite($out, "$i => \"$newName\",\n");
    }
    fwrite($out, "),\n");
}

function parse($s) {
    return (int) preg_replace('/[^0-9]/', '', $s);
}

function cut($s) {
    $mas = preg_split("/(\/)/", $s);
    return $mas[count($mas)-1];
}

fclose($out);*/

/*require_once($_SERVER['DOCUMENT_ROOT'] . '/PHPExcel.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/PHPExcel/Writer/Excel5.php');
include($_SERVER['DOCUMENT_ROOT'] . "/system/db.php");

$xls = new PHPExcel();
// Устанавливаем индекс активного листа
$xls->setActiveSheetIndex(0);
// Получаем активный лист
$sheet = $xls->getActiveSheet();
// Подписываем лист
$sheet->setTitle('Таблица');

$sql = mysqli_query($link, "SELECT `email`,`name`,`type` FROM `excel-to-alex`");
$column = 0;
$row = 2;

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


$sheet->getColumnDimension('A')->setWidth(100);
$sheet->getColumnDimension("B")->setWidth(100);
$sheet->getColumnDimension('C')->setWidth(100);
$sheet->getColumnDimension('D')->setWidth(100);

header ( "Cache-Control: no-cache, must-revalidate" );
header ( "Pragma: no-cache" );
header ( "Content-type: application/vnd.ms-excel" );
header ( "Content-Disposition: attachment; filename=matrix.xls" );

// Выводим содержимое файла
$objWriter = new PHPExcel_Writer_Excel5($xls);
$objWriter->save('php://output');*/

/*include($_SERVER['DOCUMENT_ROOT'] . "/system/db.php");

mysqli_query(
    $link,
    "INSERT IGNORE INTO `excel-to-alex`(`email`,`name`,`type`) "
    . "(SELECT `email`,`name`,`type` FROM `excel-emails1` WHERE `email` NOT IN (SELECT `email` FROM `error-email`) and `email` NOT LIKE '%rambler%')"
);

echo mysqli_error($link);*/

/*include($_SERVER['DOCUMENT_ROOT'] . "/system/db.php");

$f = fopen("to-error.txt", 'r');
while ($line = fgets($f)) {
    $email = trim($line, "'\n\ \r");
    $rez = mysqli_query($link, "INSERT IGNORE INTO `error-email`(`email`) VALUES('$email')");
    echo mysqli_error($link) . "\n";
}
fclose($f);*/

//Переводим из csv файла в таблицу
/*include($_SERVER['DOCUMENT_ROOT'] . "/system/db.php");
$f = fopen($_SERVER['DOCUMENT_ROOT'] . "/testExcel/valid.csv", 'r');
$line = fgets($f);
$emails = array();
while ($line = fgets($f)) {
    $email = trim((preg_split('/(;)/', $line)[0]), " \t\n\r\0\x0B\"");
    $emails[] = $email;
}
fclose($f);

$emails = "'" . implode("','", $emails) . "'";
$sql = mysqli_query($link, "INSERT INTO `valid-emails`(`email`,`name`,`type`) (SELECT `email`,`name`,`type` FROM `excel-emails1` WHERE `email` IN($emails))");*/

/**тестим NewsLetter Script */
/*include("newsletter-script.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/system/db.php");
$newsletter = new Newsletter();

$newsletter->setHost("connect.smtp.bz");
$newsletter->setPort("2525");
$newsletter->setLogin("mairon-pasha@yandex.ru");
$newsletter->setPassword("fAAVokNrArek");
$newsletter->setMaxMessagesInMinute(1);
$newsletter->setMaxMessagesInHour(40);
$newsletter->setSendedDBName("sended-emails");
$newsletter->setEmailsDBName("valid-emails");
$newsletter->hasName();

$text = file_get_contents("../email-letter.html");

for ($i = 0; $i < 50; $i++) {
    $email = $newsletter->getNext();

    $data = preg_replace('/__EMAIL__/m', $email['email'], $text);
    $data = preg_replace('/__NAME__/m', $email['name'], $text);

    $newsletter->send(array(
        "email" => $email['email'],
        "name" => $email['name'],
        "unsubscribe" => array(
            "link" => "http://konkurs-5erka.ru/unsubscribe-one-click.php",
            "email" => "support@konkurs-5erka.ru"
        ),
        "text" => $data
    ));

    mysqli_query($link, "INSERT IGNORE INTO `sended-emails`(`email`) VALUES('" . $email['email'] . "')");
}*/
/*include($_SERVER['DOCUMENT_ROOT'] . "/system/db.php");

$sql = mysqli_query($link, "SELECT `email` FROM `excel-emails1` ORDER BY `id` LIMIT 4000");
$f = fopen($_SERVER['DOCUMENT_ROOT'] . "/NEED_TO_BE_CHECKED.txt", 'w');
while ($line = mysqli_fetch_array($sql)){
    fwrite($f, $line['email'] . "\n");
}
fclose($f);*/

//Отослать письмо
/*include('mail.php');

$email = "web-nxbg7@mail-tester.com";
$to_name = "Товарисчу";

$data = file_get_contents("../email-letter.html");
$data = preg_replace('/__EMAIL__/m', $email, $data);
$data = preg_replace('/__NAME__/m', $to_name, $data);

$message_data = array(
    "username" => "mairon-pasha@yandex.ru",
    "password" => "fAAVokNrArek",
    'title' => 'Конкурс "Пятерка" приглашает к участию всех желающих',
    'to' => $email,
    'to_name' => $to_name,
    'text' => $data,
    'unsubscribe' => array(
        'link' => "http://konkurs-5erka.ru/unsubscribe-one-click.php?email=$email",
        'email' => 'support@konkurs-5erka.ru'
    ),
    'from' => "newsletter@konkurs-5erka.ru"
);

$mail = new mail();
$mail->setHost("connect.smtp.bz");
if (!$mail->send($message_data)){
    echo "NO";
}
else {
    echo "YES";
}*/


//Удаляем пробелы в названии
/*$dir = $_SERVER['DOCUMENT_ROOT'] . "/files/task/---Задания на  ИЗО  2018  март";
renameFiles($dir);
function renameFiles($dir) {
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file == '.' or $file == '..') {
            continue;
        }
        $newname = $dir . '/' . preg_replace('/(\ )/', '', $file);
        rename($dir . '/' . $file, $newname);
        if (is_dir($newname)) {
            renameFiles($newname);
        }
    }
}*/

//E-mail сообщение


/*$urls = preg_match_all("/<img[^<>]*src=\"?'?([^'\" ]*)\"?'?[^<>]*>/m", $data, $matches);
$names = preg_match_all("/<img[^<>]*src=\"?\'?(?:[^\'\" ]*\/)?([^\'\" ]*)\"?\'?[^<>]*>/m", $data, $matches);
$rez = preg_replace("/(<img[^<>]*src=\"?\'?)(?:[^\'\" ]*\/)?([^\'\" ]*)(\"?\'?[^<>]*>)/m", "\${1}cid:\${2}\${3}", $data);
echo $rez;*/

/*include('mail.php');

$data = file_get_contents("../email-letter.html");

$message_data = array(
    'title' => 'Образец рассылки',
    'to' => 'web-gneny@mail-tester.com',
    'to_name' => 'PRIZER',
    'text' => $data,
    'unsubscribe' => array(
        'link' => 'https://konkurs-5erka.ru/unsubscribe-one-click.php',
        'email' => 'support@konkurs-5erka.ru'
    )
    );

$mail = new mail();
$mail->send($message_data);*/


//Проверка E-mail
/*include('check-email-address.php');
include($_SERVER['DOCUMENT_ROOT'] . '/system/db.php');
include('error-script.php');

$sql = mysqli_query($link, 'SELECT `email` FROM `excel-emails` ORDER BY `id` LIMIT 300, ');
$checked = array();
while ($line = mysqli_fetch_array($sql)){
    if (checkEmail($line['email'])){
        log::d('OK ' . $line['email']);
        $rez = mysqli_query($link, "INSERT INTO `checked-emails`(`email`) VALUES('" . $line['email'] ."')");
        if (!$rez){
            log::d(mysqli_error($link));
        }
    }
    else {
        log::d('FALSE ' . $line['email']);
    }
}*/
//$sql = mysqli_query($link, "INSERT INTO `checked-emails`(`email`) VALUES('" . implode("','", $checked) . "')")
//log::d("INSERT INTO `checked-emails`(`email`) VALUES('" . implode("'),('", $checked) . "')");


//echo "<h1 style='text-align: center;'>Раскомменть меня</h1>";

//Считывание Word файлов
/*function read_file_docx($filename){

    $striped_content = '';
    $content = '';

    if(!$filename || !file_exists($filename)) return false;

    $zip = zip_open($filename);

    if (!$zip || is_numeric($zip)) return false;

    while ($zip_entry = zip_read($zip)) {

        if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

        if (zip_entry_name($zip_entry) != "word/document.xml") continue;

        $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

        zip_entry_close($zip_entry);
    }

    zip_close($zip);

    $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
    $content = str_replace('</w:r></w:p>', "\r\n", $content);
    $striped_content = strip_tags($content);

    return $striped_content;
}
include("db.php");
include("error-script.php");
foreach (scandir("test") as $file){
    if ($file == ".." or $file == ".") continue;
    $s = read_file_docx("test/" . $file);
    $arr = preg_match_all("/(?'email'[^, \n]+@[^, \n]+)/m", $s, $matches);
    log::d("ОБРАБОТКА ФАЙЛА $file");
    $count = 0;
    $count1 = 1;
    foreach ($matches as $mas){
        $sql = "";
        foreach ($mas as $email){
            if ($count < 10){
                $count++;
                log::d("EMAIL: $email");
            }
            $sql .= "('$email'),";

        }
        $sql = substr($sql, 0, -1);
        log::d("INSERTED");
        $rez = mysqli_query($link, "INSERT IGNORE INTO `emails`(`email`) VALUES $sql");
        if (!$rez){
            log::d("SQL ERROR: " . mysqli_error($link));
        }
    }
}*/

//Выборка из таблицы
/*include($_SERVER['DOCUMENT_ROOT'] . '/system/db.php');
include($_SERVER['DOCUMENT_ROOT'] . '/scripts/error-script.php');


$criterion = "`type`='Гимназии' or "
    . "`type`='Гимназии-интернаты' or "
    . "`type`='Кадетские школы / корпуса' or "
    . "`type`='Лицеи' or "
    . "`type`='Лицеи-интернаты' or "
    . "`type`='Общеобразовательные школы' or "
    . "`type`='Учебные центры' or "
    . "`type`='Частные школы' or "
    . "`type`='Школы' or "
    . "`type`='Школы-интернаты' or "
    . "`type`='Школы санаторного типа' or "
    . "`type`='Прогимназии, начальные школы-детские сады'";

$rez = mysqli_query($link, "INSERT IGNORE INTO `excel-emails1`(`email`, `name`, `type`) SELECT `email`,`name`,`type` FROM `excel` WHERE $criterion");
$rez = mysqli_query($link, "SELECT COUNT(*) as 'count' FROM `excel` WHERE $criterion");

log::d("SELECT COUNT(*) as 'count' FROM `excel` WHERE $criterion");
if (!$rez){
    log::d("SQL: " . mysqli_error($link));
}
else{
    $rez = mysqli_fetch_array($rez);
    log::d($rez['count']);
}*/

//Удаление кавычек
/*if (!$link){
    log::d("FATAL ERROR: NO MYSQL CONNECTION");
    exit();
}
$rez = mysqli_query($link, "SELECT `id`,`email` FROM `emails` WHERE `email` LIKE '&lt;%&gt;'");
if (!$rez){
    log::d("FATAL ERROR: " . mysqli_error($link));
    exit();
}
while ($arr = mysqli_fetch_array($rez)){
    $s = $arr['email'];
    $s = preg_replace('/&lt;(.+)&gt;/', '$1', $s);
    log::d("REPLACE TO $s FROM ".$arr['email']);
    $id = $arr['id'];
    $check = mysqli_query($link, "SELECT COUNT(*) as 'count' FROM `emails`WHERE `email`='$s'");
    $check = mysqli_fetch_array($check);
    if ($check['count'] == 0){
        log::d("UPDATE <UPDATE `emails` SET `email`='$s' WHERE `id`=$id>");
        $updateResult = mysqli_query($link, "UPDATE `emails` SET `email`='$s' WHERE `id`=$id");
        if (!$updateResult){
            log::d("ERROR: " . mysqli_error($link) . "email=$s, id=$id");
        }
    }
    else{
        $deleteResult = mysqli_query($link, "DELETE FROM `emails` WHERE `id`=$id");
        log::d("MATCH $s");
    }

}*/


//Разделение E-mail по символу |
/*include($_SERVER['DOCUMENT_ROOT'] . '/system/db.php');
include($_SERVER['DOCUMENT_ROOT'] . '/scripts/error-script.php');

$newEmails = array();

$sql = mysqli_query($link, "SELECT `email` FROM `excel-emails1` WHERE `email` LIKE '%|%'");
log::d(mysqli_error($link));

while ($emails = mysqli_fetch_array($sql)){
    $email = $emails['email'];
    $new = explode('|', $email);
    foreach ($new as $val){
        $newEmails[] = '("' . trim($val) . '")';
    }
}

$sql = mysqli_query($link, "INSERT IGNORE INTO `excel-emails1`(`email`) VALUES".implode(',', $newEmails));
log::d(mysqli_error($link));*/

//Удаление E-mail с символом |
/*include($_SERVER['DOCUMENT_ROOT'] . '/system/db.php');
include($_SERVER['DOCUMENT_ROOT'] . '/scripts/error-script.php');

$sql = mysqli_query($link, "DELETE FROM `excel-emails1` WHERE `email` LIKE '%|%'");*/


?>