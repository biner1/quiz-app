<?php

namespace App\Config;

class Application {
    public static string $ROOT_DIR;
    private Router $router;

    function __construct($router, $rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        $this->router = $router;
    }

    function run(){
        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->router->dispatch();
    }
}