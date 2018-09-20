<?php

if (!defined("ROOT")) define("ROOT", $_SERVER['DOCUMENT_ROOT']);

$conf = array(
    "payment-for-download" => true,
    "payment-for-answer" => true,
    "payment-for-results" => true,
    "type.user" => 0,
    "type.admin" => 2,
    "block-after-five-days" => false,
    "yandex.token" => "AQAAAAAkjLZVAATq2Meh8QQR6ELlhgxfHS4rQV4"
);
$confFile = fopen(ROOT . "/system/configuration.conf", "r");
while (($s = fgets($confFile)) !== false) {
    $param = preg_split("/(\=)/", $s);
    $param[1] = trim($param[1]);
    if ($param[1] === 'true') $param[1] = true;
    if ($param[1] === 'false') $param[1] = false;
    if (is_numeric($param[1])) $param[1] = intval($param[1]);
    $conf[trim($param[0])] = $param[1];
}
fclose($confFile);
define("conf", $conf);