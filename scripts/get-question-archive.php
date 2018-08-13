<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/system/configuration.php';
if (conf["payment-for-download"] and (!isset($_SESSION['userkey']) or !isset($_SESSION['usertype']) or $_SESSION['usertype'] != 1)){
    echo "<h1>Недостаночно прав</h1>";
    exit();
}

$userkey = $_SESSION['userkey'];

include($_SERVER['DOCUMENT_ROOT'] . "/system/db.php");

$filesFolder = $_SERVER['DOCUMENT_ROOT'] . "/files/task/";

$files = array(
    "arithmetic"=>array(
        10 => "ZadaniyepoArifmetike10kl.Forum...doc",
        11 => "ZadaniyepoArifmetike11kl.Forum...doc",
        1 => "ZadaniyepoArifmetike1kl.Forum...doc",
        2 => "ZadaniyepoArifmetike2kl.Forum...doc",
        3 => "ZadaniyepoArifmetike3kl.Forum...docx",
        4 => "ZadaniyepoArifmetike4kl.Forum...docx",
        5 => "ZadaniyepoArifmetike5kl.Forum...docx",
        6 => "ZadaniyepoArifmetike6kl.Forum...doc",
        7 => "ZadaniyepoArifmetike7kl.Forum...doc",
        8 => "ZadaniyepoArifmetike8kl.Forum...doc",
        9 => "ZadaniyepoArifmetike9kl.Forum...docx",
    ),
    "arts"=>array(
        10 => "ZadaniyenaIZO10kl.Forum...doc",
        11 => "ZadaniyenaIZO11kl.Forum...doc",
        1 => "ZadaniyenaIZO1kl.Forum...docx",
        2 => "ZadaniyenaIZO2kl.Forum...docx",
        3 => "ZadaniyenaIZO3kl.Forum...docx",
        4 => "ZadaniyenaIZO4kl.Forum...docx",
        5 => "ZadaniyenaIZO5kl.Forum...docx",
        6 => "ZadaniyenaIZO6kl.Forum...doc",
        7 => "ZadaniyenaIZO7kl.Forum...doc",
        8 => "ZadaniyenaIZO8kl.Forum...doc",
        9 => "ZadaniyenaIZO9kl.Forum...doc",
    ),
    "biology"=>array(
        10 => "ZadaniyenaBiolog10kl.Forum...docx",
        11 => "ZadaniyenaBiolog11kl.Forum...docx",
        1 => "ZadaniyenaBiolog1kl.Forum...doc",
        2 => "ZadaniyenaBiolog2kl.Forum...doc",
        3 => "ZadaniyenaBiolog3kl.Forum...doc",
        4 => "ZadaniyenaBiolog4kl.Forum...doc",
        5 => "ZadaniyenaBiolog5kl.Forum...doc",
        6 => "ZadaniyenaBiolog6kl.Forum...doc",
        7 => "ZadaniyenaBiolog7kl.Forum...doc",
        8 => "ZadaniyenaBiolog8kl.Forum...doc",
        9 => "ZadaniyenaBiolog9kl.Forum...doc",
    ),
    "books"=>array(
        10 => "ZadaniyenaKnigolyub10kl.Forum...doc",
        11 => "ZadaniyenaKnigolyub11kl.Forum...doc",
        1 => "ZadaniyenaKnigolyub1kl.Forum...doc",
        2 => "ZadaniyenaKnigolyub2kl.Forum...doc",
        3 => "ZadaniyenaKnigolyub3kl.Forum...doc",
        4 => "ZadaniyenaKnigolyub4kl.Forum...doc",
        5 => "ZadaniyenaKnigolyub5kl.Forum...doc",
        6 => "ZadaniyenaKnigolyub6kl.Forum...doc",
        7 => "ZadaniyenaKnigolyub7kl.Forum...doc",
        8 => "ZadaniyenaKnigolyub8kl.Forum...doc",
        9 => "ZadaniyenaKnigolyub9kl.Forum...doc",
    ),
    "chemistry"=>array(
        10 => "ZadaniyepoKhimii10kl.Forum...doc",
        11 => "ZadaniyepoKhimii11kl.Forum...doc",
        8 => "ZadaniyepoKhimii8kl.Forum...doc",
        9 => "ZadaniyepoKhimii9kl.Forum...doc",
    ),
    "citizen"=>array(
        10 => "ZadaniyenaGrazhdanina10kl.Forum...doc",
        11 => "ZadaniyenaGrazhdanina11kl.Forum...doc",
        1 => "ZadaniyenaGrazhdanina1kl.Forum...doc",
        2 => "ZadaniyenaGrazhdanina2kl.Forum...doc",
        3 => "ZadaniyenaGrazhdanina3kl.Forum...doc",
        4 => "ZadaniyenaGrazhdanina4kl.Forum...doc",
        5 => "ZadaniyenaGrazhdanina5kl.Forum...doc",
        6 => "ZadaniyenaGrazhdanina6kl.Forum...doc",
        7 => "ZadaniyenaGrazhdanina7kl.Forum...doc",
        8 => "ZadaniyenaGrazhdanina8kl.Forum...doc",
        9 => "ZadaniyenaGrazhdanina9kl.Forum...doc",
    ),
    "crossword-english"=>array(
        10 => "ZadaniyenaKrossvordAngl.yaz.10kl.Forum...docx",
        11 => "ZadaniyenaKrossvordAngl.yaz.11kl.Forum...docx",
        1 => "ZadaniyenaKrossvordAngl.yaz.1kl.Forum...docx",
        2 => "ZadaniyenaKrossvordAngl.yaz.2kl.Forum...docx",
        3 => "ZadaniyenaKrossvordAngl.yaz.3kl.Forum...docx",
        4 => "ZadaniyenaKrossvordAngl.yaz.4kl.Forum...docx",
        5 => "ZadaniyenaKrossvordAngl.yaz.5kl.Forum...docx",
        6 => "ZadaniyenaKrossvordAngl.yaz.6kl.Forum...docx",
        7 => "ZadaniyenaKrossvordAngl.yaz.7kl.Forum...docx",
        8 => "ZadaniyenaKrossvordAngl.yaz.8kl.Forum...docx",
        9 => "ZadaniyenaKrossvordAngl.yaz.9kl.Forum...docx",
    ),
    "crossword-german"=>array(
        10 => "ZadaniyenaKrossvordNem.yaz.10kl.Forum...docx",
        11 => "ZadaniyenaKrossvordNem.yaz.11kl.Forum...docx",
        1 => "ZadaniyenaKrossvordNem.yaz.1kl.Forum...docx",
        2 => "ZadaniyenaKrossvordNem.yaz.2kl.Forum...docx",
        3 => "ZadaniyenaKrossvordNem.yaz.3kl.Forum...doc",
        4 => "ZadaniyenaKrossvordNem.yaz.4kl.Forum...doc",
        5 => "ZadaniyenaKrossvordNem.yaz.5kl.Forum...doc",
        6 => "ZadaniyenaKrossvordNem.yaz.6kl.Forum...doc",
        7 => "ZadaniyenaKrossvordNem.yaz.7kl.Forum...doc",
        8 => "ZadaniyenaKrossvordNem.yaz.8kl.Forum...doc",
        9 => "ZadaniyenaKrossvordNem.yaz.9kl.Forum...doc",
    ),
    "english"=>array(
        10 => "ZadaniyenaAnglyskyyazyk10kl.Forum...docx",
        11 => "ZadaniyenaAnglyskyyazyk11kl.Forum...docx",
        1 => "ZadaniyenaAnglyskyyazyk1kl.Forum...doc",
        2 => "ZadaniyenaAnglyskyyazyk2kl.Forum...docx",
        3 => "ZadaniyenaAnglyskyyazyk3kl.Forum...docx",
        4 => "ZadaniyenaAnglyskyyazyk4kl.Forum...docx",
        5 => "ZadaniyenaAnglyskyyazyk5kl.Forum...doc",
        6 => "ZadaniyenaAnglyskyyazyk6kl.Forum...docx",
        7 => "ZadaniyenaAnglyskyyazyk7kl.Forum...docx",
        8 => "ZadaniyenaAnglyskyyazyk8kl.Forum...docx",
        9 => "ZadaniyenaAnglyskyyazyk9kl.Forum...docx",
    ),
    "erudite"=>array(
        10 => "ZadaniyenaErudit10kl.Forum...docx",
        11 => "ZadaniyenaErudit11kl.Forum...docx",
        1 => "ZadaniyenaErudit1kl.Forum...docx",
        2 => "ZadaniyenaErudit2kl.Forum...docx",
        3 => "ZadaniyenaErudit3kl.Forum...docx",
        4 => "ZadaniyenaErudit4kl.Forum...docx",
        5 => "ZadaniyenaErudit5kl.Forum...docx",
        6 => "ZadaniyenaErudit6kl.Forum...docx",
        7 => "ZadaniyenaErudit7kl.Forum...docx",
        8 => "ZadaniyenaErudit8kl.Forum...docx",
        9 => "ZadaniyenaErudit9kl.Forum...docx",
    ),
    "evrica"=>array(
        10 => "ZadaniyenaEvriku10kl.Forum...doc",
        11 => "ZadaniyenaEvriku11kl.Forum...doc",
        1 => "ZadaniyenaEvriku1kl.Forum...doc",
        2 => "ZadaniyenaEvriku2kl.Forum...doc",
        3 => "ZadaniyenaEvriku3kl.Forum...docx",
        4 => "ZadaniyenaEvriku4kl.Forum...docx",
        5 => "ZadaniyenaEvriku5kl.Forum...docx",
        6 => "ZadaniyenaEvriku6kl.Forum...doc",
        7 => "ZadaniyenaEvriku7kl.Forum...doc",
        8 => "ZadaniyenaEvriku8kl.Forum...doc",
        9 => "ZadaniyenaEvriku9kl.Forum...docx",
    ),
    "expert"=>array(
        10 => "ZadaniyenaZnatok10kl.Forum...docx",
        11 => "ZadaniyenaZnatok11kl.Forum...docx",
        1 => "ZadaniyenaZnatok1kl.Forum...docx",
        2 => "ZadaniyenaZnatok2kl.Forum...docx",
        3 => "ZadaniyenaZnatok3kl.Forum...docx",
        4 => "ZadaniyenaZnatok4kl.Forum...docx",
        5 => "ZadaniyenaZnatok5kl.Forum...docx",
        6 => "ZadaniyenaZnatok6kl.Forum...docx",
        7 => "ZadaniyenaZnatok7kl.Forum...docx",
        8 => "ZadaniyenaZnatok8kl.Forum...docx",
        9 => "ZadaniyenaZnatok9kl.Forum...docx",
    ),
    "geography"=>array(
        10 => "ZadaniyenaGeografiyu10kl.Forum...doc",
        11 => "ZadaniyenaGeografiyu11kl.Forum...doc",
        5 => "ZadaniyenaGeografiyu5kl.Forum...doc",
        6 => "ZadaniyenaGeografiyu6kl.Forum...doc",
        7 => "ZadaniyenaGeografiyu7kl.Forum...doc",
        8 => "ZadaniyenaGeografiyu8kl.Forum...doc",
        9 => "ZadaniyenaGeografiyu9kl.Forum...doc",
    ),
    "german"=>array(
        10 => "ZadaniyenaNemetskyyazyk10kl.Forum...docx",
        11 => "ZadaniyenaNemetskyyazyk11kl.Forum...docx",
        1 => "ZadaniyenaNemetskyyazyk1kl.Forum...doc",
        2 => "ZadaniyenaNemetskyyazyk2kl.Forum...doc",
        3 => "ZadaniyenaNemetskyyazyk3kl.Forum...docx",
        4 => "ZadaniyenaNemetskyyazyk4kl.Forum...docx",
        5 => "ZadaniyenaNemetskyyazyk5kl.Forum...docx",
        6 => "ZadaniyenaNemetskyyazyk6kl.Forum...docx",
        7 => "ZadaniyenaNemetskyyazyk7kl.Forum...docx",
        8 => "ZadaniyenaNemetskyyazyk8kl.Forum...docx",
        9 => "ZadaniyenaNemetskyyazyk9kl.Forum...docx",
    ),
    "grammar"=>array(
        10 => "ZadaniyenaGrammatiku10kl.Forum...docx",
        11 => "ZadaniyenaGrammatiku11kl.Forum...docx",
        1 => "ZadaniyenaGrammatiku1kl.Forum...docx",
        2 => "ZadaniyenaGrammatiku2kl.Forum...docx",
        3 => "ZadaniyenaGrammatiku3kl.Forum...docx",
        4 => "ZadaniyenaGrammatiku4kl.Forum...docx",
        5 => "ZadaniyenaGrammatiku5kl.Forum...docx",
        6 => "ZadaniyenaGrammatiku6kl.Forum...docx",
        7 => "ZadaniyenaGrammatiku7kl.Forum...docx",
        8 => "ZadaniyenaGrammatiku8kl.Forum...docx",
        9 => "ZadaniyenaGrammatiku9kl.Forum...docx",
    ),
    "history"=>array(
        10 => "ZadaniyenaIstoriyu10kl.Forum...docx",
        11 => "ZadaniyenaIstoriyu11kl.Forum...docx",
        5 => "ZadaniyenaIstoriyu5kl.Forum...docx",
        6 => "ZadaniyenaIstoriyu6kl.Forum...docx",
        7 => "ZadaniyenaIstoriyu7kl.Forum...docx",
        8 => "ZadaniyenaIstoriyu8kl.Forum...docx",
        9 => "ZadaniyenaIstoriyu9kl.Forum...docx",
    ),
    "literature"=>array(
        7 => "ZadaniyepoLiteratura7kl.Forum...doc",
        9 => "ZadaniyepoLiteratura9kl.Forum...doc",
        10 => "ZadaniyepoLiterature10kl.Forum...doc",
        11 => "ZadaniyepoLiterature11kl.Forum...doc",
        1 => "ZadaniyepoLiterature1kl.Forum...doc",
        2 => "ZadaniyepoLiterature2kl.Forum...doc",
        3 => "ZadaniyepoLiterature3kl.Forum...doc",
        4 => "ZadaniyepoLiterature4kl.Forum...doc",
        5 => "ZadaniyepoLiterature5kl.Forum...doc",
        6 => "ZadaniyepoLiterature6kl.Forum...doc",
        8 => "ZadaniyepoLiterature8kl.Forum...doc",
    ),
    "logic"=>array(
        10 => "Logika10klass.doc",
        11 => "Logika11klass.doc",
        1 => "Logika1klass.doc",
        2 => "Logika2klass.doc",
        3 => "Logika3klass.docx",
        4 => "Logika4klass.docx",
        5 => "Logika5klass.docx",
        6 => "Logika6klass.doc",
        7 => "Logika7klass.doc",
        8 => "Logika8klass.doc",
        9 => "Logika9klass.docx",
    ),
    "math"=>array(
        10 => "ZadaniyepoMatematike10kl.Forum...doc",
        11 => "ZadaniyepoMatematike11kl.Forum...doc",
        1 => "ZadaniyepoMatematike1kl.Forum...doc",
        2 => "ZadaniyepoMatematike2kl.Forum...doc",
        3 => "ZadaniyepoMatematike3kl.Forum...docx",
        4 => "ZadaniyepoMatematike4kl.Forum...docx",
        5 => "ZadaniyepoMatematike5kl.Forum...docx",
        6 => "ZadaniyepoMatematike6kl.Forum...doc",
        7 => "ZadaniyepoMatematike7kl.Forum...doc",
        8 => "ZadaniyepoMatematike8kl.Forum...doc",
        9 => "ZadaniyepoMatematike9kl.Forum...docx",
    ),
    "music"=>array(
        10 => "ZadaniyenaMuzyku10kl.Forum...doc",
        11 => "ZadaniyenaMuzyku11kl.Forum...doc",
        1 => "ZadaniyenaMuzyku1kl.Forum...docx",
        2 => "ZadaniyenaMuzyku2kl.Forum...docx",
        3 => "ZadaniyenaMuzyku3kl.Forum...docx",
        4 => "ZadaniyenaMuzyku4kl.Forum...docx",
        5 => "ZadaniyenaMuzyku5kl.Forum...docx",
        6 => "ZadaniyenaMuzyku6kl.Forum...doc",
        7 => "ZadaniyenaMuzyku7kl.Forum...doc",
        8 => "ZadaniyenaMuzyku8kl.Forum...doc",
        9 => "ZadaniyenaMuzyku9kl.Forum...doc",
    ),
    "outlook-english"=>array(
        10 => "ZadaniyenaKrugozorAnglysky10kl.Forum...docx",
        11 => "ZadaniyenaKrugozorAnglysky11kl.Forum...docx",
        1 => "ZadaniyenaKrugozorAnglysky1kl.Forum...docx",
        2 => "ZadaniyenaKrugozorAnglysky2kl.Forum...docx",
        3 => "ZadaniyenaKrugozorAnglysky3kl.Forum...docx",
        4 => "ZadaniyenaKrugozorAnglysky4kl.Forum...docx",
        5 => "ZadaniyenaKrugozorAnglysky5kl.Forum...docx",
        6 => "ZadaniyenaKrugozorAnglysky6kl.Forum...docx",
        7 => "ZadaniyenaKrugozorAnglysky7kl.Forum...docx",
        8 => "ZadaniyenaKrugozorAnglysky8kl.Forum...docx",
        9 => "ZadaniyenaKrugozorAnglysky9kl.Forum...docx",
    ),
    "outlook-german"=>array(
        10 => "ZadaniyenaKrugozorNemetsky10kl.Forum...docx",
        11 => "ZadaniyenaKrugozorNemetsky11kl.Forum...docx",
        1 => "ZadaniyenaKrugozorNemetsky1kl.Forum...docx",
        2 => "ZadaniyenaKrugozorNemetsky2kl.Forum...docx",
        3 => "ZadaniyenaKrugozorNemetsky3kl.Forum...docx",
        4 => "ZadaniyenaKrugozorNemetsky4kl.Forum...docx",
        5 => "ZadaniyenaKrugozorNemetsky5kl.Forum...docx",
        6 => "ZadaniyenaKrugozorNemetsky6kl.Forum...docx",
        7 => "ZadaniyenaKrugozorNemetsky7kl.Forum...docx",
        8 => "ZadaniyenaKrugozorNemetsky8kl.Forum...docx",
        9 => "ZadaniyenaKrugozorNemetsky9kl.Forum...docx",
    ),
    "physical"=>array(
        10 => "ZadaniyepoFizkulture10kl.Forum...doc",
        11 => "ZadaniyepoFizkulture11kl.Forum...doc",
        1 => "ZadaniyepoFizkulture1kl.Forum...docx",
        2 => "ZadaniyepoFizkulture2kl.Forum...docx",
        3 => "ZadaniyepoFizkulture3kl.Forum...docx",
        4 => "ZadaniyepoFizkulture4kl.Forum...docx",
        5 => "ZadaniyepoFizkulture5kl.Forum...docx",
        6 => "ZadaniyepoFizkulture6kl.Forum...doc",
        7 => "ZadaniyepoFizkulture7kl.Forum...doc",
        8 => "ZadaniyepoFizkulture8kl.Forum...docx",
        9 => "ZadaniyepoFizkulture9kl.Forum...docx",
    ),
    "physics"=>array(
        10 => "ZadaniyepoFizike10kl.Forum...doc",
        11 => "ZadaniyepoFizike11kl.Forum...doc",
        7 => "ZadaniyepoFizike7kl.Forum...doc",
        8 => "ZadaniyepoFizike8kl.Forum...doc",
        9 => "ZadaniyepoFizike9kl.Forum...doc",
    ),
    "programmer"=>array(
        10 => "ZadaniyenaProgrammist10kl.Forum...doc",
        11 => "ZadaniyenaProgrammist11kl.Forum...doc",
        1 => "ZadaniyenaProgrammist1kl.Forum...docx",
        2 => "ZadaniyenaProgrammist2kl.Forum...docx",
        3 => "ZadaniyenaProgrammist3kl.Forum...docx",
        4 => "ZadaniyenaProgrammist4kl.Forum...docx",
        5 => "ZadaniyenaProgrammist5kl.Forum...docx",
        6 => "ZadaniyenaProgrammist6kl.Forum...doc",
        7 => "ZadaniyenaProgrammist7kl.Forum...doc",
        8 => "ZadaniyenaProgrammist8kl.Forum...doc",
        9 => "ZadaniyenaProgrammist9kl.Forum...docx",
    ),
    "puzzle"=>array(
        10 => "ZadaniyenaGolovolomki10kl.Forum...doc",
        11 => "ZadaniyenaGolovolomki11kl.Forum...doc",
        1 => "ZadaniyenaGolovolomki1kl.Forum...doc",
        2 => "ZadaniyenaGolovolomki2kl.Forum...doc",
        3 => "ZadaniyenaGolovolomki3kl.Forum...doc",
        4 => "ZadaniyenaGolovolomki4kl.Forum...doc",
        5 => "ZadaniyenaGolovolomki5kl.Forum...doc",
        6 => "ZadaniyenaGolovolomki6kl.Forum...doc",
        7 => "ZadaniyenaGolovolomki7kl.Forum...doc",
        8 => "ZadaniyenaGolovolomki8kl.Forum...doc",
        9 => "ZadaniyenaGolovolomki9kl.Forum...doc",
    ),
    "rebus"=>array(
        10 => "ZadaniyenaRebus10kl.Forum...doc",
        11 => "ZadaniyenaRebus11kl.Forum...doc",
        1 => "ZadaniyenaRebus1kl.Forum...doc",
        2 => "ZadaniyenaRebus2kl.Forum...doc",
        3 => "ZadaniyenaRebus3kl.Forum...doc",
        4 => "ZadaniyenaRebus4kl.Forum...doc",
        5 => "ZadaniyenaRebus5kl.Forum...doc",
        6 => "ZadaniyenaRebus6kl.Forum...doc",
        7 => "ZadaniyenaRebus7kl.Forum...doc",
        8 => "ZadaniyenaRebus8kl.Forum...doc",
        9 => "ZadaniyenaRebus9kl.Forum...doc",
    ),
    "russian"=>array(
        10 => "ZadaniyenaRusskyyazyk10kl.Forum...doc",
        11 => "ZadaniyenaRusskyyazyk11kl.Forum...doc",
        1 => "ZadaniyenaRusskyyazyk1kl.Forum...doc",
        2 => "ZadaniyenaRusskyyazyk2kl.Forum...doc",
        3 => "ZadaniyenaRusskyyazyk3kl.Forum...doc",
        4 => "ZadaniyenaRusskyyazyk4kl.Forum...doc",
        5 => "ZadaniyenaRusskyyazyk5kl.Forum...doc",
        6 => "ZadaniyenaRusskyyazyk6kl.Forum...doc",
        7 => "ZadaniyenaRusskyyazyk7kl.Forum...doc",
        8 => "ZadaniyenaRusskyyazyk8kl.Forum...doc",
        9 => "ZadaniyenaRusskyyazyk9kl.Forum...doc",
    ),
    "social"=>array(
        10 => "ZadaniyenaObshchestvoznaniye10kl.Forum...docx",
        11 => "ZadaniyenaObshchestvoznaniye11kl.Forum...docx",
        5 => "ZadaniyenaObshchestvoznaniye5kl.Forum...doc",
        6 => "ZadaniyenaObshchestvoznaniye6kl.Forum...doc",
        7 => "ZadaniyenaObshchestvoznaniye7kl.Forum...docx",
        8 => "ZadaniyenaObshchestvoznaniye8kl.Forum...docx",
        9 => "ZadaniyenaObshchestvoznaniye9kl.Forum...docx",
    ),
    "surround"=>array(
        1 => "ZadaniyenaOkruzhayushchymir1kl.Forum...docx",
        2 => "ZadaniyenaOkruzhayushchymir2kl.Forum...docx",
        3 => "ZadaniyenaOkruzhayushchymir3kl.Forum...docx",
        4 => "ZadaniyenaOkruzhayushchymir4kl.Forum...doc",
        5 => "ZadaniyenaPrirodopolzovaniye5kl.Forum...doc",
    ),
    "technology"=>array(
        10 => "ZadaniyenaTekhnologiyu10kl.Forum...doc",
        11 => "ZadaniyenaTekhnologiyu11kl.Forum...doc",
        1 => "ZadaniyenaTekhnologiyu1kl.Forum...docx",
        2 => "ZadaniyenaTekhnologiyu2kl.Forum...docx",
        3 => "ZadaniyenaTekhnologiyu3kl.Forum...docx",
        4 => "ZadaniyenaTekhnologiyu4kl.Forum...docx",
        5 => "ZadaniyenaTekhnologiyu5kl.Forum...doc",
        6 => "ZadaniyenaTekhnologiyu6kl.Forum...docx",
        7 => "ZadaniyenaTekhnologiyu7kl.Forum...doc",
        8 => "ZadaniyenaTekhnologiyu8kl.Forum...doc",
        9 => "ZadaniyenaTekhnologiyu9kl.Forum...doc",
    ),
    "trip"=>array(
        10 => "ZadaniyenaTurpokhod10kl.Forum...doc",
        11 => "ZadaniyenaTurpokhod11kl.Forum...doc",
        1 => "ZadaniyenaTurpokhod1kl.Forum...docx",
        2 => "ZadaniyenaTurpokhod2kl.Forum...docx",
        3 => "ZadaniyenaTurpokhod3kl.Forum...docx",
        4 => "ZadaniyenaTurpokhod4kl.Forum...docx",
        5 => "ZadaniyenaTurpokhod5kl.Forum...docx",
        6 => "ZadaniyenaTurpokhod6kl.Forum...docx",
        7 => "ZadaniyenaTurpokhod7kl.Forum...docx",
        8 => "ZadaniyenaTurpokhod8kl.Forum...docx",
        9 => "ZadaniyenaTurpokhod9kl.Forum...doc",
    )
);

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

