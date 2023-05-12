<?php

namespace App\Controller;

use App\Config\Utilities as utils;
use App\Config\middlewares\AuthMiddleware;
use App\Config\middlewares\IsAdminMiddleware;
use App\Model\UserModel as User;

class AdminController extends BaseController{

    public function __construct(){
        $this->registerMiddleware(new AuthMiddleware());
        // $this->registerMiddleware(new IsAdminMiddleware('dashboard'));
    }

    public function index(){
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $user = User::getUserById($id)[0];
            print_r($user);
            return $this->render('admin/user', ['user'=>$user]);
        }else{
            $users = User::getUsers();
            return $this->render('admin/users', ['users'=>$users]);
        }
  
    }
}