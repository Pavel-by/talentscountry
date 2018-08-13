<?php

/**
 * Помощник по работе с файлами заданий (изменения файлов, находящихяся в папках заданий)
 */
ini_set("display_errors", "1");

error_reporting(E_ALL);

if (!defined("ROOT")) define("ROOT", $_SERVER['DOCUMENT_ROOT']);
define("TASKS", ROOT . "/files/task");

/**
 * Переменные, доступные для подстановки в строку переименования (формат записи: {{variable}} )
 */
$renameVariables = [
    "eng",
    "class",
    "parentDir",
    "ext"
];

$params = [
    /**
     * Нужно ли деархивировать файлы (архивы будут удалены)
     */
    "unzip" => 0,

    /**
     * Нужно ли переименовывать файлы. 0, есди не нужно, строка если нужно (строка будет являтся выражением, по
     * которому нужно менять имя файла. Доступные переменные см. в массиве renameVariables)
     */
    "rename" => 0,

    /**
     * Переместить все файлы внутри конкурса в корень папки конкурса
     * (например файл /arts/folder/task.docx будет перемещен в /arts/task.docx)
     */
    "moveFilesToRoot" => 0,

    /**
     * Удалить пустые папки
     */
    "deleteEmptyFolders" => 0,

    /**
     * Удалить все архивы, находящиеся в корне папки задания
     */
    "deleteArchives" => 0
];

$params = array_merge($params, $_GET);

var_dump($params);

if ($params['unzip'] == true) {
    foreach (scandir(TASKS) as $taskDir) {
        if ($taskDir == "." or $taskDir == ".." or !is_dir(TASKS . "/$taskDir")) continue;
        $taskDirPath = TASKS . "/$taskDir";
        foreach (scandir($taskDirPath) as $task) {
            $taskPath = $taskDirPath . "/$task";
            if (!is_file($taskPath) or $task == "." or $task == "..") continue;
            if (isArchive($taskPath)) {
                if (unzip($taskPath)) {
                    printLog("Unzipped", $taskPath);
                } else {
                    printLog("Failed to unzip", $taskPath);
                }
            }
        }
    }
}

if ($params['moveFilesToRoot']) {
    foreach (scandir(TASKS) as $taskDir) {
        if ($taskDir == "." or $taskDir == ".." or !is_dir(TASKS . "/$taskDir")) continue;
        $taskDirPath = TASKS . "/$taskDir";
        foreach (scandir($taskDirPath) as $task) {
            $taskPath = $taskDirPath . "/$task";
            if ($task == "." or $task == "..") continue;
            if (is_dir($taskPath)) {
                moveToRoot($taskDirPath, $taskPath);
                continue;
            }
        }
    }
}

if ($params['rename'] != false) {
    foreach (scandir(TASKS) as $taskDir) {
        if ($taskDir == "." or $taskDir == ".." or !is_dir(TASKS . "/$taskDir")) continue;
        $taskDirPath = TASKS . "/$taskDir";
        foreach (scandir($taskDirPath) as $task) {
            $taskPath = $taskDirPath . "/$task";
            if (!is_file($taskPath) or $task == "." or $task == "..") continue;
            $variables = fillVariables($taskPath);
            $newFileName = str_replace($variables['key'], $variables['value'], $params['rename']);
            if (rename($taskPath, $taskDirPath . "/" . $newFileName)) {
                printLog("Renamed", $task, $newFileName);
            } else {
                printLog("Failed to rename", $task, $newFileName);
            }
        }
    }
}

if ($params['deleteEmptyFolders'] == true) {
    foreach (scandir(TASKS) as $taskDir) {
        if ($taskDir == "." or $taskDir == ".." or !is_dir(TASKS . "/$taskDir")) continue;
        $taskDirPath = TASKS . "/$taskDir";
        foreach (scandir($taskDirPath) as $task) {
            $taskPath = $taskDirPath . "/$task";
            if ($task == "." or $task == ".." or !is_dir($taskPath)) continue;
            if (isDirectoryEmpty($taskPath)) {
                unlinkDir($taskPath);
            }
        }
    }
}

if ($params['deleteArchives'] == true) {
    $archiveExt = [
        "rar",
        "zip"
    ];
    foreach (scandir(TASKS) as $taskDir) {
        if ($taskDir == "." or $taskDir == ".." or !is_dir(TASKS . "/$taskDir")) continue;
        $taskDirPath = TASKS . "/$taskDir";
        foreach (scandir($taskDirPath) as $task) {
            $taskPath = $taskDirPath . "/$task";
            if ($task == "." or $task == "..") continue;
            if (is_file($taskPath) and in_array(getExt($task), $archiveExt)) {
                unlink($taskPath);
                printLog("Unlink archive", "..." .basename($taskDirPath) . "/" . $task);
            }
        }
    }
}


//---------------------------------------------------------------------------------------------------

function printLog($col1, $col2 = "", $col3 = "")
{
    printf("% 20s % 60s % 20s\n", $col1, $col2, $col3);
}

function fillVariables($file)
{
    $temp = preg_split("/\./", basename($file));
    return [
        "key" => [
            "{{parentDir}}",
            "{{eng}}",
            "{{class}}",
            "{{ext}}"

        ],
        "value" => [
            basename(dirname($file)),
            toEn(
                implode(array_slice($temp, 0, count($temp) - 1))
            ),
            "" . findInt($file),
            getExt($file)
        ]
    ];
}

function isArchive($filename)
{
    $archiveExt = [
        "rar",
        "zip"
    ];
    return in_array(getExt($filename), $archiveExt);
}

function unzip($file)
{
    if (!isArchive($file)) return false;

    switch (getExt($file)) {
        case "rar":
            $rar = RarArchive::open($file);
            foreach ($rar->getEntries() as $entry) {
                $entry->extract(dirname($file));
            }
            $rar->close();
            return true;
            break;
        case "zip":
            $zip = new ZipArchive();
            if ($zip->open($file)) {
                $zip->extractTo(dirname($file));
                $zip->close();
                return true;
            } else {
                return false;
            }
    }
}

function getExt($filename)
{
    $array = preg_split("/\./", basename($filename));
    return end($array);
}

function toEn($string)
{
    $arStrES = array("ае", "уе", "ое", "ые", "ие", "эе", "яе", "юе", "ёе", "ее", "ье", "ъе", "ый", "ий");
    $arStrOS = array("аё", "уё", "оё", "ыё", "иё", "эё", "яё", "юё", "ёё", "её", "ьё", "ъё", "ый", "ий");
    $arStrRS = array("а$", "у$", "о$", "ы$", "и$", "э$", "я$", "ю$", "ё$", "е$", "ь$", "ъ$", "@", "@");

    $replace = array("А" => "A", "а" => "a", "Б" => "B", "б" => "b", "В" => "V", "в" => "v", "Г" => "G", "г" => "g", "Д" => "D", "д" => "d",
        "Е" => "Ye", "е" => "e", "Ё" => "Ye", "ё" => "e", "Ж" => "Zh", "ж" => "zh", "З" => "Z", "з" => "z", "И" => "I", "и" => "i",
        "Й" => "Y", "й" => "y", "К" => "K", "к" => "k", "Л" => "L", "л" => "l", "М" => "M", "м" => "m", "Н" => "N", "н" => "n",
        "О" => "O", "о" => "o", "П" => "P", "п" => "p", "Р" => "R", "р" => "r", "С" => "S", "с" => "s", "Т" => "T", "т" => "t",
        "У" => "U", "у" => "u", "Ф" => "F", "ф" => "f", "Х" => "Kh", "х" => "kh", "Ц" => "Ts", "ц" => "ts", "Ч" => "Ch", "ч" => "ch",
        "Ш" => "Sh", "ш" => "sh", "Щ" => "Shch", "щ" => "shch", "Ъ" => "", "ъ" => "", "Ы" => "Y", "ы" => "y", "Ь" => "", "ь" => "",
        "Э" => "E", "э" => "e", "Ю" => "Yu", "ю" => "yu", "Я" => "Ya", "я" => "ya", "@" => "y", "$" => "ye");

    $string = str_replace($arStrES, $arStrRS, $string);
    $string = str_replace($arStrOS, $arStrRS, $string);

    return iconv("UTF-8", "UTF-8//IGNORE", strtr($string, $replace));
}

function findInt($s)
{
    return (int)preg_replace('/[^0-9]/', '', $s);
}

function moveToRoot($root, $folder)
{
    foreach (scandir($folder) as $task) {
        $taskPath = $folder . "/$task";
        if ($task == "." or $task == "..") continue;
        if (is_dir($taskPath)) {
            moveToRoot($root, $taskPath);
            continue;
        }
        rename($taskPath, $root . "/" . $task);
        printLog("Rename", $taskPath);
    }
}

function isDirectoryEmpty($dir)
{
    foreach (scandir($dir) as $item) {
        if ($item == "." or $item == "..") continue;
        if ((is_dir($dir . "/" . $item) and !isDirectoryEmpty($dir . "/" . $item))
            or is_file($dir . "/" . $item)) {
            return false;
        }
    }
    return true;
}

function unlinkDir($dir)
{
    foreach (scandir($dir) as $item) {
        if ($item == "." or $item == "..") continue;
        if (is_dir($dir . "/" . $item)) unlinkDir($dir . "/" . $item);
        if (is_file($dir . "/" . $item)) {
            unlink($dir . "/" . $item);
            printLog("Unlink file", "..." . basename(dirname($dir . "/" . $item)) . "/" . basename($dir . "/" . $item));
        }
    }
    printLog("Unlink directory", "..." . basename(dirname($dir)) . "/" . basename($dir));

    rmdir($dir);
}