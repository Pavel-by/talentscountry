<!DOCTYPE html>
<html>

<head>
    <title>О конкурсе | &laquo;Страна талантов&raquo; - всероссийский конкурс</title>
    <meta charset="utf-8">
    <link type="text/css" rel="stylesheet" href="style.css?date=<?php echo filemtime("styles/style.css"); ?>">
    <script type="text/javascript" src="scripts/js/jquery.js"></script>
    <meta name = "viewport" content = "width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.ico">
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/module/metrika.php"); ?>
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
                <div class="flex-block flex-row flex-top flex-left">
                        <div>
                            <h1 class="page-title">Об олимпиаде</h1>
                            <h2>Цель олимпиады</h2>
                            <ul class="content-ul">
                                <li>привлечь как можно больше учеников к решению математических задач, показать каждому школьнику, что обдумывание задачи может быть делом живым, увлекательным, и даже веселым!</li>
                                <li>воспитать у обучающихся любовь к русскому языку, как к языку одной из великих культур мира, научить бережно относиться к слову. Пробудить интерес к истории языка, стремление совершенствовать свою грамотность, расширять
                                    словарный запас, осознанно применять изученные правила.</li>
                            </ul>
                            <p><b>Задания конкурса</b> составлены так, чтобы каждый ученик нашел для себя интересные и доступные вопросы. Мы постоянно работаем над качеством предлагаемых заданий, стремимся сделать процесс участия в наших конкурсах наиболее
                                доступным и интересным.</p>
                            <p><b>Каждому ученику</b> любопытно познать самого себя, любопытно испытать себя в новом конкурсе и совершенно неважно, какая на данный момент у конкретного школьника успеваемость. Ограничений нет, предварительного отбора тоже
                                нет. Независимо от результата абсолютно все участники получат «<b>Сертификат участника</b>».</p>
                            <h2>Плюсы проекта: </h2>
                            <ol class="content-ul">
                                <li>«Сертификаты участника» – всем участникам без ограничения;</li>
                                <li>Денежные призы – всем отличившимся финалистам конкурса;</li>
                                <li>Педагоги, задействованные в подготовке и проведении конкурса, получат Благодарственные грамоты</li>
                            </ol>
                            <h2>Мы гарантируем!</h2>
                            <ol class="content-ul">
                                <li>Точный учет поступающих заявок. </li>
                                <li>Корректность составленных заданий. </li>
                                <li>Пунктуальное соблюдение сроков проверки выполненных работ. </li>
                                <li>Непредвзятое судейство. </li>
                                <li>Тщательный анализ присланных работ. </li>
                                <li>Возможность бесплатного участия для детей из детских домов. </li>
                                <li>100% гарантия возврата средств за ненадлежащее выполнение своих обязательств</li>
                            </ol>
                            <p><a href="registration.php">Присоединяйтесь!</a></p>
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