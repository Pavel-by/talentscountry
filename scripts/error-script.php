<?php
    class log{
        public static function d($message){
            $date = date('Y-m-d H:i:s: \M\E\S\S\A\G\E: ');
            $f = fopen($_SERVER['DOCUMENT_ROOT'] . '/log-d.txt', 'a');
            fwrite($f, $date . $message . "\n");
            fclose($f);
        }

        public static function e($message){
            $date = date('Y-m-d H:i:s: \E\R\R\O\R: ');
            $f = fopen($_SERVER['DOCUMENT_ROOT'] . '/log-e.txt', 'a');
            fwrite($f, $date . $message . "\n");
            fclose($f);
        }

        public static function action($key, $message){
            $date = date('Y-m-d H:i:s: ');
            $f = fopen($_SERVER['DOCUMENT_ROOT'] . '/log-actions.txt', 'a');
            fwrite($f, $date . $key . "\n" . $message . "\n");
            fclose($f);
        }

        public static function newsletter($message){
            $date = date('Y-m-d H:i:s: ');
            $f = fopen($_SERVER['DOCUMENT_ROOT'] . '/log-newsletter.txt', 'a');
            fwrite($f, $date .  $message . "\n");
            fclose($f);
        }

        public static function sql($link, $description, $details = "") {
            $type = (isset($_SESSION['usertype']) ? $_SESSION['usertype'] : -1);
            $userkey = (isset($_SESSION['userkey']) ? $_SESSION['userkey'] : "null");
            mysqli_query(
                $link, 
                "INSERT INTO `log`(`userkey`,`type`,`description`, `details`) "
                    . "VALUES('$userkey', $type, '$description', '$details')"
            );
        }
    }
?>