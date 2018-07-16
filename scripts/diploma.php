<?php
    require_once ( "text-on-image.php" );

    class Diploma {
        /**Диплом 1 степени */
        const TYPE_DIPLOMA_1         = 1;

        /**Диплом 2 степени */
        const TYPE_DIPLOMA_2         = 2;

        /**Диплом 3 степени */
        const TYPE_DIPLOMA_3         = 3;

        /**Сертификат участника */
        const TYPE_SERTIFICATE       = 4;

        /**Благодарственное письмо школе */
        const TYPE_THANKS_SCHOOL     = 5;

        /**Благодарственное письмо учителю - организатору */
        const TYPE_THANKS_TEACHER    = 6;

        /**Благодарственное письмо за подготовку призера */
        const TYPE_THANKS_FOR_WINNER = 7;

        /**Параметры */
        const X              = 'x';
        const Y              = 'y';
        const IS_CENTER_X    = 'isCenterX';
        const IS_CENTER_Y    = 'isCenterY';

        private $rootDirectory  = false;
        private $font           = "fonts/Firasansmedium.ttf";
        private $fontSize       = 30;
        private $fontColor      = "#383838";

        /**
         * rootSiteDirectory - Корневая папка сайта
         */
        public function __construct ( $rootSiteDirectory ) {
            $this->rootDirectory = $rootSiteDirectory;
        }

        /**
         * @param false|string $filePath Адрес исходой картинки, FALSE если берем по умолчанию
         * @param string $savePath Куда сохранять; путь от КОРНЕВОЙ ДИРЕКТОРИИ САЙТА
         * @param array $values Значения для заполнения
         * @param 1|2|3|4|5|7|6 $type Тип бланка - TYPE_DIPLOMA_1, TYPE_DIPLOMA_2 и т.д.
         * @return bool
         */
        public function diploma (
            $filePath,  // Адрес исходой картинки, FALSE если берем по умолчанию
            $savePath,  // Куда сохранять; путь от КОРНЕВОЙ ДИРЕКТОРИИ САЙТА
            $values,    // Значения для заполнения
            $type       // Тип бланка - TYPE_DIPLOMA_1, TYPE_DIPLOMA_2 и т.д.
        ) {
            // Если среди настроек нет запрошеной или количество полей для
            // вывода превышает максимально возможное для этого бланка, то
            // не можем выполнить операцию
            if ( !isset( $this->settings[ $type ] ) or
                count( $this->settings[ $type] ) < count( $values ) ) return false;
            
            //Пока нетути школы у нас
            if ($type == self::TYPE_THANKS_SCHOOL) {
                return false;
            }

            //Получаем путь по умолчанию, если надо
            if ( $filePath == FALSE ) {
                $filePath = $this->getPath ( $type );
            }

            $settings = $this->settings[$type];

            //Создаем объект картинки
            $img = new TextOnImage($filePath);
            //Если не удалось создать
            if ( !$img ) return false;
            $img->setFont ( $this->getFont(), $this->getFontSize($type), $this->getFontColor() );

            //Заполняем
            for ( $i = 0; $i < count($values); $i++ ) {
                //Это для % в сертификате
                if( $type == self::TYPE_SERTIFICATE and $i == 3 ) {
                    $img->setFontSize( 100 );
                    $img->setColor( "#505FA4" );
                }
                $img->write ( 
                    $settings   [$i][self::X],
                    $settings   [$i][self::Y],
                    $values     [$i],
                    $settings   [$i][self::IS_CENTER_X],
                    $settings   [$i][self::IS_CENTER_Y]
                );
                if( $type == self::TYPE_SERTIFICATE and $i == 3 ) {
                    $img->setFontSize( $this->getFontSize() );
                    $img->setColor( $this->getFontColor() );
                }
            }

            //Выводим
            $img->output ( $this->rootDirectory . "/" . $savePath );

            return true;
        }

        public function getFont () {
            return $this->rootDirectory . "/" . $this->font;
        }

        public function getFontColor () {
            return $this->fontColor;
        }

        public function getFontSize ($type = false) {
            if ($type == false) {
                return $this->fontSize;                
            }
            return $this->fontSizes[$type];
        }

        private function getPath ( $type ) {
            return $this->rootDirectory . "/" . $this->ways[ $type ];
        }

        /**
         * Пути к файлам по умолчанию, от корневой директории
         */
        private $ways = array (
            self::TYPE_DIPLOMA_1          => "images/diploma/1.jpg",
            self::TYPE_DIPLOMA_2          => "images/diploma/2.jpg",
            self::TYPE_DIPLOMA_3          => "images/diploma/3.jpg",
            self::TYPE_SERTIFICATE        => "images/diploma/4.jpg",
            self::TYPE_THANKS_FOR_WINNER  => "images/diploma/5.jpg",
            self::TYPE_THANKS_SCHOOL      => "images/diploma/6.jpg",
            self::TYPE_THANKS_TEACHER     => "images/diploma/7.jpg"
        );

        /** Настройки: X, Y, необходимость центровать по X, необходимость центровать по Y */
        private $settings = array (
            self::TYPE_DIPLOMA_1 => array (
                //Имя
                array (
                    self::X           => 860,
                    self::Y           => 992,
                    self::IS_CENTER_X => true,
                    self::IS_CENTER_Y => false
                ),
                //Город, ОУ
                array (
                    self::X           => 850,
                    self::Y           => 1120,
                    self::IS_CENTER_X => true,
                    self::IS_CENTER_Y => false
                ),
                //Конкурс
                array (
                    self::X           => 837,
                    self::Y           => 1257,
                    self::IS_CENTER_X => true,
                    self::IS_CENTER_Y => false
                )
            ),

            self::TYPE_DIPLOMA_2 => array (
                //Имя
                array (
                    self::X           => 1230,
                    self::Y           => 1508,
                    self::IS_CENTER_X => true,
                    self::IS_CENTER_Y => false
                ),
                //Город, ОУ
                array (
                    self::X           => 1230,
                    self::Y           => 1697,
                    self::IS_CENTER_X => true,
                    self::IS_CENTER_Y => false
                ),
                //Конкурс
                array (
                    self::X           => 1230,
                    self::Y           => 1908,
                    self::IS_CENTER_X => true,
                    self::IS_CENTER_Y => false
                )
            ),

            self::TYPE_DIPLOMA_3 => array (
                //Имя
                array (
                    self::X           => 1235,
                    self::Y           => 1450,
                    self::IS_CENTER_X => true,
                    self::IS_CENTER_Y => false
                ),
                //Город, ОУ
                array (
                    self::X           => 1230,
                    self::Y           => 1645,
                    self::IS_CENTER_X => true,
                    self::IS_CENTER_Y => false
                ),
                //Конкурс
                array (
                    self::X           => 1235,
                    self::Y           => 1850,
                    self::IS_CENTER_X => true,
                    self::IS_CENTER_Y => false
                )
            ),

            self::TYPE_SERTIFICATE => array (
                //Имя
                array (
                    self::X           => 120,
                    self::Y           => 335,
                    self::IS_CENTER_X => false,
                    self::IS_CENTER_Y => false
                ),
                //Школа, класс
                array (
                    self::X           => 120,
                    self::Y           => 398,
                    self::IS_CENTER_X => false,
                    self::IS_CENTER_Y => false
                ),
                //Конкурс
                array (
                    self::X           => 120,
                    self::Y           => 450,
                    self::IS_CENTER_X => false,
                    self::IS_CENTER_Y => false
                ),
                //% баллов
                array (
                    self::X           => 745,
                    self::Y           => 790,
                    self::IS_CENTER_X => true,
                    self::IS_CENTER_Y => true
                )
            ),
            
            self::TYPE_THANKS_SCHOOL => array (
                //ОУ
                array (
                    self::X           => 1300,
                    self::Y           => 1770,
                    self::IS_CENTER_X => true,
                    self::IS_CENTER_Y => false
                ),
                //Город
                array (
                    self::X           => 1300,
                    self::Y           => 2015,
                    self::IS_CENTER_X => true,
                    self::IS_CENTER_Y => false
                )
            ),
            
            self::TYPE_THANKS_TEACHER => array (
                //ОУ
                array (
                    self::X           => 820,
                    self::Y           => 952,
                    self::IS_CENTER_X => true,
                    self::IS_CENTER_Y => false
                ),
                //Город
                array (
                    self::X           => 820,
                    self::Y           => 1056,
                    self::IS_CENTER_X => true,
                    self::IS_CENTER_Y => false
                )
            ),
            
            self::TYPE_THANKS_FOR_WINNER => array (
                //ОУ
                array (
                    self::X           => 810,
                    self::Y           => 1025,
                    self::IS_CENTER_X => true,
                    self::IS_CENTER_Y => false
                ),
                //Город
                array (
                    self::X           => 810,
                    self::Y           => 1160,
                    self::IS_CENTER_X => true,
                    self::IS_CENTER_Y => false
                )
            )
        );

        private $fontSizes = array(
            self::TYPE_DIPLOMA_1 => 30,
            self::TYPE_DIPLOMA_2 => 40,
            self::TYPE_DIPLOMA_3 => 40,
            self::TYPE_SERTIFICATE => 20,
            self::TYPE_THANKS_TEACHER => 30,
            self::TYPE_THANKS_FOR_WINNER => 30
        );
    }
?>