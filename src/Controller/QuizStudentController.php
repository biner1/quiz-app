<?php

namespace App\Controller;

use App\Config\Utilities as utils;

use App\Model\UserModel as User;
use App\Model\QuizModel as Quiz;
use App\model\QuizAttemptModel as QuizAttempt;
use App\model\AttemptAnswersModel as AttemptAnswers;
use App\model\QuestionModel as Question;
use App\model\OptionModel as Option;


class QuizStudentController extends BaseController{

    public function store(){
        $quiz_id = $_POST['quiz_id'];
        $user_id = $_SESSION['id'];
        $score = 0;
        $total_questions = 0;

        foreach ($_POST as $key => $value) {

            // Check if the key is a question answer
            if (strpos($key, 'question_') !== false) {
            
                // Get the question ID from the key
                $question_id = str_replace('question_', '', $key);

                // Get the selected option ID for this question
                $selected_option_id = intval($value);

                // Get the correct option ID for this question
                $correct_option_id = Option::get_correct_option_id($question_id);

                // Check if the selected option is correct
                if ($selected_option_id == $correct_option_id) {
                    $score++;
                }
                
                // Increment the total number of questions
                $total_questions++;
            }
        }

        // Calculate the percentage score
        $percentage_score = round(($score / $total_questions) * 100);

        $quiz_attempt_id = QuizAttempt::createQuizAttemptAndReturnId($quiz_id, $user_id, $percentage_score);

        foreach ($_POST as $key => $value) {
            if (strpos($key, 'question_') !== false) {
                $question_id = str_replace('question_', '', $key);
                $option_id = intval($value);
                AttemptAnswers::createAttemptAnswer($quiz_attempt_id, $question_id, $option_id);
            }
        }

          utils::redirect('quizzes');
    }


}