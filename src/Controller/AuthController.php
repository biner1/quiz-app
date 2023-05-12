<?php

namespace App\Controller;

use App\Config\Utilities as utils;
use App\Config\middlewares\NotAuthenticatedMiddleware;

use App\Model\UserModel as User;

class AuthController extends BaseController{

    public function __construct(){
        $this->registerMiddleware(new NotAuthenticatedMiddleware('dashboard', ['login', 'signup']));
    }

    public function login(){
        if(utils::is_post()){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password = md5($password);
        
            $user = User::getUserByEmailPassword($email, $password);
        
            if (!empty($user)) {
                $user = $user[0];
                utils::setSession('id', $user['id']);
                utils::setSession('user', $user['name']);
                utils::setSession('is_teacher', $user['is_teacher']);
                utils::setSession('is_admin', $user['is_admin']);
                
                utils::responde(true);
                // utils::redirect('dashboard');
            } else {
                utils::responde(false, ['Error' => 'Wrong email or password']);
            }
            
        }else{
            return $this->render('auth/login');
        }

    }


    public function signup(){
        if (utils::is_post()) {
        
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $is_teacher = isset($_POST['is_teacher']) && $_POST['is_teacher'] === '1';
        
            $errors = utils::validateSignupInputs($name, $email, $password, $confirm_password);
            
          if (empty($errors)) {
                $passwordRegister = md5($password);
                 $user = User::createUser($email, $passwordRegister, $name, $is_teacher);
                
                if ($user) {
                        utils::responde(true);
                } else {
                        utils::responde(false);
                }
          }else{
            utils::responde(false, $errors);
          }
        }else{
            return $this->render('auth/signup');
        }

    }


    public function logout(){
        utils::destroySession();
        utils::redirect('login');
    }


}