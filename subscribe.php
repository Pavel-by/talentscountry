<!DOCTYPE html>
<html>

<head>
    <title>Подписка | &laquo;Страна талантов&raquo; - всероссийский конкурс</title>
    <meta charset="utf-8">
    <link type="text/css" rel="stylesheet"
          href="style.css?date=<?php echo filemtime( "styles/style.css" ); ?>">
    <script type="text/javascript" src="scripts/js/jquery.js"></script>
    <script type="text/javascript" src="/module/message.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.ico">
    <script type="text/javascript" src="/module/metrika.js"></script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("subscribe-form").addEventListener("submit", function (e) {
                e.preventDefault();
                var form = this;
                if (form.getElementsByClassName('email')[0].value.length == 0) {
                    return;
                }
                var data = $(form).serializeArray();
                data.push({name: "type", value: "subscribe"});
                data = $.param(data);
                $.ajax({
                    url: 'scripts/subscribe-script.php',
                    type: 'GET',
                    data: data,
                    dataType: "JSON",
                    success: function (d) {
                        if (d.error) {
                            Message.create({
                                header: "Ошибка",
                                text: "При попытке оформить подписку произошла ошибка. Попробуйте позже"
                            });
                        } else {
                            Message.create({header: "Успех", text: 'Вы успешно оформили подписку'});
                        }
                    },
                    error: function (d) {
                        alert(d);
                        Message.create({
                            header: "Ошибка",
                            text: "При попытке оформить подписку произошла ошибка. Попробуйте позже"
                        });
                    }
                });
            });

            document.getElementById("unsubscribe-form").addEventListener("submit", function (e) {
                e.preventDefault();
                var form = this;
                if (form.getElementsByClassName('email')[0].value.length == 0) {
                    return;
                }
                var data = $(form).serializeArray();
                data.push({name: "type", value: "unsubscribe"});
                data = $.param(data);
                $.ajax({
                    url: 'scripts/subscribe-script.php',
                    type: 'GET',
                    data: data,
                    dataType: "JSON",
                    success: function (d) {
                        if (d.error) {
                            Message.create({
                                header: "Ошибка",
                                text: "При попытке отписки произошла ошибка"
                            });
                        } else {
                            Message.create({
                                header: "Успех",
                                text: 'Вы успешно отписались от рассылки'
                            });
                        }
                    },
                    error: function (d) {
                        alert(d);
                        Message.create({
                            header: "Ошибка",
                            text: "При попытке отписки произошла ошибка"
                        });
                    }
                });
            });
        });
    </script>
</head>

<body>
<?php
include( "header.php" );
?>
<div class="flex-block flex-row flex-top flex-center page-limiter">
    <?php
    include( "information-menu.php" )
    ?>
    <div class="content">
        <div class="limit-block">
            <div>
                <h1 class="page-title">Подписка</h1>
                <h2>Здесь Вы можете оформить подписку на наши новости или отписаться от
                    новостей</h2>
                <form action="subscribe-script.php" method="get" id="subscribe-form" class="card">
                    <h3>Оформить подписку</h3>
                    <p class="input-header">E-mail</p>
                    <div>
                        <input type="email" name="email" class="input input-text email"
                               style="width: 300px;">
                    </div>
                    <div>
                        <input type="submit" class="input input-submit">
                    </div>

                </form>
                <form action="subscribe-script.php" method="get" id="unsubscribe-form"
                      class="red-card">
                    <h3 class="red">Отписаться</h3>
                    <p class="input-header">E-mail</p>
                    <div>
                        <input type="email" name="email" class="input input-text email"
                               style="width: 300px;">
                    </div>
                    <div>
                        <input type="submit" class="input input-submit">
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
<?php
include( "footer.html" );
?>
</body>

</html>