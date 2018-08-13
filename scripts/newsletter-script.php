<?php
    ini_set ("display_errors", "1");
    error_reporting(E_ALL);

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
    //use PHPMailer\PHPMailer\PHPMailer;
    //use PHPMailer\PHPMailer\Exception;

    require_once ROOT . "/PHPMailer/src/PHPMailer.php";
    require_once ROOT . "/PHPMailer/src/SMTP.php";
    require_once ROOT . "/PHPMailer/src/Exception.php";
    include_once("error-script.php");
    include_once($_SERVER['DOCUMENT_ROOT'] . "/system/db.php");
    //require_once "C:/Users/Павел/vendor/autoload.php";
    //include_once(ROOT . "/PHPMailer/src/PHPMailer.php");

    $maxConnectionCount = 0;

    class Newsletter {
        const maxConnectionCount            = 10;
        const maxMessagesInHour             = 1000;
        const maxMessagesInMinute           = 10;

        private $sendedDBName               = "sended-from-valid";
        private $maxConnectionCount         = 10;
        private $maxMessagesInMinute        = 10;
        private $maxMessagesInHour          = 1000;
        private $emailsDBName               = "excel-emails1";
        private $maxEmailsForOneSQLRequest  = 100;
        private $title                      = "Конкурс \"Пятерка\" приглашает к участию всех желающих";
        private $hasNameInTable             = true;
        
        private $debug			            = 0;	// Уровень логирования (0 выкл, 1 - вывод ошибок, 2- полный лог)
        private $debugoutput	            = 'html';	//формат вывода лога, если включено логирование
        private $auth			            = true;	// Авторизация на сервере SMTP. Если ее нет - false
        private $port			            = 25;	// Порт SMTP сервера
        private $from                       = "newsletter@konkurs-5erka.ru";
        private $fromName		            = 'Конкурс "Пятерка"';	// Отображаемое имя отправителя
        private $replyto		            = array(
                "address"	=> 'help@stranatalantow.ru',	// адрес почты для ответа
                "name"		=> 'Конкурс "Страна талантов"'	//отображаемое имя владельца ящика
        );
        private $notification	            = array(
                "address"	=> '',	// Почта оповещения админа (не оповещать- оставить пустым)
                "name"	    => ''	//отображаемое имя владельца ящика
        );
        private $secure		                = 'tls';	// Тип шифрования. Например ssl или tls
        private $charset		            = 'UTF-8';	//кодировка отправляемых писем
        private $verify		                = '1';	// Верификация сертификата. 0 -выкл, 1 - вкл (выключить при возникновении ошибок связанных с SSL сертификатами при отправке)

        private $host                       = "connect.smtp.bz";
        private $login                      = "mairon-pasha@yandex.ru";
        private $password                   = "fAAVokNrArek";

        private $sendedTime                 = array();
        private $emailsArray                = array();

        function __construct() {
            for ($i = 0; $i < $this->maxMessagesInHour; $i++) {
                $this->sendedTime[] = 0;
            }
        }

        /**
         * Возвращает результат SQL запроса
         * 
        */
        function getSQL($SQLRequest = "") {
            global $link;
            $connectionCount = 0;
            while (($sql = mysqli_query($link, $SQLRequest)) === false and $connectionCount < $this->maxConnectionCount) {
                $connectionCount += 1;
                sleep(10);
            } 
            if ($connectionCount >= $this->maxConnectionCount) {
                log::newsletter("ERROR: CANNOT CONNECT TO DATABASE: " . mysqli_error($link));
                log::e("CANNOT CONNECT TO DATABASE: " . mysqli_error($link));
                throw new Exception("CANNOT CONNECT TO DATABASE: " . mysqli_error($link));
            }
            return $sql;
        }

        /**
         * Возвращает количество отправленных писем
         * 
        */
        function getSendedCount() {
            $line = mysqli_fetch_array($this->getSQL("SELECT COUNT(*) as 'count' FROM `$sendedDBName`"));
            return $line['count'];
        }

        /**
         * Обновляет, если необходимо, динамический массив доступных email
        */
        private function updateEmailsArray(){
            if (count($this->emailsArray) >= $this->maxEmailsForOneSQLRequest) {
                return;
            }

            $sendedDBName = $this->sendedDBName;
            $emailsDBName = $this->emailsDBName;
            $need = $this->maxEmailsForOneSQLRequest - count($this->emailsArray);

            if ($this->hasNameInTable) {
                $sql = $this->getSQL("SELECT `email`, `name` FROM `$emailsDBName` WHERE `email` not in (SELECT `email` FROM `$sendedDBName`) ORDER BY `id` LIMIT $need");
            }
            else {
                $sql = $this->getSQL("SELECT `email` FROM `$emailsDBName` WHERE `email` not in (SELECT `email` FROM `$sendedDBName`) ORDER BY `id` LIMIT $need");
            }
            
            while ($line = mysqli_fetch_array($sql)) {
                if ($this->hasNameInTable) {
                    $this->emailsArray[] = array(
                        "email" => $line['email'], 
                        "name"  => $line['name']
                    );
                }
                else {
                    $this->emailsArray[] = array(
                        "email" => $line['email']
                    );
                }
            }
        }

        /**
         * Получить следующий email 
         */
        function getNext() {
            $this->updateEmailsArray();
            $email = $this->emailsArray[0];
            array_splice($this->emailsArray, 0, 1);
            return $email;
        }

        /**
         * Проверяет, не превышен ли заданный лимит по минутам / часам. Если превышен, то "ждет".
         * Внимание!
         * Использовать ТОЛЬКО при отправлении письма
         */
        private function waitIfNeed() {
            $count = count($this->sendedTime);
            $timePassed = time() - $this->sendedTime[0];
            if ($timePassed <= 60 * 60) {
                sleep(60 * 60 - (time() - $this->sendedTime[0]));
            }
            $timePassed = time() - $this->sendedTime[$count - $this->maxMessagesInMinute];
            if ($timePassed < 60) {
                sleep(60 - $timePassed);
            }
            for ($i = 0; $i < $count - 1; $i++) {
                $this->sendedTime[$i] = $this->sendedTime[$i + 1];
            }
            $this->sendedTime[$count - 1] = time();
        }

        /**
         * Отправить письмо 
         */
        function send($messageData) {
            $this->waitIfNeed();

            $sendedDBName = $this->sendedDBName;

            $From = $this->from;
            $FromName = $this->fromName;
            $Host = $this->host;
            $SMTPDebug = $this->debug;
            $DebugOutput = $this->debugoutput;
            $SMTPAuth = $this->auth;
            $Login = $this->login;
            $Password = $this->password;
            $SMPTSecure = $this->secure;
            $CharSet = $this->charset;
            $ReplyTo = $this->replyto;
            $Email = $messageData['email'];
            $Unsubscribe = $messageData['unsubscribe'];
            $Text = $messageData['text'];
            $Name = $messageData['name'];
            $Port = $this->port;
            $Secure = $this->secure;
            $Title = $this->title;

            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = $Host;
            $mail->SMTPDebug = $SMTPDebug;
            $mail->Debugoutput = $DebugOutput;
            $mail->SMTPAuth = $SMTPAuth;
            $mail->Port = $Port;
            $mail->Username = $Login;
            $mail->Password = $Password;
            $mail->SMTPSecure = $Secure;
            $mail->CharSet = $CharSet;
            $mail->setFrom($From, $FromName);
            $mail->addReplyTo($ReplyTo['address'], $ReplyTo['name']);
            $mail->addAddress($Email, $Name);
            $mail->Subject = $Title;
            $mail->msgHTML($Text);
            $mail->AltBody = strip_tags($Text);
            $mail->addCustomHeader(
                "Precedence: bulk"
            );
            $mail->addCustomHeader(
                "List-Unsubscribe: "
                . "<mailto:" . $Unsubscribe['email'] . ">, "
                . "<" . $Unsubscribe['link'] . ">"
            );
            if (!$mail->send()) {
                log::e("SEND MAIL ERROR: " . $mail->ErrorInfo);
                log::newsletter("FAILED WITH SENDING LETTER TO <$Email>");
                return false;
            }
            else {
                log::newsletter("SUCCESS SENDED LETTER TO <$Email>");
                return true;
            }
        }

        function setSendedDBName($name) {
            $this->sendedDBName = $name;
        }

        function setMaxConnectionCount($count = self::maxConnectionCount) {
            $this->maxConnectionCount = $count;
        }

        function setEmailsDBName($name) {
            $this->emailsDBName = $name;
        }

        function setMaxMessagesInMinute($count) {
            $this->maxMessagesInMinute = $count;
        }

        function setMaxMessagesInHour($mesCount) {
            $this->maxMessagesInHour = $mesCount;
            $count = count($this->sendedTime);
            if ($count < $mesCount) {
                $need = $mesCount - $count;
                $newArr = array();
                for ($i = 0; $i < $need; $i++) {
                    $newArr[] = 0;
                }
                foreach ($this->sendedTime as $i) {
                    $newArr[] = $i;
                } 
                $this->sendedTime = $newArr;
            }
            else if ($count > $mesCount) {
                $extra = $count - $mesCount;
                $newArr = array();
                for ($i = $count - $mesCount; $i < $count; $i++) {
                    $newArr[] = $this->sendedTime[$i];
                }
                $this->sendedTime = $newArr;
            }
        }

        function setTitle($title) {
            $this->title = $title;
        }

        function setHost($host) {
            $this->host = $host;
        }

        function setLogin($login) {
            $this->login = $login;
        }

        function setPassword($password) {
            $this->password = $password;
        }

        function setPort($port) {
            $this->port = $port;
        }

        function hasName($hasName = true) {
            $this->hasNameInTable = $hasName;
        }

        /**
         * @return string
         */
        public function getFrom()
        {
            return $this->from;
        }

        /**
         * @param string $from
         */
        public function setFrom($from)
        {
            $this->from = $from;
        }

        /**
         * @return string
         */
        public function getFromName()
        {
            return $this->fromName;
        }

        /**
         * @param string $fromName
         */
        public function setFromName($fromName)
        {
            $this->fromName = $fromName;
        }


    }
    
    
?>