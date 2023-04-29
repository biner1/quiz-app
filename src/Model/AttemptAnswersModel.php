<?php

namespace App\Model;

use App\Config\Database;

class AttemptAnswersModel extends Database{

    
    // attempt answer crud
    static function createAttemptAnswer($attempt_id, $question_id, $option_id){
        $sql = "INSERT INTO `attempt_answers` (`attempt_id`, `question_id`, `option_id`) VALUES (:attempt_id, :question_id, :option_id)";
        return Database::execute($sql, [':attempt_id'=>$attempt_id, ':question_id'=>$question_id, ':option_id'=>$option_id]);
    }

    static function getAttemptAnswers($attempt_id){
        $sql = "SELECT * FROM `attempt_answers` WHERE `attempt_id` = :attempt_id";
        return Database::query($sql, [':attempt_id'=>$attempt_id]);
    }

    static function getCorrectAttemptAnswersCount($attempt_id){
        $sql = "SELECT COUNT(*) FROM attempt_answers a
        JOIN options o ON a.option_id = o.id AND o.is_correct = 1
        WHERE a.attempt_id = :attempt_id";
        return Database::query($sql, [':attempt_id'=>$attempt_id]);
    }

    static function getIncorrectAttemptAnswersCount($attempt_id){
        $sql = "SELECT COUNT(*) FROM attempt_answers a
        JOIN options o ON a.option_id = o.id AND o.is_correct = 0
        WHERE a.attempt_id = :attempt_id";
        return Database::query($sql, [':attempt_id'=>$attempt_id]);
    }
}