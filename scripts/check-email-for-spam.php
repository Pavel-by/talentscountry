<?php
    include($_SERVER['DOCUMENT_ROOT'] . "/system/db.php");
    set_time_limit(60 * 30);

    $flags = array(
        "user unknown",
        "mailbox size limit",
        "following address(es) failed",
        "account is full",
        "message rejected",
        "user quota exceeded"
    );

    function checkEmailForSpam($email, $password, $pop3Server = "imap.beget.com") {
        global $flags, $link;
        $inbox = imap_open('{'.$pop3Server.':993/ssl}INBOX', $email, $password);
        if (!$inbox){
            return false;
        }
        $result = true;
        $emails = imap_search($inbox,'UNSEEN');
        $checked = array();
        
        $blockedEmails = array();
        $seen = array();
        foreach($emails as $mail) {
            $message = @imap_fetchbody($inbox, $mail, 1.2);

            if (imap_base64($message))
                $message = imap_base64($message);
            else {
                $message = @imap_fetchbody($inbox, $mail, 1);
                if (imap_base64($message))
                    $message = imap_base64($message);
            }

            //echo $message . "<hr>";

            $message = mb_strtolower($message);

            $hasFlag = false;
            foreach ($flags as $flag) {
                if (strpos($message, $flag)) {
                    $hasFlag = true;
                    break;
                }
            }

            if ($hasFlag) {
                preg_match("/\ ([^\ ]+@[^\ ]+)\ /m", $message, $matches);
                $email = trim($matches[1]);
                mysqli_query($link, "INSERT INTO `error-email`(`email`) VALUES('$email')");
                echo $email . "\n";
                $checked[] = $mail;
            }

            $seen[] = $mail;
        }
        $checked = implode(",", $checked);
        imap_clearflag_full($inbox, $checked, "\\Flagged");
        imap_close($inbox);
        return $matches;
    }

    checkEmailForSpam("konkurs-5erka@rambler.ru", "pohjuava", "imap.rambler.ru");
?>