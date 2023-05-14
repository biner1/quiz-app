<?php


namespace App\Controller;

use App\Config\Utilities as utils;
use App\Config\middlewares\AuthMiddleware;

use App\Model\QuizModel as Quiz;
use App\Model\UserModel as User;


class DashboardController extends BaseController{

    public function __construct(){
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function dashboard(){
        $user_id = $_SESSION['id'];

        if(User::isTeacher($_SESSION['id'])){
            $result = Quiz::getAvgScoreAndNumberOfStudents($user_id)[0];
            $quiz_results = Quiz::getAvgScoreAndNumberOfStudentsForEachQuiz($user_id);
            $this->render('quiz/dashboard_teacher', ['result'=>$result, 'quiz_results'=>$quiz_results]);
        }else{
            $quiz_attempts = Quiz::getQuizAttemptsByUser($user_id);
            $result = Quiz::getNumberOfQuizzesTakenAndNumberOfAnswers($user_id)[0]??null;
            return $this->render('quiz/dashboard_student', ['quiz_attempts'=>$quiz_attempts, 'result'=>$result, 'user'=>$_SESSION['user']]);
        }

    }

    public function leaderboard(){
        $results = Quiz::getLeaderboard();
        return $this->render('quiz/leaderboard', ['results'=>$results]);
    }

}