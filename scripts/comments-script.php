<?php
include( $_SERVER[ 'DOCUMENT_ROOT' ] . '/system/db.php' );
include( $_SERVER[ 'DOCUMENT_ROOT' ] . '/scripts/error-script.php' );
include( $_SERVER[ 'DOCUMENT_ROOT' ] . '/scripts/break-script.php' );
@session_start();

if ( !isset( $_SESSION[ 'usertype' ] ) or
    !isset( $_SESSION[ 'userkey' ] ) or
    $_SESSION[ 'usertype' ] != 1 ) {
    break_script( 'Недостаточно прав для совершения операции' );
}

if ( !isset( $_GET[ 'text' ] ) ) {
    break_script( 'Отсутствует текст сообщения' );
}

if ( !$link ) {
    break_script( 'Отсутствует подключение к базе данных' );
}

$userkey = $_SESSION[ 'userkey' ];
$text    = mysqli_real_escape_string( $link, $_GET[ 'text' ] );

$sql = mysqli_query( $link, "SELECT `name` FROM `users` WHERE `userkey`='$userkey'" );

if ( !$sql or !( $sql = mysqli_fetch_array( $sql ) ) ) {
    log::e( 'SQL: ' . mysqli_error( $link ) );
    break_script( 'Ошибка при попытке подключения к базе данных' );
}

$name = mysqli_real_escape_string( $link, $sql[ 'name' ] );

if ( strlen( $text ) == 0 ) {
    $sql = mysqli_query($link, "DELETE FROM `comments` WHERE `userkey`='$userkey'");
} else {
    $sql = mysqli_query( $link,
        "REPLACE INTO `comments`(`userkey`,`name`,`text`) VALUES ('$userkey','$name','$text')" );
}

if ( !$sql ) {
    log::e( 'SQL: ' . mysqli_error( $link ) );
    log::e( "REPLACE INTO `comments`(`userkey`,`name`,`text`) VALUES ('$userkey','$name','$text')" );
    break_script( "Ошибка при попытке подключения к базе данных" );
}

$arr = array( 'error'     => false,
              'texterror' => false );

echo json_encode( $arr );
?>