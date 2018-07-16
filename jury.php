<!DOCTYPE html>
<html>

<head>
    <title>Жюри | &laquo;Страна талантов&raquo; - всероссийский конкурс</title>
    <meta charset="utf-8">
    <link type="text/css" rel="stylesheet" href="style.css?date=<?php echo filemtime("styles/style.css"); ?>">
    <script type="text/javascript" src="scripts/js/jquery.js"></script>
    <meta name = "viewport" content = "width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.ico">
    <style type="text/css">
        h3.teacher-name {
            padding-top: 10px;
            margin-top: 0;
        }
    </style>
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
                <div style="width: 100%;">
                    <h1 class="page-title">Наши Уважаемые учителя</h1>
                    <div class="card">
                        <h3 class="teacher-name">Точилкин Егор Александрович</h3>
                        <p class="form-hint">учитель истории и обществознание в МАОУ «СОШ №12 с УИОП» г.Стерлитамак</p>
                    </div>
                    <div class="card">
                        <h3 class="teacher-name">Химикова Ольга Измайловна</h3>
                        <p class="form-hint">учитель биологии и химии в Сургутском естественнонаучном лицее</p>
                    </div>
                    <div class="card">
                        <h3 class="teacher-name">Полякова Евгения Владимировна</h3>
                        <p class="form-hint">учитель начальных классов в МКОУ СОШ № 14 Ставропольский край</p>
                    </div>
                    <div class="card">
                        <h3 class="teacher-name">Топчей Татьяна Ивановна</h3>
                        <p class="form-hint">методист ГБПОУ РО «ДТКИиБ» г.Ростов-на-Дону</p>
                    </div>
                    <div class="card">
                        <h3 class="teacher-name">Богданова Ольга Ивановна</h3>
                        <p class="form-hint"> учитель русского языка МОУ СШ № 111 г.Волгоград</p>
                    </div>
                    <div class="card">
                        <h3 class="teacher-name">Чернышова Надежда Георгиевна</h3>
                        <p class="form-hint">учитель начальных классов МБОУ СОШ № 19 Краснодарский край</p>
                    </div>
                    <div class="card">
                        <h3 class="teacher-name">Мирошникова Ангелина Вячеславовна</h3>
                        <p class="form-hint">учитель иностранного языка МБОУ «ЦО с.Усть-белая»</p>
                    </div>
                    <div class="card">
                        <h3 class="teacher-name">Бадмацыренова Оксана Владимировна</h3>
                        <p class="form-hint">замдир по УВР МБОУ Кяхтинская СОШ № 2</p>
                    </div>
                    <div class="card">
                        <h3 class="teacher-name">Лыфарь Наталья Анатольевна</h3>
                        <p class="form-hint">учитель химии МБОУ СОШ № 1 г.Нефтеюганск</p>
                    </div>
                    <div class="card">
                        <h3 class="teacher-name">Пчельникова Наталия Юрьевна</h3>
                        <p class="form-hint">учитель начальных классов МБОУ СШ № 70 г.Липецк</p>
                    </div>
                    <div class="card">
                        <h3 class="teacher-name">Короткова Валентина Николаевна</h3>
                        <p class="form-hint">замдир по УВР МБОУ СОШ № 2 г.Карасук</p>
                    </div>
                    <div class="card">
                        <h3 class="teacher-name">Плетюхина Галина Юрьевна</h3>
                        <p class="form-hint">учитель английского языка МОАУ СОШ № 10 г.Оренбург</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    include("footer.html");
    ?>
</body>

</html>