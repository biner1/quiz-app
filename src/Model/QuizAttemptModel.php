<?php

namespace App\Model;

use App\Config\Database;

class QuizAttemptModel extends Database{
    // quiz attempt crud
    static function createQuizAttempt($quiz_id, $user_id, $current_question_id, $score){
        $sql = "INSERT INTO `quiz_attempts` (`quiz_id`, `user_id`, current_question_id, `score`) 
        VALUES (:quiz_id, :user_id, :current_question_id, :score)";
        return Database::execute($sql, [':quiz_id'=>$quiz_id, ':user_id'=>$user_id, ':score'=>$score,
         ':current_question_id'=>$current_question_id]);
    }

    static function createQuizAttemptAndReturnId($quiz_id, $user_id, $score){
        $db =  Database::connect();
        if($db == null){
            return;
        }
        $sql = "INSERT INTO `quiz_attempts` (`quiz_id`, `user_id`, `score`) VALUES (:quiz_id, :user_id, :score)";
        
        $sql_parms = [':quiz_id'=>$quiz_id, ':user_id'=>$user_id, ':score'=>$score];
        $smt = $db->prepare($sql);
        $smt->execute($sql_parms);
        $inserted_id = $db->lastInsertId();
        $smt = null;
        $db = null;
        return $inserted_id;
    }

    static function getQuizAttempts($quiz_id){
        $sql = "SELECT * FROM `quiz_attempts` WHERE `quiz_id` = :quiz_id";
        return Database::query($sql, [':quiz_id'=>$quiz_id]);
    }

    static function getQuizAttemptsByUser($user_id){
        $sql = "SELECT * FROM `quiz_attempts` WHERE `user_id` = :user_id";
        return Database::query($sql, [':user_id'=>$user_id]);
    }

    static function setQuizAttemptCompleted($id){
        $sql = "UPDATE `quiz_attempts` SET `completed` = 1 WHERE `id` = :id";
        return Database::execute($sql, [':id'=>$id]);
    }

    static function getQuizAttempt($id){
        $sql = "SELECT * FROM `quiz_attempts` WHERE `id` = :id";
        return Database::query($sql, [':id'=>$id]);
    }

    static function getQuizAttemptUnfinished($quiz_id, $user_id){
        $sql = "SELECT * FROM `quiz_attempts` WHERE `quiz_id` = :quiz_id AND `user_id` = :user_id AND `completed` = 0";
        return Database::query($sql, [':quiz_id'=>$quiz_id, ':user_id'=>$user_id]);
    }

    static function getCurrentQuestionId($quiz_attempt_id){
        $sql = "SELECT `current_question_id` FROM `quiz_attempts` WHERE `id` = :id";
        return Database::query($sql, [':id'=>$quiz_attempt_id]);
    }

    static function setCurrentQuestionId($quiz_attempt_id, $question_id){
        $sql = "UPDATE `quiz_attempts` SET `current_question_id` = :q_id WHERE `id` = :id";
        return Database::execute($sql, [':id'=>$quiz_attempt_id, ':q_id'=>$question_id]);
    }

    static function setQuizAttemptScore($quiz_attempt_id){
        $score = self::calculateScore($quiz_attempt_id);
        return self::updateQuizAttemptScore($quiz_attempt_id, $score);
    }

    static function calculateScore($quiz_attempt_id){
        $sql = "SELECT qa.id AS attempt_id, qa.quiz_id, SUM(op.is_correct) AS score
        FROM quiz_attempts AS qa
        JOIN attempt_answers AS aa ON qa.id = aa.attempt_id
        JOIN options AS op ON aa.option_id = op.id
        WHERE qa.id = :quiz_attempt_id
        GROUP BY qa.id;
        ";
        $result = Database::query($sql, [':quiz_attempt_id'=>$quiz_attempt_id]);
        $score = $result[0]['score'];
        $quiz_id = $result[0]['quiz_id'];
        $total_questions = QuizModel::getNumberOfQuestions($quiz_id);
        $percentage_score = round(($score / $total_questions) * 100);
        return $percentage_score;
    }

    
    static function updateQuizAttemptScore($id, $score){
        $sql = "UPDATE `quiz_attempts` SET `score` = :score WHERE `id` = :id";
        return Database::execute($sql, [':id'=>$id, ':score'=>$score]);
    }
    

    static function deleteQuizAttempt($id){
        $sql = "DELETE FROM `quiz_attempts` WHERE `id` = :id";
        return Database::execute($sql, [':id'=>$id]);
    }

    static function getQuizMaxScore($quiz_id){
        $sql = "SELECT MAX(score) AS max_score FROM quiz_attempts WHERE quiz_id = :quiz_id";
        return Database::query($sql, [':quiz_id'=>$quiz_id]);

    }
}