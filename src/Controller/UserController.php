<?php

namespace App\Controller;

use App\Config\Utilities as utils;
use App\Config\Application;
use App\Config\middlewares\AuthMiddleware;

use App\Model\UserModel as User;


class UserController extends BaseController{


    public function __construct(){
        $this->registerMiddleware(new AuthMiddleware());
    }
    
    public function index(){
        $user = User::getUserById($_SESSION['id'])[0];
        return $this->render('profile/account',['user'=>$user]);
    }


    public function changePassword(){
        if (isset($_POST['change_password'])) {
        
            $password1 = $_POST['password1'];
            $password2 = $_POST['password2'];
        
            if (empty($password1) || empty($password2)) {
                utils::responde(false, ['Error' => 'Password fields cannot be empty']);
                exit();
            }
        
            if (strlen($password2) < 8) {
                utils::responde(false, ['Error' => 'Password should be at least 8 characters long']);
                exit();
            }
        
            $password1 = md5($password1);
            $password2 = md5($password2);
            $id = $_SESSION['id'];
        
            $user = User::changeUserPassword($password1, $password2, $id);
            // $user = ;
            if ($user == 0) {
                utils::responde(false, ['Error' => 'Wrong Current Password']);
                exit();
            }
        
            utils::responde(true);
            exit();
        }
    }


    public function changeImage(){
        if (isset($_POST['update_picture']) && isset($_FILES['image'])) {
            $id = $_SESSION['id'];
            $oldImage = User::getUserImage($id);
        
            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $image = $_FILES['image'];
            $imageExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        
            if (!in_array($imageExtension, $validImageExtension)) {
                utils::responde(false, ['Error' => 'Invalid Image Extension']);
                exit();
            }
        
            if ($image['size'] > 1200000) {
                utils::responde(false, ['Error' => 'Image Size Is Too Large']);
                exit();
            }
            $ROOT_DIR = Application::$ROOT_DIR;
            $newImageName = $id . " - " . date("Y.m.d") . " - " . date("h.i.sa") . '.' . $imageExtension;
            if (User::updateUserImage($id, $newImageName)) {
                $newImagePath = $ROOT_DIR.'/public/upload/' . $newImageName;
                $oldImagePath = $ROOT_DIR.'/public/upload/' . $oldImage;
                echo $newImagePath;

                if (move_uploaded_file($image['tmp_name'], $newImagePath)) {
                    // delete old image
                    if ($oldImage && file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                    utils::responde(true);
                } else {
                    utils::responde(false, ['Error' => 'An error occurred while uploading the image.']);
                }
            } else {
                utils::responde(false, ['Error' => 'An error occurred while updating the user\'s image.']);
            }
        
            exit();
        }
    }


    public function update(){
        if (isset($_POST['update'])) {
            $fullName = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $phone = htmlspecialchars($_POST['phone']);
            $id = $_SESSION['id'];
          
            if (empty($fullName)) {
              utils::responde(false, ['Error' => 'Full name is required']);
              exit();
            }
          
            if (empty($email)) {
              utils::responde(false, ['Error' => 'Email is required']);
              exit();
            }
            
            User::updateUser($fullName, $phone, $email, $id);
            $_SESSION['user'] = $fullName;
            utils::responde(true);
            exit;
          }
    }


}