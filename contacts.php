<!DOCTYPE html>
<html>

<head>
    <title>Контакты | &laquo;Страна талантов&raquo; - всероссийский конкурс</title>
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
                    <h1 class="page-title">Наши контакты</h1>
                    <p class="bold">Наш почтовый адрес:</p>
                    <p class="form-hint">659321, Алтайский край, г.Бийск, а/я 89</p>
                    <divider></divider>

                    <p class="bold">Телефон службы поддержки:</p>
                    <p class="form-hint">+7 (923) 00 483 02<br>+7 (903) 949 55 41</p>
                    <divider></divider>

                    <p class="bold">Наш сайт в интернете:</p>
                    <p class="form-hint"><a href="http://stranatalantow.ru/">http://stranatalantow.ru/</a></p>
                    <divider></divider>

                    <p class="bold">E-mail поддержки:</p>
                    <p class="form-hint">help@stranatalantow.ru</p>

                </div>
            </div>
        </div>
    </div>
    <?php
    include("footer.html");
    ?>
</body>

</html>