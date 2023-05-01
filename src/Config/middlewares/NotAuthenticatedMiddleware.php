<?php


namespace App\Config\middlewares;

use App\Config\Application;
use App\config\Utilities as utils;


class NotAuthenticatedMiddleware extends BaseMiddleware
{

    private $redirect_url;

    public function __construct($redirect_url = "", array $actions = [])
    {
        parent::__construct($actions);
        $this->redirect_url = $redirect_url;
    }

    public function execute()
    {
        if (utils::is_user_authenticated()) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                utils::redirect($this->redirect_url);
            }
        }
    }


}