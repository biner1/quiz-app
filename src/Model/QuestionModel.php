<?php

namespace App\Model;

use App\Config\Database;


class QuestionModel extends Database{


    // question crud
    static function createQuestion($quiz_id, $question){
        $sql = "INSERT INTO `questions` (`quiz_id`, `question_text`) VALUES (:quiz_id, :question_text)";
        return Database::execute($sql, [':quiz_id'=>$quiz_id, ':question_text'=>$question]);
    }

    static function getQuestions($quiz_id){
        $sql = "SELECT * FROM `questions` WHERE `quiz_id` = :quiz_id";
        return Database::query($sql, [':quiz_id'=>$quiz_id]);
    }
    static function getFirstQuestionOfQuiz($quiz_id){
        $sql = "SELECT * FROM questions WHERE id in (select MIN(id) AS id FROM questions WHERE quiz_id = :quiz_id)";
        return Database::query($sql, [':quiz_id'=>$quiz_id]);
    }

    static function getFirstQuestionIdOfQuiz($quiz_id){
        $sql = "SELECT MIN(id) AS id FROM questions WHERE quiz_id = :quiz_id";
        return Database::query($sql, [':quiz_id'=>$quiz_id]);
    }

    static function getNextQuestion($quiz_id, $question_id){
        $sql = "SELECT * FROM questions WHERE quiz_id = :quiz_id AND id > :question_id ORDER BY id LIMIT 1";
        return Database::query($sql, [':quiz_id'=>$quiz_id, ':question_id'=>$question_id]);
    }

    static function getQuestion($id){
        $sql = "SELECT * FROM `questions` WHERE `id` = :id";
        return Database::query($sql, [':id'=>$id]);
    }

    static function updateQuestionText($id, $question_text){
        $sql = "UPDATE `questions` SET `question_text` = :question WHERE `id` = :id";
        return Database::execute($sql, [':id'=>$id, ':question'=>$question_text]);
    }

    static function deleteQuestion($id){
        $sql = "DELETE FROM `questions` WHERE `id` = :id";
        return Database::execute($sql, [':id'=>$id]);
    }

    
}