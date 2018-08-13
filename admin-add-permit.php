<?php
include( "scripts/check-admin-permissions.php" )
?>
<!DOCTYPE html>
<html>

<head>
    <title>Добавление разрешений | &laquo;Страна талантов&raquo; - всероссийский конкурс</title>
    <meta charset="utf-8">
    <link type="text/css" rel="stylesheet"
          href="style.css?date=<?php echo filemtime( "styles/style.css" ); ?>">
    <script type="text/javascript" src="scripts/js/jquery.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="/module/message.js"></script>
    <link rel="shortcut icon" href="images/favicon.ico">
    <script type="text/javascript">
        var lastData;

        function getTableSt(title, text) {
            var text = "<tr>"
                + "<td><b>" + title + "</b></td>"
                + "<td>" + text + "</td>"
                + "</tr>";
            return text;
        }

        function getCompetitionName(s = "") {
            switch (s) {
                case "arithmetic":
                    return "Арифметика";
                case "puzzle":
                    return "Головоломка";
                case "math":
                    return "Математика";
                case "rebus":
                    return "Ребус";
                case "scholar":
                    return "Грамотей";
                case "russian":
                    return "Русский язык";
                default:
                    return "";
            }
        }

        function updateInfo(data) {
            var text;
            if (data == false) {
                text = "<div class='card'><h3>Пользователь с таким ID не найден</h3></div>";
            }
            else {
                text = "<div class='card'><table class='content-table'>";
                text += getTableSt("Имя", data.name);
                text += getTableSt("Регион", data.region);
                text += getTableSt("Город", data.city);
                text += getTableSt("Школа", data.school);
                text += getTableSt("Почтовый индекс", data.postcode);
                text += getTableSt("E-mail", data.email);
                text += getTableSt("Телефон", data.phone);
                text += getTableSt("&nbsp;", "");
                text += "<tr><td colspan='2' class='bold' style='text-align: center;'>Запрошенные конкурсы</td></tr>";
                for (val in data.classes) {
                    text += getTableSt("", data.classes[val]);
                }
                /*$.each($.parseJSON(data.classes), function(i, val){
                 text += getTableSt(getCompetitionName(i), val);
                 });*/
                if (data.usertype == 1) {
                    text += getTableSt("Статус аккаунта", "<span class='green'>Доступ открыт</span>");
                }
                else if (data.usertype == 0) {
                    text += getTableSt("Статус аккаунта", "<span class='red'>Доступ запрещен</span>");
                }
                else {
                    text += getTableSt("Статус аккаунта", "<span class='blue'>Администратор</span>");
                }

                text += "</table>";

                if (data.usertype == 0) {
                    text += "<input type='button' class='input input-submit' value='Открыть доступ' onclick='changeUserType(" + data.id + ", 1);'>";
                }
                else if (data.usertype == 1) {
                    text += "<input type='button' class='input input-submit' value='Запретить доступ' onclick='changeUserType(" + data.id + ", 0);'>";
                }
            }
            document.getElementById("result").innerHTML = text;
        }

        function changeUserType(id, newType) {
            var Wait = new Message({
                header: "Подождите",
                text: "Обновление данных",
                closeable: false
            });

            $.ajax({
                url: 'scripts/update-user-info-script.php',
                type: "GET",
                data: {id: id, type: newType},
                dataType: "JSON",
                success: function (d) {
                    if (d.error == false) {
                        lastData.usertype = newType;
                        updateInfo(lastData);
                    }
                    else {
                        var message = "Ошибка при обработке данных на сервере";
                        if (d.texterror != false) {
                            message = d.texterror;
                        }
                        Message.create({header: "Ошибка", text: message});
                    }
                    Wait.hide();
                },
                error: function () {
                    var message = "Ошибка при обработке данных на сервере";
                    Message.create({header: "Ошибка", text: message});
                    Wait.hide();
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function () {
            var idInput = $("#form-get-info [name=id]");

            idInput.select();
            document.getElementById("form-get-info").addEventListener('submit', function (e) {
                e.preventDefault();
                var form = this;
                var Wait = new Message({
                    header: "Подождите",
                    text: "Получение информации о пользователе",
                    closeable: false
                });

                $.ajax({
                    url: "scripts/admin-get-user-info.php",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function (d) {
                        Wait.hide();
                        if (d.error == true) {
                            var error = "Ошибка при обработке данных на сервере. Попробуйте перезагрузить страницу.";
                            if (d.texterror != false) {
                                error = d.texterror;
                            }
                            Message.create({header: "Ошибка", text: error});
                        }
                        else {
                            lastData = d.data;
                            updateInfo(lastData);
                        }
                    },
                    error: function () {
                        Wait.hide();
                        Message.create({
                            header: "Ошибка",
                            text: "Ошибка при обработке данных на сервере. Попробуйте перезагрузить страницу."
                        });
                    }
                });
                idInput.select();
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
    include( "admin-menu.php" );
    ?>
    <div class="content">
        <div class="limit-block">
            <div>
                <h1 class="page-title">Изменить права пользователей</h1>
                <div class="card">
                    <form id="form-get-info">
                        <h3>Введите ID пользователя</h3>
                        <input type="text" name="id" value="" class="input input-text" autocomplete="off">
                        <input type="submit" value="Поиск" class="input input-submit">
                    </form>
                </div>

                <div id="result"></div>
            </div>
        </div>
    </div>
</div>
<?php
include( "footer.html" );
?>
</body>

</html>