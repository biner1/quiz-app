<?php

namespace App\Controller;

use App\Config\Utilities as utils;

use App\Model\QuizModel as Quiz;
use App\Model\UserModel as User;


class QuizController extends BaseController{

    public function index(){
        if(User::isTeacher($_SESSION['id'])){
            $quizzes = Quiz::getQuizzesByUser(utils::getSession('id'));
            $this->render('quiz/quizzes_teacher', ['quizzes'=>$quizzes]);
        }else{
            $quizzes = Quiz::getSubmittableQuizzes();
            $this->render('quiz/quizzes_student', ['quizzes'=>$quizzes]);
        }
    }

    
    public function show(){
        $quiz = array();
        $questions = array();
        if(!isset($_GET['id'])){
            utils::redirect('quizzes');
        }

        if(User::isTeacher($_SESSION['id'])){

            $quiz = Quiz::getQuiz($_GET['id']);
            $quiz_id = $_GET['id'];
            $questions = Quiz::getQuestionsAndOptionsOfQuiz($quiz_id);
            $this->render('quiz/quiz_teacher', ['quiz'=>$quiz, 'questions'=>$questions]);
        
        }else{
            $quiz_id = $_GET['id'];
            $questions = Quiz::getQuestionsAndOptionsOfQuiz($quiz_id);
            $this->render('quiz/quiz_student', ['questions'=>$questions]);
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
            // $quiz = true;
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
        
            $quiz = Quiz::updateQuiz($quiz_id, $title, $description, $submittable);
            // $quiz = false;
            if($quiz){
                utils::responde(true);
            }else{
                utils::responde(false, ['Error'=>'Error updating quiz with id '.$quiz_id]);
            }
        }
    }


    public function delete(){
        if(isset($_GET['id'])){
            $quiz_id = $_GET['id'];
            // echo $quiz_id;
            $quiz = Quiz::deleteQuiz($quiz_id);
            // $quiz = false;
            if($quiz){
                utils::responde(true);
            }else{
                utils::responde(false, ['Error'=>'Error deleting quiz with id '.$quiz_id]);
            }
        }
    }
    

}
