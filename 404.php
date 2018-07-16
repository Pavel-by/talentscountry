<!DOCTYPE html>
<html>

<head>
    <title>404 - Страница не найдена | &laquo;Отличник&raquo; - всероссийский конкурс</title>
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
        <div class="content">
            <div class="limit-block">
                <div class="flex-block flex-row flex-top flex-left">
                    <?php
                    include("information-menu.php")
                    ?>
                        <div>
                            <p>К сожалению, такой страницы нет на нашем сайте</p>
                        </div>
                </div>
            </div>
        </div>
        <?php
        include("footer.html");
    ?>
</body>

</html>