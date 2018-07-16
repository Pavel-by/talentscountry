<!DOCTYPE html>
<html>

<head>
    <title>Реквизиты | &laquo;Страна талантов&raquo; - всероссийский конкурс</title>
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
                    <h1 class="page-title">Наши реквизиты</h1>
                    <div class="card">
                        <p><b>ИНН</b> 2204060795<br><b>КПП</b> 220401001<br><b>Расчетный счет</b> 40702810102450042714<br> Алтайское отделение №8644 ПАО Сбербанк г.Барнаул<br><b>БИК</b> 040173604<br><b>корсчет</b> 30101810200000000604
                            <br/><br/>
                            <b>Получатель платежа:</b><br>ООО «Страна талантов»<br>
                            <b>Назначение платежа:</b><br>Участие в конкурсе</p>
                    </div>
                    <h2>Внимание!</h2>
                    <p>Плательщикам иностранных граждан (Белоруссия, Монголия, Казахстан) просим в платежных документах код валютной операции указывать 20100!!!</p>
                    <div class="important-text"><p>Данные реквизиты, во избежание ошибок, лучше распечатать</p>
                        <div class="download">
                            <a href="files/rekviziti.docx">Реквизиты.docx</a>
                        </div>
                    </div>
                    <p>Денежный перевод можно сделать через любое отделение Сбербанка, Коммерческого банка или Почты России.</p>
                </div>
            </div>
        </div>
    </div>
    <?php
    include("footer.html");
    ?>
</body>

</html>