<?php
session_start();
if ( isset( $_GET[ 'next' ] ) ) {
    $next = $_GET[ 'next' ];
}
if ( isset( $_SESSION[ 'usertype' ] ) ) {
    if ( isset( $next ) ) {
        header( "Location:http://" . $_SERVER[ 'HTTP_HOST' ] . "/$next" );
    } else if ( $_SESSION[ 'usertype' ] == 2 ) {
        header( "Location:http://" . $_SERVER[ 'HTTP_HOST' ] . "/admin-add-permit.php" );
    } else {
        header( 'Location:http://' . $_SERVER[ 'HTTP_HOST' ] . '/user-info.php' );
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Вход | &laquo;Страна талантов&raquo; - всероссийский конкурс</title>
    <meta charset="utf-8">
    <link type="text/css" rel="stylesheet"
          href="style.css?date=<?php echo filemtime( "styles/style.css" ); ?>">
    <script type="text/javascript" src="scripts/js/jquery.js"></script>
    <script type="text/javascript" src="/module/message.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.ico">
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/module/metrika.php"); ?>
    <script type="text/javascript">

        document.addEventListener('DOMContentLoaded', function () {
            var formError = $('#form-error');
            var email = $('input[name=email]');
            var password = $('input[name=password]');
            var href = <?php echo isset( $_GET[ 'next' ] ) ? '"' . $_GET[ 'next' ] . '";' :
                'null;' ?>

                formError.hide();

            document.getElementById('register-form').addEventListener('submit', function (e) {
                e.preventDefault();

                var data = $('#register-form').serialize();
                var Wait = new Message({
                    header: "Загрузка",
                    text: "Проверка данных",
                    closeable: false
                });
                $.ajax({
                    url: 'scripts/check-login.php',
                    data: data,
                    type: 'POST',
                    dataType: 'JSON',
                    success: function (d) {
                        Wait.hide();
                        if (d.error) {
                            formError.html(d.texterror);
                            formError.show();
                        }
                        else {
                            if (href != null) {
                                location.replace(href);
                            }
                            else if (d.href != null)
                                location.replace(d.href);
                            formError.hide();
                        }
                    },
                    error: function (d) {
                        Wait.hide();
                        Message.close({
                            header: "Ошибка",
                            text: "Ошибка при обработке данных на сервере"
                        });
                    }
                });
            });
        });
    </script>
</head>

<body>
<?php
include( 'header.php' );
?>
<div class="flex-block flex-row flex-top flex-center page-limiter">
    <?php
    include( "information-menu.php" )
    ?>
    <div class="content">
        <div class="limit-block">
            <form id="register-form" class="left"
                  style="display: inline-block; width: 400px; max-width: 100%; padding-top: 10px;">
                <h2>Вход</h2>
                <div>
                    <label>Email</label>
                    <input type="text" placeholder="E-mail" name="email" class="input full-width input-text">
                    <span class="input-error"></span>
                </div>
                <div>
                    <label>Пароль</label>
                    <input type="password" placeholder="Пароль" name="password" class="input full-width input-text">
                    <span class="input-error"></span>
                </div>
                <span class="input-error"
                      id="form-error">Присутствуют ошибки при заполнении полей</span>
                <input type="submit" class="input input-submit" value="Войти">
                <p class="left">Еще не зарегистрированы? <a href="registration.php">Зарегистрироваться</a>
                </p>
            </form>
        </div>
    </div>
</div>
<?php
include( "footer.html" );
?>
</body>

</html>