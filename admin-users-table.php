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
                    <div>
                        <?php
                            $linesCount = 40;
                            if (isset($_GET['page'])) {
                                $page = mysqli_real_escape_string($link, $_GET['page']);
                            }
                            else {
                                $page = 1;
                            }
                            if ($link) {
                                $start = ($page - 1) * $linesCount + 1;
                                $end = $page * $linesCount;
                                $sql = mysqli_query($link, "SELECT `name`, `school`, `email`, `id` FROM `users` ORDER BY `id` LIMIT $start, $end");
                                $s = "<table class='table-info'>";
                                $s .= "<tr class='bold'>"
                                    . "<td>Номер</td>"
                                    . "<td>ID</td>"
                                    . "<td>Имя</td>"
                                    . "<td>Email</td>"
                                    . "<td>Школа</td>"
                                    . "</tr>";
                                $i = $start;
                                while ($row = mysqli_fetch_array($sql)) {
                                    $id = $row['id'];
                                    $name = $row['name'];
                                    $school = $row['school'];
                                    $email = $row['email'];

                                    $s .= "<a href='#' style='display: block;'><tr>"
                                        . "<td>$i</td>"
                                        . "<td>$id</td>"
                                        . "<td>$name</td>"
                                        . "<td>$email</td>"
                                        . "<td>$school</td>"
                                        . "</tr></a>";
                                    $i += 1;
                                }
                                $s .= "</table>";
                                echo $s;
                            }
                        ?>
                    </div>
            </div>
        </div>
    </div>
        <?php
        include("footer.html");
    ?>
</body>

</html>