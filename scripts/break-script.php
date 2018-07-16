<?php
    function break_script($message = ""){
        $arr = array(
            "error" => true,
            "texterror" => $message
        );
        echo json_encode($arr);
        exit();
    }

    function end_script($message = "") {
        $arr = array(
            "error" => false,
            "texterror" => $message
        );
        echo json_encode($arr);
        exit();
    }
?>