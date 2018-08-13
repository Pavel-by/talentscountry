<!DOCTYPE html>
<html>

<head>
    <title>Главная | &laquo;Страна талантов&raquo; - всероссийский конкурс</title>
    <meta charset="utf-8">
    <link type="text/css" rel="stylesheet" href="style.css?date=<?php echo filemtime("styles/style.css"); ?>">
    <script type="text/javascript" src="scripts/js/jquery.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.ico">
</head>

<body>
<div style="position: relative;">
    <?php
    include("header.php");
    ?>
    <div class="flex-block flex-row flex-top flex-center page-limiter">
        <?php
        include("information-menu.php");
        ?>
        <div class="content">
            <div class="limit-block">
                <h3>Уважаемые учителя и школьные организаторы!<br>
                    Оргкомитет «Страна талантов» приглашает принять участие
                    в цикле Международных олимпиад для всех учащихся
                </h3>
                <p class="quote right">Многие вещи нам непонятны не потому, что наши понятия слабы, а потому, что сии
                    вещи не
                    входят в круг наших понятий.<br>
                    Козьма Прутков
                </p>
                <h3>Олимпиады проводятся по следующим дисциплинам:</h3>
                <ul>
                    <li>
                        <p>1-е классы:<br>Обучение грамоте, Окружающий мир, Математика.</p>
                    </li>
                    <li><p>2-4-е классы:<br>
                            Русский язык, Окружающий мир, Математика, Английский язык, Немецкий язык, Литературное
                            чтение.
                        </p>
                    </li>
                    <li><p>5-11-е классы:<br>
                            Русский язык, Литература, Английский язык, Немецкий язык, Математика, Биология, История,
                            Обществознание. География, викторина Всезнайка, Головоломки.
                        </p>
                    </li>
                    <li><p>
                            7-11-е классы:<br>
                            Физика.
                        </p>
                    </li>
                    <li><p>
                            8-11-е классы: <br>
                            Химия.
                        </p>
                    </li>
                </ul>

                <p>К участию в олимпиаде допускаются (без предварительного отбора) учащиеся 1–11х классов,
                    оплатившие организационный взнос.</p>
                <p class="bold">Предлагаем всем школьникам  посоревноваться между собой за звание самого знающего и одаренного!</p>

                <h3>Сроки проведения олимпиады:</h3>
                <div class="card">
                    <p class="flex-block flex-between flex-row flex-middle">
                        <span>Задания и Бланки ответов будут размещены на сайте в личных кабинетах</span>
                        <span>
                            <span class="inline-card">01</span>
                            <span class="inline-card">09</span>
                            <span class="inline-card">2018</span>
                        </span>
                    </p>
                    <p class="flex-block flex-between flex-row flex-middle">
                        <span>Провести олимпиаду и отправить материалы работ необходимо до</span>
                        <span>
                            <span class="inline-card">20</span>
                            <span class="inline-card">10</span>
                            <span class="inline-card">2018</span>
                        </span>
                    </p>
                    <p class="flex-block flex-between flex-row flex-middle">
                        <span>Итоги олимпиад будут размещены на сайте </span>
                        <span>
                            <span class="inline-card">01</span>
                            <span class="inline-card">11</span>
                            <span class="inline-card">2018</span>
                        </span>
                    </p>
                    <p class="flex-block flex-between flex-row flex-middle">
                        <span>Наградные материалы будут отправлены до </span>
                        <span>
                            <span class="inline-card">01</span>
                            <span class="inline-card">11</span>
                            <span class="inline-card">2018</span>
                        </span>
                    </p>
                </div>

                <h3>Стоимость участия:</h3>
                <p class="bold">Стоимость участия - 60 рублей за одного участника по одному предмету. Из них:</p>
                <ul class="content-ul">
                    <li><b>55 рублей</b> – направляется в оргкомитет организаторам олимпиады</li>
                    <li><b>5 рублей</b> - остаются в школе на сопутствующие организационные расходы</li>
                </ul>
                <p>Каждый предмет – самостоятельная олимпиада (с отдельным сертификатом).</p>

                <h3>Награждение:</h3>
                <ul class="content-ul">
                    <li>Все участники, без исключения, получат Сертификаты участников, а наиболее отличившиеся по итогам олимпиад - Дипломы I, II, III степени, подарки и призы.
                    </li>
                    <li>Всем учителям,  задействованным в подготовке и проведении олимпиады в школах, будут выданы Благодарственные грамоты.
                    </li>
                    <li>Все школы, представившие к участию более 15-ти человек, получат Благодарственные письма.
                    </li>
                </ul>
                <div class="center">
                    <h3>Спешите, регистрация уже началась!</h3>
                    <div class="center">
                        <a href="registration.php" class="bright-button">Зарегистрироваться</a>
                    </div>
                    <hr>

                    <div class="center">
                        <p class="bold">Скачать дополнительные материалы:</p>
                        <div class="download">
                            <img src="images/download.png">
                            <a href="files/welcome_strana_talantov.docx">Скачать приглашение</a>
                        </div>
                        <div class="download">
                            <img src="images/download.png">
                            <a href="files/prikaz_strana.docx">Скачать приказ о проведении</a>
                        </div>
                        <div class="download">
                            <img src="images/download.png">
                            <a href="files/reglament_strana_talantov.docx">Скачать регламент конкурса</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include("footer.html");
        ?>
    </div>
</div>
</body>

</html>