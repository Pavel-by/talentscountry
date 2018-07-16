<?php
include_once( 'system/db.php' );
@session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>О конкурсе | &laquo;Страна талантов&raquo; - всероссийский конкурс</title>
    <meta charset="utf-8">
    <link type="text/css" rel="stylesheet"
          href="style.css?date=<?php echo filemtime( "styles/style.css" ); ?>">
    <script type="text/javascript" src="scripts/js/jquery.js"></script>
    <link rel="shortcut icon" href="images/favicon.ico">
    <script type="text/javascript" src="/module/message.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            var form = document.getElementById("restore-form");
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                $.ajax({
                    url: "scripts/restore-password-script.php",
                    type: 'GET',
                    data: $(form).serialize(),
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function (d) {
                        if (d.error) {
                            var mes = "Ошибка при обработке данных на сервере.";
                            if (d.texterror != false) {
                                mes = d.texterror;
                            }
                            Message.create({header: "Ошибка", text: mes});
                        }
                        else {
                            if (typeof d.message !== 'undefined' && d.message != null) {
                                Message.create({header: "Успех", text: d.message});
                            }
                        }
                    },
                    error: function () {
                        Message.create({
                            header: "Ошибка",
                            text: "Ошибка при обработке данных на сервере."
                        })
                    }
                });
            });
        });
    </script>
</head>

<body style="background-color: #F5F5F5;">
<?php
include( "header.php" );
?>
<div class="flex-block flex-row flex-top flex-center page-limiter">
    <?php
    include( "information-menu.php" )
    ?>
    <div class="content">
        <div class="limit-block">
            <div class="center" style="width: 100%;">
                <form id="restore-form" class="left"
                      style="display: inline-block; max-width: 500px;">
                    <h2>Восстановление пароля</h2>
                    <?php
                    if ( isset( $_GET[ 'restorekey' ] ) ) {
                        if ( $link ) {
                            $restore_key =
                                mysqli_real_escape_string( $link, $_GET[ 'restorekey' ] );
                            $rez         = mysqli_query( $link,
                                "SELECT `userkey`, `date` FROM `restore-password` WHERE `restorekey`='$restore_key'" );
                            if ( $rez and $rez = mysqli_fetch_array( $rez ) ) {
                                $date = new DateTime( $rez[ 'date' ] );
                                $date->modify( '+1 day' );
                                $currentDate = new DateTime( date( 'Y-m-d H:i:s' ) );
                                if ( $date > $currentDate ) {
                                    $_SESSION[ 'restore-userkey' ] = $rez[ 'userkey' ];
                                    $_SESSION[ 'restorekey' ]      = $restore_key;
                                    echo '<div><input type="password" value="" placeholder="Новый пароль" name="password" class="text-input"></div>' .
                                        '<div><input type="submit" value="Далее" class="submit-button"></div>';
                                } else {
                                    echo "Ссылка на восстановление пароля доступна всего сутки. Вы воспользовались устаревшей ссылкой.";
                                }
                            } else {
                                echo mysqli_error( $link );
                                echo "<p>Ошибка при подключении к базе данных. Возможно, Вы уже изменяли пароль, используя эту ссылку.</p>";
                            }
                        } else {
                            echo "<p>Ошибка при подключении к базе данных. Попробуйте перезагрузить страницу.</p>";
                        }
                    } else {
                        echo '<div><input type="email" value="" placeholder="Ваша почта" name="email" class="text-input"></div>' .
                            '<div><input type="submit" value="Далее" class="submit-button"></div>';
                    }
                    ?>

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