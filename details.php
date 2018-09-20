<!DOCTYPE html>
<html>

<head>
    <title>Реквизиты | &laquo;Страна талантов&raquo; - всероссийский конкурс</title>
    <meta charset="utf-8">
    <link type="text/css" rel="stylesheet" href="style.css?date=<?php echo filemtime("styles/style.css"); ?>">
    <script type="text/javascript" src="scripts/js/jquery.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                <h1 class="page-title">Наши реквизиты</h1>
                <div class="card">
                    <p><b>ООО «Страна талантов»</b><br>
                        ИНН 2204061118,<br>
                        КПП 220401001<br>
                        БАНК: ОАО КБ «ФорБанк»<br>
                        БИК 040173743<br>
                        Кор.счет № 30101810200000000743<br>
                        р.с. № 40702810106000000463</p>
                </div>
                <h2>Внимание!</h2>
                <p>Плательщикам иностранных граждан (Белоруссия, Монголия, Казахстан) просим в платежных документах код
                   валютной операции указывать 20100!!!</p>
                <div class="important-text"><p>Данные реквизиты, во избежание ошибок, лучше распечатать</p>
                    <div class="download">
                        <a href="files/rekviziti.docx">Реквизиты.docx</a>
                    </div>
                </div>
                <p>Денежный перевод можно сделать через любое отделение Сбербанка, Коммерческого банка или Почты
                   России.</p>
            </div>
        </div>
    </div>
</div>
<?php
include("footer.html");
?>
</body>

</html>