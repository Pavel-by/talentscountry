<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once "C:/Users/mairo/vendor/autoload.php";
    require_once($_SERVER['DOCUMENT_ROOT'] . "/scripts/error-script.php");
    
    class mail {
        private $smtp_data = array(
            "host"			=> 'smtp.rambler.ru',	// SMTP сервер
            "debug"			=> 0,	// Уровень логирования (0 выкл, 1 - вывод ошибок, 2- полный лог)
            "debugoutput"	=> 'html',	//формат вывода лога, если включено логирование
            "auth"			=> true,	// Авторизация на сервере SMTP. Если ее нет - false
            "port"			=> 25,	// Порт SMTP сервера
            "username"		=> 'message@konkurs-5erka.ru',	// Логин на SMTP сервере
            "password"		=> 'lkdNQwio12',	// Пароль на SMTP сервере
            "fromname"		=> 'Конкурс "Пятерка"',	// Отображаемое имя отправителя
            "replyto"		=> array(
                "address"	=> 'support@konkurs-5erka.ru',	// адрес почты для ответа
                "name"		=> 'Конкурс "Пятерка"'	//отображаемое имя владельца ящика
                ),
            "notification"	=> array(
                "address"	=> '',	// Почта оповещения админа (не оповещать- оставить пустым)
                "name"		=> ''	//отображаемое имя владельца ящика
                ),
            "secure"		=> 'tls',	// Тип шифрования. Например ssl или tls
            "charset"		=> 'UTF-8',	//кодировка отправляемых писем
            "verify"		=> '1'	// Верификация сертификата. 0 -выкл, 1 - вкл (выключить при возникновении ошибок связанных с SSL сертификатами при отправке)
        );

        public function setHost($host) {
            $this->smtp_data['host'] = $host;
        }

        public function send($message_data){ 
            $mail = new PHPMailer;

            $from = $message_data['username'];
            if (isset($message_data['from']) and !empty($message_data['from'])){
                $from = $message_data['from'];
            }
            
            $mail->isSMTP();
            if($this->smtp_data['verify'] == 0)
            {
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    ));
            }
            $mail->Host         = $this->smtp_data['host'];
            $mail->SMTPDebug    = $this->smtp_data['debug'];
            $mail->Debugoutput  = $this->smtp_data['debugoutput'];
            $mail->SMTPAuth     = $this->smtp_data['auth'];
            $mail->Port         = $this->smtp_data['port'];
            $mail->Username     = $message_data['username'];
            $mail->Password     = $message_data['password'];
            $mail->SMTPSecure   = $this->smtp_data['secure'];
            $mail->CharSet      = $this->smtp_data['charset'];
            $mail->setFrom($from, $this->smtp_data['fromname']);
            $mail->addReplyTo($this->smtp_data['replyto']['address'], $this->smtp_data['replyto']['name']);
            if(!empty($this->smtp_data['notification']['address']))
            {
                $mail->addAddress($this->smtp_data['notification']['address'], $this->smtp_data['notification']['name']);
            }
            $mail->addAddress($message_data['to'], $message_data['to_name']);
            $mail->Subject = $message_data['title'];
            $mail->msgHTML($message_data['text']);
            $mail->AltBody = strip_tags($message_data['text']);
            $mail->addCustomHeader(
                "Precedence: bulk"
            );
            $mail->MessageID = "<" . hash("sha256", $message_data['to'] . time() . rand(0, 10000)) . "@rambler.ru>";
            if (isset($message_data['unsubscribe']) and !empty($message_data['unsubscribe'])){
                
                $mail->addCustomHeader(
                    "List-Unsubscribe: "
                    . "<mailto:" . $message_data['unsubscribe']['email'] . ">, "
                    . "<" . $message_data['unsubscribe']['link'] . ">"
                );
            }
            if (!$mail->send()) 
            {
                log::e("SEND MAIL: " . $mail->ErrorInfo);
                return false;
            } 
            else 
            {
                return true;
            }
        }

    }


?>