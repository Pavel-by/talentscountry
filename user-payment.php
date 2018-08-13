<?php
    include('scripts/check-autorization.php');
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Отправка подтверждения оплаты | Личный кабинет | &laquo;Страна талантов&raquo; - всероссийский конкурс</title>
        <meta charset="utf-8">
        <link type="text/css" rel="stylesheet" href="style.css?date=<?php echo filemtime("styles/style.css"); ?>">
        <script type="text/javascript" src="scripts/js/jquery.js"></script>
        <script type="text/javascript" src="/module/message.js"></script>
        <meta name = "viewport" content = "width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="images/favicon.ico">
        <script type="text/javascript">
            function UpdateLoadedFiles() {
                var loadedFiles = document.getElementById("loaded-files");
                $.ajax({
                    url: "scripts/get-files-list.php?type=payment",
                    dataType: "JSON",
                    success: function(d) {
                        if (d.error) {
                            if (d.texterror != false) {
                                loadedFiles.innerHTML = d.texterror;
                            } else {
                                loadedFiles.innerHTML = "<p>Не удалось загрузить файлы</p>";
                            }
                        } else {
                            if (d.files.length == 0) {
                                loadedFiles.innerHTML = "<p>Вы не загрузили ни одного файла</p>";
                            } else {
                                var s = "<table class='content-table'><tr><td><b>Дата</b></td><td><b>Название</b></td></tr>";
                                d.files.forEach(function(val, index, array) {
                                    s += "<tr><td>" + val.date + "</td><td>" + val.name + "</td></tr>";
                                });
                                s += "</table>";
                                loadedFiles.innerHTML = s;
                            }
                        }
                    },
                    error: function(d) {
                        loadedFiles.innerHTML = "<p>Не удалось загрузить файлы</p>";
                    }
                });
            }

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

            function LoadFile(file){
                var data = new FormData();
                data.append('myfile', file);
                data.append('type', 'payment');

                $.ajax({
                    url: 'scripts/load-file.php',
                    type: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function(d){
                        if (d.error != false){
                            if (d.texterror != false){
                                Message.create({header: 'Загрузка файла ' + file.name, text: d.texterror});
                            }
                            else{
                                Message.create({header: 'Загрузка файла ' + file.name, text: 'Ошибка на сервере'});
                            }
                        }
                        UpdateLoadedFiles();
                        ContinueLoading();
                    },
                    error: function(d){
                        Message.create({header: 'Загрузка файла ' + file.name, text: 'Ошибка на сервере'});
                        UpdateLoadedFiles();
                        ContinueLoading();
                    }
                });
            }

            var files = new Array();
            var messageWindow = null;

            function ContinueLoading(){
                if (files.length > 0){
                    if (messageWindow == null){
                        messageWindow = Message.create({header: 'Пожалуйста, подождите', text: 'Загрузка файла ' + files[0].name, closeable: false});
                    }
                    messageWindow.setContent('Загрузка файла ' + files[0].name);
                    LoadFile(files[0]);
                    files.splice(0, 1);
                }
                else if (messageWindow != null){
                    messageWindow.hide();
                    messageWindow = null;
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                UpdateLoadedFiles();

                var fileInput = document.getElementById("input-file");
                UpdateChoosenFiles(fileInput);
                fileInput.onchange = function() {
                    UpdateChoosenFiles(this);
                };
                document.getElementById("send-files").addEventListener('click', function(){
                    for (var i = 0; i < fileInput.files.length; i++){
                        files.push(fileInput.files[i]);
                    }
                    ContinueLoading();
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
            include("user-menu.php")
            ?>
            <div class="content">
                <div class="limit-block">
                    <div>
                        <h1 class="page-title">Оплата</h1>
                        <p>В этом разделе Вы можете отправить квитанцию об оплате или документ, подтверждающий, что Вы относитесь к льготной группе участников.</p>
                        <p class="important-text">Загруженный документ проверяется в течение суток</p>
                        <div class="card">
                            <h2>Загруженные документы</h2>
                            <div id="loaded-files"></div>
                        </div>
                        <div class="card">
                            <div>
                                <h2>Загрузить документы</h2>
                                <div class="input-file-parent input input-submit inline-block">
                                    <input type="file" name="files" id="input-file" multiple> Выбрать файлы
                                </div>
                            </div>
                            <div id="choosen-files">

                            </div>
                            <div>
                                <input type="button" class="input input-submit" id="send-files" value="Загрузить файлы">
                            </div>
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