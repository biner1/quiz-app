<?php

namespace App\Config;

use App\Config\View as View;
use App\controller\BaseController as Controller;
use App\Config\exceptions\NotFoundException;

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
        catch(NotFoundException $e){
            $error_page = Application::$ROOT_DIR."/src/View/error.php";
            $this->handleExceptions($e, $error_page);
        }
        catch(\Exception $e){
            $this->handleExceptions($e);
        }
        
    }


    function handleExceptions($exception, $error_page = null){
        if($error_page == null){
            echo $exception->getMessage();
        }else{
            require_once $error_page;
            exit();
        }
    }
}