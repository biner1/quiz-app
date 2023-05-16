<?php

namespace App\Controller;

use App\Config\Utilities as utils;
use App\Config\middlewares\AuthMiddleware;

use App\Model\UserModel as User;
use App\Model\QuizModel as Quiz;
use App\model\QuizAttemptModel as QuizAttempt;
use App\model\AttemptAnswersModel as AttemptAnswers;
use App\model\QuestionModel as Question;
use App\model\OptionModel as Option;


class QuizStudentController extends BaseController
{

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware());
    }

    // take quiz all at once
    public function store()
    {
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

        $number_of_questions = Quiz::getNumberOfQuestions($quiz_id);

        if ($number_of_questions != $total_questions) {
            utils::responde(false, ['Error' => 'You must answer all the questions.']);
        }

        // Calculate the percentage score
        $percentage_score = round(($score / $total_questions) * 100);

        $is_submittable = Quiz::isSubmittable($quiz_id);

        if (!$is_submittable) {
            utils::responde(false, ['Error' => 'You can not submit this quiz. It is not submittable.']);
        }

        $quiz_attempt_id = QuizAttempt::createQuizAttemptAndReturnId($quiz_id, $user_id, $percentage_score);

        foreach ($_POST as $key => $value) {
            if (strpos($key, 'question_') !== false) {
                $question_id = str_replace('question_', '', $key);
                $option_id = intval($value);
                AttemptAnswers::createAttemptAnswer($quiz_attempt_id, $question_id, $option_id);
            }
        }
        QuizAttempt::setQuizAttemptCompleted($quiz_attempt_id);
        utils::responde(true, ['Success' => 'Quiz submitted successfully.', 'redirect' => 'quizzes']);
    }


    // Take quiz one question at a time
    public function take()
    {
        $quiz_id = $_POST['quiz_id'];
        $quiz = Quiz::getQuiz($quiz_id)[0];
        $user_id = utils::getSession('id');

        if ($quiz["submittable"]) {

            $quiz_attempt_id = QuizAttempt::getQuizAttemptUnfinished($quiz_id, $user_id)[0]['id'];
            $current_question_id = QuizAttempt::getCurrentQuestionId($quiz_attempt_id)[0]['current_question_id'];

            $option_id = $_POST["option"];
            AttemptAnswers::createAttemptAnswer($quiz_attempt_id, $current_question_id, $option_id);

            $next_question = Question::getNextQuestion($quiz_id, $current_question_id)[0] ?? 0;

            if ($next_question) {
                QuizAttempt::setCurrentQuestionId($quiz_attempt_id, $next_question['id']);
                $options = Option::getOptions($next_question['id']);
                utils::responde(true, ['question' => $next_question, 'options' => $options]);
            } else {
                QuizAttempt::setQuizAttemptCompleted($quiz_attempt_id);
                QuizAttempt::setQuizAttemptScore($quiz_attempt_id);
                utils::responde(true, ['Success' => 'Quiz submitted successfully.', 'redirect' => 'quizzes']);
            }

        } else {
            utils::responde(false, ['Error' => 'You can not take this quiz. It is not submittable.']);
        }

    }



}