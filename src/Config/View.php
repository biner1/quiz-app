<?php

namespace App\Config;
use Exception;

class View {
    static function render($view, $data=[]){
        $view_file = Application::$ROOT_DIR."/src/View/$view.php";
        if(file_exists($view_file)){
            $layoutContent = View::layoutContent();
            $viewContent = View::renderOnlyView($view, $data);
            echo str_replace('{{content}}', $viewContent, $layoutContent);
        }
        else {
            throw new Exception('View not found!');
        }
    }


    static function layoutContent(){
        ob_start();
        include_once Application::$ROOT_DIR."/src/view/layout/base.php";
        return ob_get_clean();
    }

    static function renderOnlyView($view, array $params = []){
        extract($params);

        ob_start();
        $view_file = Application::$ROOT_DIR."/src/view/$view.php";
        include_once $view_file;
        return ob_get_clean();
    }

}