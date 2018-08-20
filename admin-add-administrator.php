<?php
include("scripts/check-admin-permissions.php")
?>
<!DOCTYPE html>
<html>

<head>
    <title>Добавление разрешений | &laquo;Страна талантов&raquo; - всероссийский конкурс</title>
    <meta charset="utf-8">
    <link type="text/css" rel="stylesheet"
          href="style.css?date=<?php echo filemtime("styles/style.css"); ?>">
    <script type="text/javascript" src="scripts/js/jquery.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="/module/message.js"></script>
    <link rel="shortcut icon" href="images/favicon.ico">
    <script type="text/javascript">
        function addAdmin(name, email, password, confirmPassword, callback = function(isAdded){}) {
            var message = Message.create({header: "Загрузка", text: "Пожалуйста, подождите", closeable: false});
            $.ajax({
                url: "/scripts/register-admin.php",
                type: "POST",
                data: {
                    name: name,
                    email: email,
                    password: password,
                    confirmPassword: confirmPassword
                },
                dataType: 'json',
                success: function(d) {
                    message.hide();
                    if (d.error) {
                        Message.create({header: "Ошибка", text: d.texterror});
                        callback(false);
                    } else {
                        Message.create({header: "Успешно", text: d.texterror});
                        callback(true);
                    }
                },
                error: function() {
                    message.hide();
                    Message.create({header: "Ошибка", text: "Ошибка при создании пользователя"});
                    callback(false);
                }
            });
        }

        $(document).ready(function() {
            $("#form").submit(function() {
                var form = this;
                addAdmin(
                    $(this).find('[name=name]').val(),
                    $(this).find('[name=email]').val(),
                    $(this).find('[name=password]').val(),
                    $(this).find('[name=confirmPassword]').val(),
                    added => {
                        if (added) {
                            form.reset();
                        }
                    }
                );
                return false;
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
    include("admin-menu.php");
    ?>
    <div class="content">
        <div class="limit-block">
            <div>
                <h1 class="page-title">Добавить администратора</h1>
                <form id="form" style="max-width: 400px;">
                    <div>
                        <label>Имя<br><input type="text" class="input input-text full-width" name="name"></label>
                    </div>
                    <div>
                        <label>Почта<br><input type="text" class="input input-text full-width" name="email"></label>
                    </div>
                    <div>
                        <label>Пароль<br><input type="password" class="input input-text full-width" name="password"></label>
                    </div>
                    <div>
                        <label>Повторите пароль<br><input type="password" class="input input-text full-width"
                                                          name="confirmPassword"></label>
                    </div>
                    <div>
                        <input type="submit" class="input input-submit" value="Добавить">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include("footer.html");
?>
</body>

</html>