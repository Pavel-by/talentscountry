<?php
    include("scripts/check-admin-permissions.php");
    include_once("system/db.php");
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
    <style type="text/css" >
        .table-info {
            border-collapse: collapse;
        }
        .table-info td {
            padding: 10px;
            border: 1px rgb(223, 223, 223) solid;
        }
        .table-info tr {
            position: relative;
        }
    </style>
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
                <div style="width: 100%;">
                    <div class="card">
                        <a href="scripts/admin-get-table.php?table=users">Таблица заявок</a>
                    </div>
                    <div class="card">
                        <a href="scripts/admin-get-table.php?table=payment">Таблица оплат</a>
                    </div>
                    <div class="card">
                        <a href="scripts/admin-get-table.php?table=answers">Таблица бланков</a>
                    </div>
                    <div class="card">
                        <a href="scripts/admin-get-table.php?table=subscribed">Таблица подписавшихся</a>
                    </div>
                    <div class="card">
                        <a href="scripts/admin-get-table.php?table=unsubscribed">Таблица отписавшихся</a>
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