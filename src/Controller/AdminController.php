<?php

namespace App\Controller;

use App\Config\Utilities as utils;
use App\Model\UserModel as User;
use App\Model\QuizModel as Quiz;
use App\Config\middlewares\AuthMiddleware;
use App\Config\middlewares\IsAdminMiddleware;

class AdminController extends BaseController
{

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware());
        $this->registerMiddleware(new IsAdminMiddleware('dashboard'));
    }

    public function index()
    {


        if (isset($_GET['user'])) {
            $id = $_GET['user'];
            $user = User::getUserById($id)[0];

            if ($user['is_teacher'] == 1) {
                $quizzes = Quiz::getQuizzesByUser($id);
            } else {
                $quizzes = Quiz::getAttemptedQuizzesByUser($id);
            }

            return $this->render('admin/user', ['user' => $user, 'quizzes' => $quizzes]);
        } else {
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $users = User::searchUsers($_GET['search']);
            } else {
                $users = User::getUsers();
            }
            return $this->render('admin/users', ['users' => $users]);
        }

    }

    public function updateUser()
    {
        $id = $_POST['id'];

        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $is_teacher = isset($_POST['is_teacher']) && $_POST['is_teacher'] === '1';
        $is_admin = isset($_POST['is_admin']) && $_POST['is_admin'] === '1';


        if (empty($name)) {
            utils::responde(false, ['Error' => 'Name is required']);
            exit();
        }

        if (empty($email)) {
            utils::responde(false, ['Error' => 'Email is required']);
            exit();
        }

        User::updateUserInformation($name, $phone, $email, $is_teacher, $is_admin, $id);
        utils::responde(true);
    }

    public function changeUserPassword()
    {

        $password = $_POST['password'];

        if (empty($password)) {
            utils::responde(false, ['Error' => 'Password fields cannot be empty']);
        }

        $password = md5($password);
        $id = $_POST['id'];

        $user = User::changePassword($password, $id);
        if ($user == 0) {
            utils::responde(false, ['Error' => 'Password could not be changed']);
        }

        utils::responde(true, ['Success' => 'Password changed successfully']);
    }

    public function deleteUser()
    {
        $user_id = $_GET['user_id'];
        if (isset($_GET['user_id'])) {
            $user = User::deleteUser($user_id);
            if ($user == 0) {
                utils::responde(false, ['Error' => 'User could not be deleted']);
            }
            utils::responde(true, ['Success' => 'User deleted successfully']);
        }
    }



}