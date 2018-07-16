<?php
    class CF {
        public static $validClasses = array(
            "outlook-german"    => [1,2,3,4,5,6,7,8,9,10,11],
            "english"           => [1,2,3,4,5,6,7,8,9,10,11],
            "biology"           => [1,2,3,4,5,6,7,8,9,10,11],
            "geography"         => [5,6,7,8,9,10,11],
            "history"           => [5,6,7,8,9,10,11],
            "literature"        => [1,2,3,4,5,6,7,8,9,10,11],
            "logic"             => [1,2,3,4,5,6,7,8,9,10,11],
            "math"              => [1,2,3,4,5,6,7,8,9,10,11],
            "social"            => [5,6,7,8,9,10,11],
            "surround"          => [1,2,3,4,5],
            "russian"           => [1,2,3,4,5,6,7,8,9,10,11],
            "physics"           => [7,8,9,10,11],
            "chemistry"         => [8,9,10,11],
            "erudite"           => [1,2,3,4,5,6,7,8,9,10,11],
            "expert"            => [1,2,3,4,5,6,7,8,9,10,11],
            "rebus"             => [1,2,3,4,5,6,7,8,9,10,11],
            "outlook-english"   => [1,2,3,4,5,6,7,8,9,10,11],
            "physical"          => [1,2,3,4,5,6,7,8,9,10,11],
            "arts"              => [1,2,3,4,5,6,7,8,9,10,11],
            "music"             => [1,2,3,4,5,6,7,8,9,10,11],
            "technology"        => [1,2,3,4,5,6,7,8,9,10,11],
            "books"             => [1,2,3,4,5,6,7,8,9,10,11],
            "citizen"           => [1,2,3,4,5,6,7,8,9,10,11],
            "grammar"           => [1,2,3,4,5,6,7,8,9,10,11],
            "crossword-german"  => [1,2,3,4,5,6,7,8,9,10,11],
            "crossword-english" => [1,2,3,4,5,6,7,8,9,10,11],
            "programmer"        => [1,2,3,4,5,6,7,8,9,10,11],
            "trip"              => [1,2,3,4,5,6,7,8,9,10,11],
            "evrica"            => [1,2,3,4,5,6,7,8,9,10,11],
            "puzzle"            => [1,2,3,4,5,6,7,8,9,10,11],
            "arithmetic"        => [1,2,3,4,5,6,7,8,9,10,11]
        );

        public static function ValidateCompetitions($competitions) {
            $validCompetitions = array();
            foreach ($competitions as $competition) {
                $validClasses = self::$validClasses[$competition[0]] or array();
                $verifedClasses = self::ValidateClasses($competition[2], $validClasses);
                if (count($verifedClasses) > 0) {
                    $validCompetitions[] = array(
                        $competition[0],
                        $competition[1],
                        $verifedClasses
                    );
                }
            }
            return $validCompetitions;
        }

        public static function ValidateClasses($classes, $valid) {
            $verifedClasses = array();
            foreach ($classes as $class) {
                if (in_array($class, $valid)) {
                    $verifedClasses[] = $class;
                }
            }
            return $verifedClasses;
        }

        public static function EncodeClasses($array, $valid){
            if ($s == ''){
                return array();
            }
    
            $temp1 = explode(',', $s);
            $temp2 = array();
            foreach ($temp1 as $item){
                $item = trim($item);
                switch ($item){
                    case "1": $temp2[1] = true; break;
                    case "2": $temp2[2] = true; break;
                    case "3": $temp2[3] = true; break;
                    case "4": $temp2[4] = true; break;
                    case "5": $temp2[5] = true; break;
                    case "6": $temp2[6] = true; break;
                    case "7": $temp2[7] = true; break;
                    case "8": $temp2[8] = true; break;
                    case "9": $temp2[9] = true; break;
                    case "10": $temp2[10] = true; break;
                    case "11": $temp2[11] = true; break;
                }
            }
            $rezArr = array();
            for ($i = 1; $i <= 11; $i++){
                $val = isset($temp2[$i]);
                if ($val){
                    $rezArr[] = $i;
                }
            }

            return $rezArr;
        }
        public static function DecodeClasses($arr = array()){
            $s = implode(', ', $arr);
            return $s;
        }

        /**
         * Преобразовывает полученный массив $_FILES в более удобный вид
         */
        function convert_files($files) {
            $files2 = [];
            foreach ($files as $input => $infoArr) {
                $filesByInput = [];
                foreach ($infoArr as $key => $valueArr) {
                    if (is_array($valueArr)) { // file input "multiple"
                        foreach($valueArr as $i=>$value) {
                            $filesByInput[$i][$key] = $value;
                        }
                    }
                    else { // -> string, normal file input
                        $filesByInput[] = $infoArr;
                        break;
                    }
                }
                $files2 = array_merge($files2,$filesByInput);
            }
            $files3 = [];
            foreach($files2 as $file) { // let's filter empty & errors
                if (!$file['error']) $files3[] = $file;
            }
            return $files3;
        }
    }
?>