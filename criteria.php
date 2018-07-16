<!DOCTYPE html>
<html>

<head>
    <title>Критерии | &laquo;Страна талантов&raquo; - всероссийский конкурс</title>
    <meta charset="utf-8">
    <link type="text/css" rel="stylesheet" href="style.css?date=<?php echo filemtime("styles/style.css"); ?>">
    <script type="text/javascript" src="scripts/js/jquery.js"></script>
    <meta name = "viewport" content = "width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.ico">
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
                    <h2>Распределение грамот:</h2>
                    <ul class="content-ul">
                        <li>15 баллов – Грамота 1 степени</li>
                        <li>14 баллов – Грамота 2 степени</li>
                        <li>13 баллов – Грамота 3 степени</li>
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