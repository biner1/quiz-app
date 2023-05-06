<?php

namespace App\Model;

use App\Config\Database;



class QuizAttemptModel extends Database{
    // quiz attempt crud
    static function createQuizAttempt($quiz_id, $user_id, $score){
        $sql = "INSERT INTO `quiz_attempts` (`quiz_id`, `user_id`, `score`) VALUES (:quiz_id, :user_id, :score)";
        return Database::execute($sql, [':quiz_id'=>$quiz_id, ':user_id'=>$user_id, ':score'=>$score]);
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

    static function getQuizAttempt($id){
        $sql = "SELECT * FROM `quiz_attempts` WHERE `id` = :id";
        return Database::query($sql, [':id'=>$id]);
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