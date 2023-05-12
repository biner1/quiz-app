<?php


namespace App\Config\middlewares;

use App\config\Utilities as utils;
use App\Config\Application;
use App\Config\exceptions\ForbiddenException;
use App\Model\UserModel as User;

class IsAdminMiddleware extends BaseMiddleware
{
    private $redirect_url;


    public function __construct($redirect_url = "dashboard", array $actions = [])
    {
        parent::__construct($actions);
        $this->redirect_url = $redirect_url;
    }
    
    public function execute()
    {
        if (!User::isAdmin($_SESSION['id'])) {
            if (empty($this->actions || in_array(Application::$app->controller->action, $this->actions))) {
                // throw new ForbiddenException();
                utils::redirect($this->redirect_url);
            }
        }
    }


}