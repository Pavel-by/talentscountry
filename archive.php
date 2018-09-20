<!DOCTYPE html>
<html>

<head>
    <title>Архив | &laquo;Страна талантов&raquo; - всероссийский конкурс</title>
    <meta charset="utf-8">
    <link type="text/css" rel="stylesheet" href="style.css?date=<?php echo filemtime("styles/style.css"); ?>">
    <script type="text/javascript" src="scripts/js/jquery.js"></script>
    <meta name = "viewport" content = "width=device-width, initial-scale=1">
    <script type="text/javascript" src="/module/metrika.js"></script>
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
                    <h1 class="page-title">Архив</h1>
                    <h3>2017</h3>
                    <p><a href="/files/archive/2017.xlsx">Призеры 2017</a></p>

                    <h3>2016</h3>
                    <p><a href="files/archive/1%20place,%202016.docx">Призеры 1 место</a></p>
                    <p><a href="files/archive/2%20place,%202016.docx">Призеры 2 место</a></p>
                    <p><a href="files/archive/3%20place,%202016.docx">Призеры 3 место</a></p>

                    <h3>2015</h3>
                    <p><a href="files/archive/2015.xlsx">Результаты 2015 года</a></p>

                    <h3>2014</h3>
                    <p><a href="files/archive/2014.xlsx">Результаты 2014 года</a></p>
                </div>
            </div>
        </div>
    </div>
    <?php
    include("footer.html");
    ?>
</body>

</html>