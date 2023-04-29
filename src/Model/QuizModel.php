<?php

namespace App\Model;

use App\Config\Database;

class QuizModel extends Database{

    // quiz crud
    static function createQuiz($title, $description, $user_id){
        $sql = "INSERT INTO `quizzes` (`title`, `description`, `user_id`) VALUES (:title, :description, :user_id)";
        return Database::execute($sql, [':title'=>$title, ':description'=>$description, ':user_id'=>$user_id]);
    }

    static function getQuizzes(){
        $sql = "SELECT * FROM `quizzes`";
        return Database::query($sql);
    }

    static function getQuizzesByUser($user_id){
        $sql = "SELECT * FROM `quizzes` WHERE `user_id` = :user_id";
        return Database::query($sql, [':user_id'=>$user_id]);
    }

    static function getSubmittableQuizzes(){
        $sql = "SELECT * FROM `quizzes` WHERE `submittable` = 1";
        return Database::query($sql);
    }

    static function UpdateQuizSubmittable($id, $submittable){
        $sql = "UPDATE `quizzes` SET `submittable` = :submittable WHERE `id` = :id";
        return Database::execute($sql, [':id'=>$id, ':submittable'=>$submittable]);
    }

    static function getQuiz($id){
        $sql = "SELECT * FROM `quizzes` WHERE `id` = :id";
        return Database::query($sql, [':id'=>$id]);
    }

    static function updateQuizTitle($id, $title){
        $sql = "UPDATE `quizzes` SET `title` = :title WHERE `id` = :id";
        return Database::execute($sql, [':id'=>$id, ':title'=>$title]);
    }

    static function updateQuiz($id, $title, $description, $submittable){
        $sql = "UPDATE `quizzes` SET `title` = :title, `description` = :description, `submittable` = :submittable WHERE `id` = :id";
        return Database::execute($sql, [':id'=>$id, ':title'=>$title, ':description'=>$description, ':submittable'=>$submittable]);
    }

    static function deleteQuiz($id){
        $sql = "DELETE FROM `quizzes` WHERE `id` = :id";
        return Database::execute($sql, [':id'=>$id]);
    }

    
    static function getQuestionsAndOptionsOfQuiz($id){
        $sql = "SELECT qz.id as quiz_id, q.id as question_id, q.question_text, o.id, o.option_text, o.is_correct
        FROM quizzes qz
        INNER JOIN questions q ON q.quiz_id = qz.id
        LEFT JOIN options o ON o.question_id = q.id
        WHERE qz.id = :id;";

        $result = Database::query($sql, [':id'=>$id]);
        return QuizModel::generateArrayForQuestionsAndOptions($result);

    }

    static function generateArrayForQuestionsAndOptions($results = []) {
        $quiz = [];
    
        foreach ($results as $result) {
            $quiz_id = $result['quiz_id'];
            $question_text = $result['question_text'];
            $question_id = $result['question_id'];
            $option_id = $result['id'];
            $option_text = $result['option_text'];
            $is_correct = $result['is_correct'];
    
            // if the quiz ID does not exist in the quiz array, add it
            if (!array_key_exists($quiz_id, $quiz)) {
                $quiz[$quiz_id] = [
                    'question_id' => $question_id,
                    'quiz_id' => $quiz_id,
                    'questions' => []
                ];
            }

    
            // if the question text does not exist in the questions array for this quiz, add it
            if (!array_key_exists($question_text, $quiz[$quiz_id]['questions'])) {
                $quiz[$quiz_id]['questions'][$question_text] = [
                    'question_id' => $question_id,
                    'question_text' => $question_text,
                    'options' => []
                ];
            }
    
            // if the option ID is not null, add the option to the options array for this question
            if ($option_id !== null) {
                $quiz[$quiz_id]['questions'][$question_text]['options'][] = [
                    'option_id' => $option_id,
                    'option_text' => $option_text,
                    'is_correct' => $is_correct
                ];
            } else {
                // if the options array has not been initialized for this question, initialize it as an empty array
                if (!isset($quiz[$quiz_id]['questions'][$question_text]['options'])) {
                    $quiz[$quiz_id]['questions'][$question_text]['options'] = [];
                }
            }
        }
    
        return $quiz;
    }
    
    
    static function getQuizAttemptsByUser($user_id){
        $sql = "SELECT qa.id AS attempt_id, q.title, qa.score, qa.created_at
        FROM quiz_attempts qa
        JOIN quizzes q ON q.id = qa.quiz_id
        WHERE qa.user_id = :user_id";
        return Database::query($sql, [':user_id'=>$user_id]);
    }
    

    static function getAvgScoreAndNumberOfStudents($teacher_id){
        $sql = "SELECT COUNT(DISTINCT qa.user_id) AS num_takers, AVG(qa.score) AS avg_score
        FROM quiz_attempts AS qa
        JOIN quizzes AS q ON qa.quiz_id = q.id
        WHERE q.user_id = :teacher_id;
        ";
        return Database::query($sql, [':teacher_id'=>$teacher_id]);
    }


    static function getAvgScoreAndNumberOfStudentsForEachQuiz($teacher_id){
        $sql = "SELECT quizzes.id AS quiz_id, quizzes.title, 
        COUNT(DISTINCT quiz_attempts.user_id) AS num_students, 
        AVG(quiz_attempts.score) AS avg_score,
        COUNT(quiz_attempts.id) AS num_attempts
    FROM quizzes
    JOIN quiz_attempts ON quizzes.id = quiz_attempts.quiz_id
    WHERE quizzes.user_id = :teacher_id
    GROUP BY quizzes.id
    ";
        return Database::query($sql, [':teacher_id'=>$teacher_id]);
    }


    static function getNumberOfQuizzesTakenAndNumberOfAnswers($user_id){
        $sql = "SELECT quiz_attempts.user_id,
            COUNT(DISTINCT quiz_attempts.quiz_id) AS num_quizzes_taken,
            COUNT(quiz_attempts.quiz_id) AS num_quizzes_attempted,
            COUNT(attempt_answers.id) AS num_questions_answered,
            COUNT(CASE WHEN options.is_correct = 1 THEN 1 END) AS num_questions_answered_correctly,
            COUNT(CASE WHEN options.is_correct = 0 THEN 1 END) AS num_questions_answered_incorrectly
        FROM quiz_attempts
        LEFT JOIN attempt_answers ON quiz_attempts.id = attempt_answers.attempt_id
        LEFT JOIN options ON attempt_answers.option_id = options.id
        WHERE quiz_attempts.user_id = :user_id
        GROUP BY quiz_attempts.user_id;";
        
        return Database::query($sql, [':user_id'=>$user_id]);
    }


    static function getLeaderboard(){
        $sql = "SELECT users.name AS name,
            attempt_scores.last_attempt,
            COUNT(DISTINCT attempt_scores.quiz_id) AS num_quizzes_taken,
            SUM(attempt_scores.max_score) AS total_max_score,
            SUM(correct_counts.num_correct) AS num_correct_answers,
            SUM(attempt_counts.num_attempts - correct_counts.num_correct) AS num_incorrect_answers,
            SUM(attempt_scores.max_score) / COUNT(DISTINCT attempt_scores.quiz_id) as average_score
        FROM users
        JOIN (
            SELECT id, quiz_id, user_id, MAX(score) AS max_score, MAX(created_at) AS last_attempt
            FROM quiz_attempts
            GROUP BY quiz_id, user_id
        ) AS attempt_scores ON users.id = attempt_scores.user_id
        JOIN (
            SELECT attempt_id, COUNT(*) AS num_correct
            FROM attempt_answers
            JOIN options ON attempt_answers.option_id = options.id AND options.is_correct = 1
            GROUP BY attempt_id
        ) AS correct_counts ON attempt_scores.id = correct_counts.attempt_id
        JOIN (
            SELECT attempt_id, COUNT(*) AS num_attempts
            FROM attempt_answers
            GROUP BY attempt_id
        ) AS attempt_counts ON attempt_scores.id = attempt_counts.attempt_id
        GROUP BY users.id
        ORDER BY total_max_score DESC, average_score DESC, last_attempt;";

        return Database::query($sql);
    }


}