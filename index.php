<?php

require_once __DIR__ .'/vendor/autoload.php';

use App\Config\Application;
use App\Config\Router;

use App\Controller\AdminController;
use App\Controller\UserController;
use App\Controller\HomeController;
use App\Controller\AuthController;
use App\Controller\QuizController;
use App\Controller\QuestionController;
use App\Controller\OptionController;
use App\Controller\QuizStudentController;
use App\Controller\DashboardController;


$router = new Router();


$router->get('/', [HomeController::class, 'index']);
$router->get('login', [AuthController::class, 'login']);
$router->get('signup', [AuthController::class, 'signup']);
$router->get('logout', [AuthController::class, 'logout']);
$router->post('login', [AuthController::class, 'login']);
$router->post('signup', [AuthController::class, 'signup']);

$router->get('admin/users', [AdminController::class, 'index']);
$router->post('admin/users/update', [AdminController::class, 'updateUser']);
$router->post('admin/users/password', [AdminController::class, 'changeUserPassword']);
$router->get('admin/users/delete', [AdminController::class, 'deleteUser']);


$router->get('quiz', [QuizController::class, 'show']);
$router->get('quizzes', [QuizController::class, 'index']);
$router->get('quiz/delete', [QuizController::class, 'delete']);
$router->get('quiz/result', [QuizController::class, 'result']);
$router->post('quiz/update', [QuizController::class, 'update']);
$router->post('quiz/store', [QuizController::class, 'store']);
$router->post('quiz/take', [QuizStudentController::class, 'store']);
$router->post('quiz/take/one', [QuizStudentController::class, 'take']);


$router->post('all', [QuizController::class, 'all']);

$router->get('question/delete', [QuestionController::class, 'delete']);
$router->post('question/store', [QuestionController::class, 'store']);
$router->post('question/update', [QuestionController::class, 'update']);

$router->get('option/delete', [OptionController::class, 'delete']);
$router->post('option/store', [OptionController::class, 'store']);
$router->post('option/update', [OptionController::class, 'update']);

$router->get('leaderboard', [DashboardController::class, 'leaderboard']);
$router->get('dashboard', [DashboardController::class, 'dashboard']);

$router->get('account', [UserController::class, 'index']);
$router->post('account/update', [UserController::class, 'update']);
$router->post('account/password', [UserController::class, 'changePassword']);
$router->post('account/image', [UserController::class, 'changeImage']);






$app = new Application($router, __DIR__);

$app->run();
