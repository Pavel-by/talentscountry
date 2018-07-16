<!DOCTYPE html>
<html>

<head>
    <title>Новости | &laquo;Страна талантов&raquo; - всероссийский конкурс</title>
    <meta charset="utf-8">
    <link type="text/css" rel="stylesheet" href="style.css?date=<?php echo filemtime("styles/style.css"); ?>">
    <script type="text/javascript" src="scripts/js/jquery.js"></script>
    <meta name = "viewport" content = "width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/favicon.ico">
    <style type="text/css">
        .news{
            padding: 10px;
            background-color: white;
            border-radius: 5px;
            width: calc(100% - 40px);
            box-sizing: border-box;
            box-shadow: 1px 1px 8px rgb(180, 180, 180);
            margin: 20px;
        }
        .date{
            padding: 10px;
            margin: 0;
            font-size: 15px;
            color: black;
        }
        .header1{
            font-size: 20px;
            font-weight: 600;
            color: black;
            padding: 10px;
            margin: 0;
            margin-bottom: 10px;
        }
        .text1{
            padding: 10px;
            margin: 0;
            font-size: 15px;
        }
    </style>
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
                <?php
                    include("system/db.php");
                ?>
                <div style="width: 100%;">
                    <h1 class="page-title">Новости</h1>
                    <?php

                        $sqlArr = mysqli_query($link, "SELECT * FROM news ORDER BY `date` DESC");
                        $s = "";
                        while ($rez = mysqli_fetch_array($sqlArr)){
                            $date_time = new DateTime($rez["date"]);
                            $dateString = $date_time->format('d.m.Y');
                            $s .= "<div class='news'><p class='date'>$dateString</p><h2 class='header'>".$rez['header']."</h2><p class='text'>".$rez['text']."</p></div>";
                        }
                        echo $s;

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