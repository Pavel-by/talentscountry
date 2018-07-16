<!DOCTYPE html>
<html>

<head>
    <title>Главная | &laquo;Страна талантов&raquo; - всероссийский конкурс</title>
    <meta charset="utf-8">
    <link type="text/css" rel="stylesheet" href="style.css?date=<?php echo filemtime("styles/style.css"); ?>">
    <script type="text/javascript" src="scripts/js/jquery.js"></script>
    <meta name = "viewport" content = "width=device-width, initial-scale=1">
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
                    <div class="center" style="height: 500px; background-image: url('/images/main-background.jpg'); background-position: center; border-radius: 10px; padding-top: 115px; background-size: cover; box-shadow: 0 0 70px #ffffff inset;">
                        <h1 style="color: white; text-shadow: 0 0 40px rgba(0,0,0,1); font-size: 40px;">Страна талантов</h1>
                        <!--p class="quote">Даже в обществе двух человек я непременно найду, чему у них поучиться.
                            Достоинствам их я постараюсь подражать, а на их недостатках сам буду учиться. Конфуций</p-->
                    </div>
                    <h3>Олимпиады проводятся по следующим дисциплинам:</h3>
                    <div>
                        <div class="flex-block flex-row flex-between flex-stretch flex-wrap">
                            <div class="flex-half">
                                <div class="card card-full-height bright-block">
                                    <p class="bold">1 классы:</p>
                                    <p>Обучение грамоте, Окружающий мир, Математика.</p>
                                </div>
                            </div>
                            <div class="flex-half">
                                <div class="card card-full-height bright-block">
                                    <p class="bold">2-4 классы:</p>
                                    <p>Русский язык, Окружающий мир, Математика, Английский язык,
                                        Немецкий язык, Литературное чтение.</p>
                                </div>
                            </div>
                            <div class="flex-half">
                                <div class="card card-full-height bright-block">
                                    <p class="bold">5-11 классы:</p>
                                    <p>Русский язык, Литература, Английский язык, Немецкий язык,
                                        Математика, Биология, История, Обществознание. География,
                                        викторина Эрудит, Головоломки.</p>
                                </div>
                            </div>
                            <div class="flex-half">
                                <div class="card card-full-height bright-block">
                                    <p class="bold">7-11 классы:</p>
                                    <p>Физика.</p>
                                </div>
                            </div>
                            <div class="flex-half">
                                <div class="card card-full-height bright-block">
                                    <p class="bold">8-11 классы:</p>
                                    <p>Химия.</p>
                                </div>
                            </div>
                            <div class="flex-half">
                                <div class="card card-full-height bright-block">
                                    <p class="bold">Оригинальные задания с 1 по 11 классы:</p>
                                    <p>Труд, Музыка, Физкультура, ИЗО, Грамматика (пропуски букв в словах),
                                        Книголюб, Биолог, Гражданин, Турпоход, Программист, Ребус (задачи по цепному принципу),
                                        Эврика (арифметика), Кроссворды и Кругозор (страноведение) по английскому и немецкому
                                        языкам.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p>К участию в олимпиаде допускаются (без предварительного отбора) учащиеся 1–11х классов,
                        оплатившие организационный взнос.</p>
                    <hr>

                    <h3>Сроки проведения олимпиады:</h3>
                    <ul class="content-ul">
                        <li><b>Задания и Бланки ответов</b> будут размещены на сайте в личных
                            кабинетах 05.04.2018г.</li>
                        <li><b>Провести олимпиаду и отправить материалы работ</b> необходимо до 25.04.2018г.</li>
                        <li><b>Итоги</b> олимпиады будут размещены на сайте 10.05.2018г.</li>
                        <li><b>Наградные</b> материалы будут отправлены до 15.05.2018г.</li>
                    </ul>
                    <hr>

                    <h3>Стоимость участия:</h3>
                    <p class="bold">Стоимость участия - 60 рублей за одного участника по одному предмету. Из них:</p>
                    <ul class="content-ul">
                        <li><b>55 рублей</b> – направляется в оргкомитет организаторам олимпиады</li>
                        <li><b>5 рублей</b> - остаются в школе на сопутствующие организационные расходы</li>
                    </ul>
                    <p>Каждый предмет – самостоятельная олимпиада (с отдельным сертификатом).</p>
                    <hr>

                    <h3>Награждение:</h3>
                    <ul class="content-ul">
                        <li>Все участники, без исключения, получат Сертификаты участников, а наиболее
                            отличившиеся по итогам олимпиад – Грамоты I, II, III степени, подарки и призы.</li>
                        <li>Всем учителям,  задействованным в подготовке и проведении олимпиады в школах,
                            будут выданы Благодарственные грамоты.</li>
                        <li>Все школы, представившие к участию более 15-ти человек, получат
                            Благодарственные письма.</li>
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
                                <a href="files/welcome.docx">Скачать приглашение</a>
                            </div>
                            <div class="download">
                                <img src="images/download.png">
                                <a href="files/prikaz.rar">Скачать приказ о проведении</a>
                            </div>
                            <div class="download">
                                <img src="images/download.png">
                                <a href="files/reglament.docx">Скачать регламент конкурса</a>
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