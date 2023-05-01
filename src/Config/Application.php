<?php

namespace App\Config;

use App\Config\View as View;
use App\controller\BaseController as Controller;

class Application {
    public static Application $app;
    public static string $ROOT_DIR;
    private Router $router;
    public ?Controller $controller = null;


    function __construct($router, $rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        $this->router = $router;
        self::$app = $this;
    }

    function run(){
        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        try{

            $this->router->dispatch();
        }
        catch(\Exception $e){
            $this->handleExceptions($e);
        }
    }


    function handleExceptions($exception){
        echo View::render('error', ['exception' => $exception]);
    }
}