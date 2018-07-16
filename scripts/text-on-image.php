<?php
    class TextOnImage {
        /** Качество jpg по-умолчанияю */
        public   $jpegQuality = 100;  

        /** Цвет текста */
        private $fontColor = false;

        /** Катинка, с которой ма работаем */
        private $image = false;

        /** Адрес TrueType шрифта */
        private $font = false;

        /** Размер текста */
        private $fontSize = 14;

        public function __construct ( $path ) {
            if ( !is_file( $path ) or !list( , , $type ) = getimagesize($path) ) 
            return false;
            
            switch ($type) {
                case 1:  $this->image = @imagecreatefromgif( $path );  break;
                case 2:  $this->image = @imagecreatefromjpeg( $path );  break;
                case 3:  $this->image = @imagecreatefrompng( $path );  break;
            }
        }

        public function __destruct () {
            if ( $this->image ) imagedestroy( $this->image );
        }

        /**
         * Установить параметры шрифта: файл шрифта, размер, цвет
         */
        public function setFont ( $font, $size = false, $color = false ) {
            if ( !is_file($font) ) 
            return false;
            
            $this->font = $font;
            if ( $size ) $this->fontSize = $size;
            if ( $color ) $this->setColor ( $color );
        }

        public function setFontSize ($fontSize) {
            $this->fontSize = $fontSize;
        }

        /**
         * Вывести на картинку текст. isCenterX, isCenterY - нужно ли считать полученные координаты
         * центром текста
         */
        public function write ( $x, $y, $text, $isCenterX = false, $isCenterY = false ) {
            if ( !$this->font or !$this->fontColor or !$this->image )
                return false;
            
            if ( $isCenterX or $isCenterY ) {
                $sizes = imagettfbbox(
                    $this->fontSize, 
                    0, 
                    $this->font, 
                    $text
                ); 
                if ( $isCenterX ) {
                    $width = $sizes[2] - $sizes[0];
                    $x -= $width / 2;
                }
                if ( $isCenterY ) {
                    $height = $sizes[1] - $sizes[7];
                    $y += $height / 2;
                }
            }

            imagettftext(
                $this->image,
                $this->fontSize,
                0,
                $x,
                $y,
                $this->fontColor,
                $this->font,
                $text
            );
        }

        /**
         * Сохранить картинку в файл
         */
        public function output ( $path ) {
            if ( !$this->image ) 
            return false;
            
            $ext = strtolower(substr($path, strrpos($path, ".") + 1)); 

            switch ($ext) 
            {
            case "gif":        
                imagegif ($this->image, $path);        
                break;
                        
            case "jpg" :
            case "jpeg":
                imagejpeg($this->image, $path, $this->jpegQuality);        
                break;
                
            case "png":
                imagepng($this->image, $path);
                break;
                
            default: return false;
            }
        }

        public function setColor($color)
        {
            if (!$this->image) return false; 
            
            list($r, $g, $b) = array_map('hexdec', str_split(ltrim($color, '#'), 2));
            
            $this->fontColor = imagecolorallocate($this->image, $r+1, $g+1, $b+1);   
        }
    }
?>