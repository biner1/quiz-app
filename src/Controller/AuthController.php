<?php

namespace App\Controller;

use App\Config\View;

use App\Model\UserModel as User;
use App\Config\Utilities as utils;

class AuthController extends BaseController{

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
                utils::responde(true);
                // utils::redirect('dashboard');
            } else {
                utils::responde(false, ['Error' => 'Wrong email or password']);
            }
            
        }else{
            $this->render('auth/login');
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
            $this->render('auth/signup');
        }

    }


    public function logout(){
        utils::destroySession();
        utils::redirect('quiz');
    }


}