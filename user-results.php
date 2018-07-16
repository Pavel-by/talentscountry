<?php
    include('scripts/check-autorization.php');
    include('scripts/update-userinfo.php');
    require_once 'scripts/error-script.php';
    require_once 'system/constants.php';
    include( 'system/db.php' );
?>
<!DOCTYPE html>
<html>

<head>
    <title>Результаты | Личный кабинет | &laquo;Страна талантов&raquo; - всероссийский конкурс</title>
    <meta charset="utf-8">
    <link type="text/css" rel="stylesheet" href="style.css?date=<?php echo filemtime("styles/style.css"); ?>">
    <script type="text/javascript" src="scripts/js/jquery.js"></script>
    <script type="text/javascript" src="/module/message.js"></script>
    <meta name = "viewport" content = "width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.ico">
</head>

<body>
    <?php
    include("header.php");
    ?>
    <div class="flex-block flex-row flex-top flex-center page-limiter">
        <?php
        include("user-menu.php")
        ?>
        <div class="content">
            <div class="limit-block">
                <div>
                    <h1 class="page-title">Скачать результаты конкурса</h1>
                    <?php
                        if (constants::PAYMENT_FOR_RESULTS and $_SESSION['usertype'] != 1){
                            echo '<p class="important-text">Для скачивания результатов необходимо оплатить участие.</p>';
                        }
                        else {
                            if ( !$link ) {
                                echo "<p class='important-text'>Отсутствует подключение к базе данных. Пожалуйста, попробуйте позже.</p>";
                            }
                            else {
                                $userkey = $_SESSION['userkey'];
                                $sql = mysqli_query( $link, "SELECT COUNT(*) FROM `results` WHERE `forId`=(SELECT `id` FROM `users` WHERE `userkey`='$userkey')" );
                                if (mysqli_fetch_array( $sql )['COUNT(*)'] == 0) {
                                    echo "<p class='important-text'>Результаты еще не доступны</p>";
                                }
                                else {
                                    echo "<div class=\"download\"><a href=\"scripts/get-result-table.php\">Скачать таблицу результатов</a></div>"
                                        . "<div class=\"download\"><a href='scripts/get-result-archive.php'>Скачать наградные материалы</a></div>"
                                        . "<p class='important-text'>Пожалуйста, проверьте правильность напечатанной на бланках информации. Если название школы не помещается на бланке и выходит за пределы строки, зайдите в личный кабинет во вкладку <a href='user-info.php'>информация</a> и измените название школы на сокращенный вариант, затем заново скачайте наградные материалы. Например, вместо \"КГБОУ Бийский лицей-интернат Алтайского края\" можно написать \"КГБОУ БЛИАК\". Также Вы можете <a href='images/diploma/diploma.rar'>скачать</a> пустые грамоты и заполнить их вручную.";
                                }
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php include("footer.html"); ?>
    </body>

    </html>