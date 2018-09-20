<!DOCTYPE html>
<html>
    <head>
        <title>Отписаться</title>
        <meta charset="utf-8">
        <meta name = "viewport" content = "width=device-width, initial-scale=1">
        <?php include($_SERVER['DOCUMENT_ROOT'] . "/module/metrika.php"); ?>
        <style type="text/css">
            * {
                text-align: left;
            }
            input[type=text] {
                margin: 10px;
                padding: 10px;
                font-size: 16px;
                border: 1px solid gray;
            }
            input[type=submit] {
                margin: 10px;
                padding: 7px 14px 7px 14px;
                background-color: #e6e6e6;
                border: 1px solid #b3b3b3;
                font-size: 16px;
            }
            p {
                font-size: 16px;
                margin: 10px;
                padding: 0;
                color: #1e1e1e;
            }
            h1 {
                margin: 30px 10px 30px 10px;
                font-size: 25px;
            }
            .card {
                padding: 20px;
                background-color: white;
                border: 0px solid #ACACAC;
                border-radius: 4px;
                width: calc(100% - 40px);
                margin: 10px;
                margin-bottom: 20px;
                margin-top: 20px;
                box-shadow: 1px 1px 8px rgb(180, 180, 180);
            }
        </style>
    </head>
    <body style='text-align: left; width: 100%; max-width: 600px; margin: auto;'>
        <div class="card">
            <h1 style="color: #CC6A00">Олимпиада "Страна талантов"</h1>
            <?php
                if (isset($_GET['email'])){
                    include_once 'system/db.php';
                    require_once('scripts/error-script.php');
                    $date = date("Y-m-d H:i:s");
                    $email = mysqli_real_escape_string($link, $_GET['email']);
                    if ($link){
                        $rez = mysqli_query($link, "INSERT IGNORE INTO `unsubscribed`(`email`, `date`) VALUES('$email', '$date')");
                        if (!$rez){
                            log::e(mysqli_error($link));
                            $file = fopen('unsubscribed.txt');
                            fwrite($file, $email . " " . $date . "\n");
                            fclose($file);
                        }
                    }
                    else{                    
                        $file = fopen('unsubscribed.txt');
                        fwrite($file, $email . " " . $date . "\n");
                        fclose($file);
                    }
                    echo "<h3>Ваш E-mail: " . $_GET['email'] . "</h3><h3>Вы успешно отписались от рассылки!</h3>";
                }
                else {
                    $text = "<form action='unsubscribe-one-click.php' method='get' style='text-align: left; width: 100%; max-width: 600px; margin: auto;'>"
                        . "<p>Введите email для отписки:</p>"
                        . "<input type='text' name='email'><br>"
                        . "<input type='submit' value='Отписаться'>"
                        . "</form>";
                    echo $text;
                }
            ?>
        </div>
    </body>
</html>