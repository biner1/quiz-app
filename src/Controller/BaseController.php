<?php

namespace App\Controller;

use App\Config\View;


class BaseController{

    public function render($view, $params = [])
    {
        echo View::render($view, $params);
    }
}