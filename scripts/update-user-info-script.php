<?php

ini_set( "display_errors", "1" );

error_reporting( E_ALL );
@session_start();
include( $_SERVER[ 'DOCUMENT_ROOT' ] . '/system/db.php' );
include( $_SERVER[ 'DOCUMENT_ROOT' ] . '/scripts/error-script.php' );
require_once "common-functions.php";

if ( $link ) {
    if ( isset( $_SESSION[ 'usertype' ] ) and $_SESSION[ 'usertype' ] == 2 ) {
        $arr = array(
            "error"     => false,
            "etxterror" => false
        );
        if ( !isset( $_GET[ 'id' ] ) ) {
            $arr[ 'error' ]     = true;
            $arr[ 'texterror' ] = "Не указан ID пользователя.";
            echo json_encode( $arr );
            exit();
        } else {
            $id = mysqli_real_escape_string( $link, $_GET[ 'id' ] );
        }

        if ( !isset( $_GET[ 'type' ] ) ) {
            $arr[ 'error' ]     = true;
            $arr[ 'texterror' ] = "Не указан новый тип аккаунта пользователя.";
            echo json_encode( $arr );
            exit();
        } else {
            switch ( $_GET[ 'type' ] ) {
                case '0':
                    $type = 0;
                    break;
                case '1':
                    $type = 1;
                    break;
                default:
                    $arr[ 'error' ]     = true;
                    $arr[ 'texterror' ] = "Неверный формат типа пользователя.";
                    echo json_encode( $arr );
                    exit();
            }
        }

        if ( $link ) {
            $rez = mysqli_query( $link, "UPDATE `users` SET `usertype`=$type WHERE `id`=$id" );
            if ( !$rez or $rez == 0 ) {
                $arr[ 'error' ]     = true;
                $arr[ 'texterror' ] = "Ошибка при подключении к базе данных.";
                log::e( 'SQL: ' . mysqli_error( $link ) );
            } else {
                log::action( $_SESSION[ 'userkey' ], "CHANGE USER <$id> ACCESS TO $type" );
            }
        } else {
            $arr[ 'error' ]     = true;
            $arr[ 'texterror' ] = "Ошибка при подключении к базе данных.";
            log::e( "SQL: CONNECTION ERROR" );
        }
        echo json_encode( $arr );

    } else if ( isset( $_SESSION[ 'userkey' ] ) ) {
        $arr                = array();
        $arr[ 'error' ]     = false;
        $arr[ 'texterror' ] = false;
        $userkey            = $_SESSION[ 'userkey' ];

        $min = 4;
        $max = 255;

        //ФИО
        $name = mysqli_real_escape_string(
            $link,
            validateString( $_GET[ 'name' ], $min, $max, "Неверно введено ФИО." )
        );

        //Область/край
        $region = mysqli_real_escape_string(
            $link,
            validateString( $_GET[ 'region' ], 0, $max, "Неверно введена область." )
        );

        //Город
        $city = mysqli_real_escape_string(
            $link,
            validateString( $_GET[ 'city' ], 0, $max, "Неверно введен город." )
        );

        //Школа
        $school = mysqli_real_escape_string(
            $link,
            validateString( $_GET[ 'school' ], $min, $max, "Неверно введено название школы." )
        );

        //Учителя
        $teachers = mysqli_real_escape_string(
            $link,
            validateInt( $_GET[ 'teachers' ], 0, 999999, "Неверное количество учителей." )
        );

        //Участники
        $participants = mysqli_real_escape_string(
            $link,
            validateInt( $_GET[ 'participants' ], 0, 999999, "Неверное количество участников." )
        );

        //Почта
        $post        = 0;
        $postcode    = "";
        $postaddress = "";
        $postname    = "";
        if ( isset( $_GET[ 'post' ] ) ) {
            $post        = 1;
            $postcode    = mysqli_real_escape_string(
                $link,
                validateString( $_GET[ 'postcode' ], 0, $max, "Неверно введен почтовый индекс." )
            );
            $postaddress = mysqli_real_escape_string(
                $link,
                validateString( $_GET[ 'postaddress' ], 0, $max, "Неверно введен почтовый адрес." )
            );
            $postname    = mysqli_real_escape_string(
                $link,
                validateString( $_GET[ 'postname' ], 0, $max, "Неверно введено имя получателя." )
            );
        }

        //Номера классов
        $competitions = array();
        if ( isset( $_GET[ 'competitions' ] ) ) {
            $competitions = json_decode( $_GET[ 'competitions' ], true );
        }
        //$competitions = CF::ValidateCompetitions( $competitions );
        $classes      = json_encode( $competitions, JSON_UNESCAPED_UNICODE );

        //Телефон
        $phone = mysqli_real_escape_string(
            $link,
            validateString( $_GET[ 'phone' ], $min, $max, "Неверно введен номер телефона." )
        );

        //E-mail
        $email = mysqli_real_escape_string(
            $link,
            validateString( $_GET[ 'email' ], $min, $max, "Неверно введен номер Email." )
        );

        if ( $arr[ 'error' ] == false ) {
            $rez = mysqli_query( $link, "SELECT COUNT(*) FROM `users` WHERE `email`='$email' and `userkey`!='$userkey'" );
            if ( !$rez ) {
                $arr[ 'error' ] = true;
                log::e( mysqli_error( $link ) );
            } else {
                $rez = mysqli_fetch_array( $rez );
                if ( $rez[ 'COUNT(*)' ] > 0 ) {
                    $arr[ 'error' ]     = true;
                    $arr[ 'texterror' ] = "Пользователь с таким E-mail уже зарегистрирован!";
                } else {
                    $rez = mysqli_query( $link, "UPDATE `users` SET `name`='$name',`region`='$region',`city`='$city',`school`='$school',`postcode`='$postcode',`classes`='$classes',`email`='$email',`phone`='$phone' WHERE `userkey`='$userkey'" );
                    if ( !$rez ) {
                        $arr[ 'error' ] = true;
                        log::e( mysqli_error( $link ) );
                    } else {
                        log::sql( $link, "Изменение данных" );
                    }
                }
            }
        }

        echo json_encode( $arr );
    } else {
        log::e( 'update-user-info-script.php: отсутствие ключа пользователя.' );
        $arr = array(
            'error'     => true,
            'texterror' => "Серверная ошибка. Пожалуйста, <a href='login.php'>перезайдите</a> в систему."
        );
        echo json_encode( $arr );
    }
} else {
    log::e( 'update-user-info-script.php: ошибка подключения к базе данных' );
    $arr = array(
        'error'     => true,
        'texterror' => "Серверная ошибка. Пожалуйста, попробуйте позже."
    );
    echo json_encode( $arr );
}

function validateString( $value, $minLen = 0, $maxLen = 100, $ifNot = "" )
{
    if ( !isset( $value )
        or strlen( $value ) < $minLen
        or strlen( $value ) > $maxLen ) {
        break_script( $ifNot );
    }
    return $value;
}

function validateInt( $val, $min = 0, $max = 999999, $ifNot = "" )
{
    if ( strlen( $val ) == 0 ) {
        $val = '0';
    }
    if ( !isset( $val )
        or !is_numeric( $val )
        or $min > (int)$val
        or $max < (int)$val ) {
        break_script( $ifNot );
    }
    return (int)$val;
}