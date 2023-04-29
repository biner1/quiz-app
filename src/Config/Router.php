<?php

namespace App\Config;

use Exception;

class Router {
    private $routes;

    function __construct()
    {
        $this->routes = [];
    }

    function get($route, $action){
        $this->addRoute($route, $action, 'get');
    }
    
    function post($route, $action){
        $this->addRoute($route, $action, 'post');
    }
    
    function addRoute($route, $action, $method){
        // $route = '/mvc/'.$route;
        $this->routes[$method][$route] = $action;
    }

    function getRoute() {
        $url = $_SERVER['REQUEST_URI'];
        $path = parse_url($url, PHP_URL_PATH);
        $route = $path;
        $route = str_replace('/mvc/', '', $path);
        return empty($route) ? '/' : $route;
    }

    // function getRoute($uri = $_SERVER['REQUEST_URI']) {
    //     $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    //     $requestMethod = $_SERVER['REQUEST_METHOD'];
    
    //     $uriSegments = explode('/', $uri);
    //     $requestUriSegments = explode('/', $requestUri);
    
    //     if (count($uriSegments) !== count($requestUriSegments)) {
    //         return null;
    //     }
    
    //     $params = [];
    
    //     for ($i = 0; $i < count($uriSegments); $i++) {
    //         if ($uriSegments[$i][0] === '{' && $uriSegments[$i][strlen($uriSegments[$i]) - 1] === '}') {
    //             $params[] = $requestUriSegments[$i];
    //         } else if ($uriSegments[$i] !== $requestUriSegments[$i]) {
    //             return null;
    //         }
    //     }
    
    //     return $params;
    // }
    
    
    
    function getMethod() {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    function dispatch(){
        $route = $this->getRoute();
        // echo $route;
        $method = $this->getMethod();
        // echo '<pre>';
        // print_r($this->routes);
        // echo '</pre>';

        if(array_key_exists($route, $this->routes[$method])){
            $action = $this->routes[$method][$route];
            // function(){}
            if(is_callable($action)) {
                $action();
            }
            // [UserController::class, 'index']
            else if(is_array($action)){
                $controller = new $action[0]();
                $prop = $action[1];
                $controller->$prop();
            }
            // UserController@index
            else if(is_string($action)){
                $act = explode('@', $action);
                $controller = new $act[0]();
                $prop = $act[1];
                $controller->$prop();
            }
        } else {
            throw new Exception('Route not found!');
        }
    }
    
}