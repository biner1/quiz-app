<?php

namespace App\Controller;

use App\Config\View;
use App\Config\middlewares\BaseMiddleware;


class BaseController{

    public string $action = '';

    /**
     * @var \App\Config\middlewares\BaseMiddleware[]
     */
    public array $middlewares = [];

    public function render($view, $params = [])
    {
        return View::render($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware){
        $this->middlewares[] = $middleware;

    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    public function hasMiddlewares(): bool
    {
        return count($this->middlewares) > 0;
    }


}