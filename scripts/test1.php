<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript" src="/scripts/js/jquery.js"></script>
    <script type="text/javascript" src="/module/message.js?time=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'] . '/module/message.js'); ?>"></script>
    <title>Document</title>
</head>
<body>
    <script type="text/javascript">
        var mes = new Message({header: "header", text: "text", closeable: false}).show();
    </script>
</body>
</html>

<!--?php
    include($_SERVER['DOCUMENT_ROOT'] . '/system/db.php');
    $sql = mysqli_query($link, "SELECT * FROM `excel-emails1` WHERE `email` LIKE '%@rambler.%'");
    $f = fopen($_SERVER['DOCUMENT_ROOT'] . '/rambler.txt', 'w');
    while ($line = mysqli_fetch_array($sql)){
        fwrite($f, $line['email'] . "\n");
    }
    fclose($f);
?-->