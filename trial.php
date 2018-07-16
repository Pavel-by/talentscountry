<!DOCTYPE html>
<html>

<head>
    <title>Пробные задания | &laquo;Страна талантов&raquo; - всероссийский конкурс</title>
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
                <div style="width: 100%">
                    <h1 class="page-title">Пробные задания</h1>
                    <p>Специально для Вас мы сделали подборку заданий, что бы Вы смогли оценить уровень сложности наших олимпиад.</p>
                    <p>Скачать задания можно по <a href="files/trial/trial-archive.zip">ссылке</a> </p>
                </div>
            </div>
        </div>
    </div>
    <?php
    include("footer.html");
    ?>
</body>

</html>