<?php
    include("scripts/check-admin-permissions.php")
?>
<!DOCTYPE html>
<html>

<head>
    <title>Добавление разрешений | &laquo;Страна талантов&raquo; - всероссийский конкурс</title>
    <meta charset="utf-8">
    <link type="text/css" rel="stylesheet" href="style.css?date=<?php echo filemtime("styles/style.css"); ?>">
    <script type="text/javascript" src="scripts/js/jquery.js"></script>
    <meta name = "viewport" content = "width=device-width, initial-scale=1">
    <script type="text/javascript" src="/module/message.js"></script>
    <link rel="shortcut icon" href="images/favicon.ico">
    <script type="text/javascript">
        function UpdateChoosenFiles(input) {
            var container = document.getElementById("choosen-files");
            var s = "<table class='content-table'><tr><td><b>Выбранные файлы</b></td></tr>";
            for (var i = 0; i < input.files.length; i++) {
                s += "<tr><td>" + input.files[i].name + "</td></tr>";
            }
            s += '</table>';
            if (input.files.length == 0) {
                s = "<p>Вы не выбрали ни одного файла для загрузки</p>";
            }
            container.innerHTML = s;
        }

        document.addEventListener('DOMContentLoaded', function(){
            var fileInput = document.getElementById('input-file');
            UpdateChoosenFiles(fileInput);

            fileInput.onchange = function() {
                UpdateChoosenFiles(fileInput);
            }

            document.getElementById('update-form').addEventListener('submit', function(e) {
                e.preventDefault();
                var data = new FormData();
                data.append( "startRow",             $(this).find("[name=startRow]").val()          );
                data.append( "idColumn",             $(this).find("[name=idColumn]").val()          );
                data.append( "nameColumn",           $(this).find("[name=nameColumn]").val()        );
                data.append( "competitionColumn",    $(this).find("[name=competitionColumn]").val() );
                data.append( "classColumn",          $(this).find("[name=classColumn]").val()       );
                data.append( "pointsColumn",         $(this).find("[name=pointsColumn]").val()      );
                data.append( "ratingColumn",         $(this).find("[name=ratingColumn]").val()      );
                data.append( "placeColumn",          $(this).find("[name=placeColumn]").val()       );
                data.append( "indexColumn",          $(this).find("[name=indexColumn]").val()       );
                
                if (fileInput.files.length != 1) {
                    Message.create({header: "Ошибка", text: "Необходимое количество файлов для загрузки: 1"});
                    return;
                }
                data.append('file', fileInput.files[0]);
                var mes = new Message({header: "Загрузка", text: "Пожалуйста, подождите", closeable: false});
                $.ajax({
                    url: "scripts/update-results.php",
                    type: "POST",
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    data: data,
                    success: function(data) {
                        mes.hide();
                        if (data.error) {
                            Message.create({header: "Ошибка", text: data.texterror});
                        }
                        else {
                            Message.create({header: "Файл загружен", text: data.texterror});
                        }
                    },
                    error: function(d) {
                        mes.hide();
                        Message.create({header: "Ошибка", text: "Не удалось загрузить файл"});
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
        include("admin-menu.php");
        ?>
        <div class="content">
            <div class="limit-block">
                <div>
                    <h1 class="page-title">Добавить результаты</h1>
                    
                    <div class="important-text">
                        <p>Загружать можно Excel таблицы.</p>
                        <p>В настройках ниже можно указать буквенные 
                        обозначения столбцов с информацией: Id участника, имя, 
                        класс и т.д. (используются: A - первый столбец, B - второй и т.д.).</p>
                        <p>"Начинать загрузку со строки" - номер строки, с которой начинается
                        список участников (например возможен такой вариант: если в файле
                        на первой строке указаны названия столбцов, то можно установить в поле
                        "Начинать загрузку со строки" значение 2, тогда будут занесены
                        строки, начиная со второй).</p>
                    </div>
                    <div>
                        <form id="update-form">
                            <table class="content-table">
                                <tr>
                                    <td>
                                        <p class="bold" style="white-space: nowrap;">Начинать загрузку со строки</p>
                                    </td>
                                    <td>
                                        <input name="startRow" type="text" class="input input-text" value="1" style="width: 32px; text-align: center;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="bold" style="white-space: nowrap;">Индекс столбца Id</p>
                                    </td>
                                    <td>
                                        <input name="idColumn" type="text" class="input input-text" value="A" style="width: 32px; text-align: center;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="bold" style="white-space: nowrap;">Индекс столбца Имя участника</p>
                                    </td>
                                    <td>
                                        <input name="nameColumn" type="text" class="input input-text" value="B" style="width: 32px; text-align: center;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="bold" style="white-space: nowrap;">Индекс столбца Название конкурса</p>
                                    </td>
                                    <td>
                                        <input name="competitionColumn" type="text" class="input input-text" value="C" style="width: 32px; text-align: center;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="bold" style="white-space: nowrap;">Индекс столбца Класс</p>
                                    </td>
                                    <td>
                                        <input name="classColumn" type="text" class="input input-text" value="D" style="width: 32px; text-align: center;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="bold" style="white-space: nowrap;">Индекс столбца Баллы</p>
                                    </td>
                                    <td>
                                        <input name="pointsColumn" type="text" class="input input-text" value="E" style="width: 32px; text-align: center;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="bold" style="white-space: nowrap;">Индекс столбца Рейтинг</p>
                                    </td>
                                    <td>
                                        <input name="ratingColumn" type="text" class="input input-text" value="F" style="width: 32px; text-align: center;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="bold" style="white-space: nowrap;">Индекс столбца Место</p>
                                    </td>
                                    <td>
                                        <input name="placeColumn" type="text" class="input input-text" value="G" style="width: 32px; text-align: center;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="bold" style="white-space: nowrap;">Индекс столбца Почтовый индекс</p>
                                    </td>
                                    <td>
                                        <input name="indexColumn" type="text" class="input input-text" value="H" style="width: 32px; text-align: center;">
                                    </td>
                                </tr>
                            </table>
                            <hr>
                            <div class="input-file-parent input input-submit inline-block">
                                <input type="file" name="file" id="input-file">Выбрать файл
                            </div>

                            <div id="choosen-files"></div>

                            <input type="submit" class="input input-submit" value="Добавить">
                        </form>
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