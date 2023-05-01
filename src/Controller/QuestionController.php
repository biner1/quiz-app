<?php

namespace App\Controller;

use App\Config\Utilities as utils;
use App\Config\middlewares\AuthMiddleware;


use App\Model\QuestionModel as Questions;

class QuestionController{

    public function __construct(){
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function store(){
        if(isset($_POST['create_question'])){
            $question_text = $_POST['question-text'];
            $quiz_id = $_POST['create_question'];
        
            $question = Questions::createQuestion($quiz_id, $question_text);
            if($question){
                utils::responde(true);
            }else{
                utils::responde(false);
            }
        }
    }


    public function delete(){
        if(isset($_GET['id'])){
            $question_id = $_GET['id'];
            $question = Questions::deleteQuestion($question_id);
            if($question){
                utils::responde(true);
            }else{
                utils::responde(false, ['Error'=>'Error deleting question']);
            }
        }else{
            utils::responde(false, ['Error'=>'Error deleting question']);
        }
    }

    public function update(){
        if(isset($_POST['update_question'])){
            $question_id = $_POST['update_question'];
            $question_text = $_POST['question_text'];
            $question = Questions::updateQuestionText($question_id, $question_text);
            if($question){
                utils::responde(true);
            }else{
                utils::responde(false, ['Error'=>'Error updating question']);
            }
        }else{
            utils::responde(false, ['Error'=>'Error updating question']);
        }
    }




}
