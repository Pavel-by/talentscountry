<?php

if ( !defined( "ROOT" ) ) define( "ROOT", $_SERVER[ 'DOCUMENT_ROOT' ] );

class Tasks
{
    const TASKS_DIR = "/files/task";

    private $tasks;

    public function __construct()
    {
        $map = json_decode(file_get_contents( ROOT . "/files/tasks-map.json" ), true);
        foreach ( $map as $eng => $rus ) {
            $class = array();
            $files = scandir( ROOT . self::TASKS_DIR . "/$eng" );
            foreach ( $files as $file ) {
                if ($file == "." or $file == "..") continue;
                $class[] = $this->findInt($file);
            }
            $class = array_unique($class);
            sort($class);
            $this->tasks[] = array(
                "eng" => $eng,
                "rus" => $rus,
                "class" => $class
            );
        }
    }

    public function getTasks() {
        return $this->tasks;
    }

    public function hasTask($category, $class) {
        foreach ($this->tasks as $task) {
            if ($task['eng'] == $category and in_array($class, $task['class'])) return true;
        }
        return false;
    }

    public function getTaskPath($category, $class) {
        $taskDir = ROOT . self::TASKS_DIR . "/$category";
        if (!$this->hasTask($category, $class) or !is_dir($taskDir)) return false;
        $files = scandir( self::TASKS_DIR );
        foreach ($files as $file) {
            if ($this->findInt($file) == $class) {
                return self::TASKS_DIR . "/$category/$file";
            }
        }
        return false;
    }

    private function findInt( $s )
    {
        return (int)preg_replace( '/[^0-9]/', '', $s );
    }
}