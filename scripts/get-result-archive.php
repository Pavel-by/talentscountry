<?php
    /**
     * Получить архив грамот
     * ПРАВА ПОЛЬЗОВАТЕЛЯ
     */

    define( 'ROOT', $_SERVER['DOCUMENT_ROOT'] );
    include ( "break-script.php" );
    include ( $_SERVER['DOCUMENT_ROOT'] . "/system/db.php" );
    require_once ( "error-script.php" );
    require_once ( "diploma.php" );

    //Проверяем права
    @session_start ();
    if ( !isset( $_SESSION['usertype'] ) or $_SESSION['usertype'] != 1 ) {
        break_script("Недостаточно прав.");
    }

    $userkey = $_SESSION['userkey'];

    //Проверяем подключение 
    if ( !$link or !mysqli_ping( $link )) {
        echo "Отсутствует подключение к базе данных. Пожалуйста, попробуйте позже.";
        exit();
    }

    //Получаем общие параметры
    $sql = mysqli_query( $link, "SELECT `id`,`school`,`city` FROM `users` WHERE `userkey`='$userkey'" );

    $rez    = mysqli_fetch_array( $sql );
    $id     = $rez['id'];
    $school = $rez['school'];
    $city   = $rez['city'];

    //Проверяем, созданы ли нужные папки
    @mkdir( ROOT . "/results" );
    @mkdir( ROOT . "/results/$id" );
    
    $sql = mysqli_query( $link, "SELECT `name`,`competition`,`place`,`rating`,`class` FROM `results` WHERE `forId`=$id" );
    $dip = new Diploma( ROOT );

    $count = 0;
    $hasWinner = false;
    while( $line = mysqli_fetch_array($sql) ) {

        switch( $line['place'] ) {
            case 1:
                $type = Diploma::TYPE_DIPLOMA_1; 
                $values = array(
                    $line['name'],
                    "$city, $school",
                    $line['competition'] 
                );
                $hasWinner = true;
                break;
            case 2:
                $type = Diploma::TYPE_DIPLOMA_2; 
                $values = array(
                    $line['name'],
                    "$city, $school",
                    $line['competition'] 
                );
                $hasWinner = true;
                break;
            case 3:
                $type = Diploma::TYPE_DIPLOMA_3; 
                $values = array(
                    $line['name'],
                    "$city, $school",
                    $line['competition'] 
                );
                $hasWinner = true;
                break;
            default:
                $type = Diploma::TYPE_SERTIFICATE; 
                $values = array(
                    $line['name'],
                    "$school, " . $line['class'] . " класс",
                    $line['competition'],
                    $line['rating']
                );
                break;
        }

        $dip->diploma(
            false,
            "results/$id/" . $line['name'] . ", " . $line['competition'] . ".jpg",
            $values,
            $type
        );

        $count += 1;
    }

    if( $count >= 50 ) {
        $dip->diploma(
            false,
            "/results/$id/Благодарственное письмо школе.jpg",
            array(
                $school,
                $city
            ),
            Diploma::TYPE_THANKS_SCHOOL
        );
        copy( ROOT . "/images/diploma/7.jpg", ROOT . "/results/$id/Благодарственное письмо учителю.jpg" );
        if( $hasWinner ) {
            copy( ROOT . "/images/diploma/5.jpg", ROOT . "/results/$id/Благодарственное письмо учителю за подготовку призера конкурса.jpg" );
        }
    }

    //Заносим в архив
    $filesDir = ROOT . "/results/$id";
    $files = scandir( $filesDir );

    $zipName    = ROOT . "/results/$id/results.zip";
    $zip        = new ZipArchive();
    if( $zip->open( $zipName, ZIPARCHIVE::CREATE ) !== TRUE ){
        echo "<h1>Ошибка при попытке создания архива. Пожалуйста, попробуйте позже</h1>";
        exit();
    }

    foreach( $files as $file ) {
        if( $file == "." or $file == ".." ) continue;
        $zip->addFile( "$filesDir/$file", $file );
    }

    //Добавляем пустые бланки
    /*foreach( scandir( ROOT . "/images/diploma" ) as $file ) {
        if( $file == "." or $file == ".." ) continue;
        $zip->addFile(ROOT . "/images/diploma/$file", "Если программа заполнила неправильно/$file");
    }*/
    
    $zip->close();
    if (file_exists($zipName)){
        header('Content-type: application/zip');
        header('Content-Disposition: attachment; filename="Результаты конкурса.zip"');
        readfile($zipName);
        unlink($zipName);
    }
    else{
        echo "<h1>Ошибка при попытке создания архива. Пожалуйста, попробуйте позже</h1>";
    }
    
    $files = scandir( $filesDir );
    foreach( $files as $file ) {
        if( $file == "." or $file == ".." ) continue;
        unlink( ROOT . "/results/$id/$file" );
    }

?>