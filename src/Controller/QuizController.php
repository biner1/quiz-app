<?php

namespace App\Controller;

use App\Config\Utilities as utils;
use App\Config\middlewares\AuthMiddleware;


use App\Model\QuizModel as Quiz;
use App\Model\UserModel as User;


class QuizController extends BaseController{

    public function __construct(){
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function index(){
        if(User::isTeacher($_SESSION['id'])){
            $quizzes = Quiz::getQuizzesByUser(utils::getSession('id'));
            return  $this->render('quiz/quizzes_teacher', ['quizzes'=>$quizzes]);
        }else{
            $quizzes = Quiz::getSubmittableQuizzes();
            return $this->render('quiz/quizzes_student', ['quizzes'=>$quizzes]);
        }
    }

    
    public function show(){
        $quiz = array();
        $questions = array();
        if(!isset($_GET['id'])){
            utils::redirect('quizzes');
        }

        $user_id = utils::getSession('id');
        $quiz_id = $_GET['id'];

        if(User::isTeacher($user_id)){
            $quiz = Quiz::getQuizByUser($quiz_id, $user_id);
            if(!$quiz){
                utils::redirect('quizzes');
            }
            $questions = Quiz::getQuestionsAndOptionsOfQuiz($quiz_id);
            // echo "<pre>";
            // print_r($questions);
            // echo "</pre>";
            // exit();
            return $this->render('quiz/quiz_teacher', ['quiz'=>$quiz, 'questions'=>$questions]);
        
        }else{
            $questions = Quiz::getQuestionsAndOptionsOfQuiz($quiz_id);
            return $this->render('quiz/quiz_student', ['questions'=>$questions]);
        }
    }


    public function store(){
        if(isset($_POST['create_quiz'])){
            $title = $_POST['quiz_title'];
            $description = $_POST['quiz_description'];
            if (empty($description)) {
                $description = null;
            }
            $user_id = $_SESSION['id'];
            $user = User::getUserById($user_id);
        
            $quiz = Quiz::createQuiz($title, $description, $user_id);
            if($quiz){
                utils::responde(true);
            }else{
                utils::responde(false, ['Error'=>'Error creating quiz']);
            }
        }
    }


    public function update(){
        if(isset($_POST['update_quiz'])){
            $title = $_POST['quiz_title'];
            $quiz_id = $_POST['update_quiz'];
            $description = $_POST['quiz_description'];
            $submittable = isset($_POST['submittable']) && $_POST['submittable'] === '1';

            $quiz = Quiz::updateQuiz($quiz_id, $title, $description, $submittable, utils::getSession('id'));
            if($quiz){
                utils::responde(true);
            }else{
                utils::responde(false, ['Error'=>'Quiz not updated with id '.$quiz_id]);
            }
        }
    }


    public function delete(){
        if(isset($_GET['id'])){
            $quiz_id = $_GET['id'];
            $quiz = Quiz::deleteQuiz($quiz_id);
            if($quiz){
                utils::responde(true);
            }else{
                utils::responde(false, ['Error'=>'Error deleting quiz with id '.$quiz_id]);
            }
        }
    }
    

}
