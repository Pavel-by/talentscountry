<!DOCTYPE html>
<html>

<head>
    <title>Критерии | &laquo;Страна талантов&raquo; - всероссийский конкурс</title>
    <meta charset="utf-8">
    <link type="text/css" rel="stylesheet" href="style.css?date=<?php echo filemtime("styles/style.css"); ?>">
    <script type="text/javascript" src="scripts/js/jquery.js"></script>
    <meta name = "viewport" content = "width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.ico">
    <script type="text/javascript" src="/module/metrika.js"></script>
</head>

<body>
    <?php
        include("header.php");
    ?>
    <div class="flex-block flex-row flex-top flex-center page-limiter">
        <?php
        include("information-menu.php")
        ?>
        <div class="content">
            <div class="limit-block">
                <div>
                    <h1 class="page-title">Критерии</h1>
                    <p>Сертификат выдается каждому участнику, независимо от набранных баллов</p>
                    <h2>Распределение дипломов:</h2>
                    <ul class="content-ul">
                        <li>20 баллов – Диплом 1 степени</li>
                        <li>19 баллов – Диплом 2 степени</li>
                        <li>18 баллов – Диплом 3 степени</li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
    <?php
    include("footer.html");
    ?>
</body>

</html>