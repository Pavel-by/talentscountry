<?php
    @session_start();
    include_once('system/db.php');

    if (isset($_SESSION['userkey']) and $link){
        $userkey = $_SESSION['userkey'];
        $sql = mysqli_query($link, "SELECT `text` FROM `comments` WHERE `userkey`='$userkey'");

        $text = '';
        if ($sql and $sql = mysqli_fetch_array($sql)){
            $text = $sql['text'];
        }
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>Отзывы | &laquo;Страна талантов&raquo; - всероссийский конкурс</title>
    <meta charset="utf-8">
    <link type="text/css" rel="stylesheet" href="style.css?date=<?php echo filemtime("styles/style.css"); ?>">
    <script type="text/javascript" src="scripts/js/jquery.js"></script>
    <meta name = "viewport" content = "width=device-width, initial-scale=1">
    <script type="text/javascript" src="/module/message.js"></script>
    <link rel="shortcut icon" href="images/favicon.ico">
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function(){
            var form = document.getElementById('comment-form');
            form.addEventListener('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url: 'scripts/comments-script.php',
                    type: 'GET',
                    dataType: 'JSON',
                    data: $(form).serialize(),
                    processData: false,
                    contentType: false,
                    success: function(d){
                        if (d.error){
                            var mes = "Ошибка при обработке данных на сервере";
                            if (d.texterror != false && typeof d.texterror !== undefined && d.texterror != null){
                                mes = d.texterror;
                            }
                            Message.create({header: "Ошибка", text: mes});
                        }
                        else {
                            window.location.reload();
                        }
                    },
                    error: function(){
                        var mes = "Ошибка при обработке данных на сервере";
                        Message.create({header: "Ошибка", text: mes});
                    }
                });
            });
        });
    </script>
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
                    <div style="width: 100%;">
                    <h1 class="page-title">Отзывы</h1>
                        <form id="comment-form" class="card <?php if (!isset($_SESSION['usertype']) or $_SESSION['usertype'] != 1) echo 'hidden'; ?>">
                            <h3>Добавить отзыв</h3>
                            <div>
                                <p class='important-text'>Внимание! Один пользователь может добавить только ОДИН отзыв. Потом можно лишь редактировать предыдущий.</p>
                                <textarea name='text' class="text-input" style="height: 200px"><?php echo $text; ?></textarea>
                            </div>
                            <div>
                                <input type='submit' value='<?php echo (strlen($text) == 0 ? "Добавить отзыв" : "Обновить"); ?>' class='submit-button'>
                                <input type="<?php echo (strlen($text) == 0 ? "hidden" : "submit"); ?>" value="Удалить отзыв" class="submit-button" onclick="$('textarea[name=text]').val('');">
                            </div>
                        </form>
                        <?php
                            if (isset($_SESSION['usertype'])){
                                if ($_SESSION['usertype'] != 1){
                                    echo "<p class='important-text'>Оставлять отзывы могут только пользователи, оплатившие участие. Оплатить участие можно в разделе <a href='user-payment.php'>оплата</a>.</p>";
                                }
                            }
                            else {
                                echo "<p class='important-text'><a href='registration.php'>Зарегистрируйтесь</a> или <a href='login.php?next=comments.php'>войдите</a>, чтобы оставить отзыв.";
                            }
                            if ($link){
                                $sql = mysqli_query($link, "SELECT * FROM `comments` ORDER BY `id` DESC");

                                if ($sql){
                                    $count = 0;
                                    while ($comment = mysqli_fetch_array($sql)){
                                        $count++;
                                        $comment['text'] = '<p>' . preg_replace('/(\r|\n|\r\n)+/m', '</p><p>', $comment['text']) . '</p>';
                                        $comment['text'] = preg_replace('/(<p><\/p>)/m', '', $comment['text']);
                                        $date = (new DateTime($comment['date']))->format('d-m-Y');


                                        echo "<div class='card'>"
                                            . "<h3 class='comment-name'>" . $comment['name'] . "</h3>"
                                            . "<p class='comment-date'>" . $date . "</p>"
                                            . "<p class='comment-body'>" . $comment['text'] . "</p>"
                                            . "</div>";
                                    }
                                    if ($count == 0) {
                                        echo "<p class='card'>Нет отзывов</p>";
                                    }
                                }
                                else {
                                    echo "<p class='important-text'>Отсутствует подключения к базе данных.</p>";
                                }
                            }
                            else {
                                echo "<p class='important-text'>Отсутствует подключения к базе данных.</p>";
                            }
                        ?>

                    </div>
                </div>
            </div>
        <?php
        include("footer.html");
    ?>
</body>
</html> 