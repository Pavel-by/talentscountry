<?php

if ( !defined( "ROOT" ) ) define( "ROOT", $_SERVER[ 'DOCUMENT_ROOT' ] );

require_once ROOT . "/class/Tasks.php";

$tasks = new Tasks();

?>

<script type="text/javascript">
    var Tasks = new function() {
        var competitions = $.parseJSON("<?php echo addslashes(json_encode($tasks->getTasks())); ?>");

        this.getTasks = function() {
            return competitions;
        };
    };
</script>