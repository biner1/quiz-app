<?php

namespace App\Model;

use App\Config\Database;

class OptionModel extends Database{

    
    // option crud
    static function createOption($question_id, $option_text, $is_correct){
        $sql = "INSERT INTO `options` (`question_id`, `option_text`, `is_correct`) VALUES (:question_id, :option_text, :is_correct)";
        return Database::execute($sql, [':question_id'=>$question_id, ':option_text'=>$option_text, ':is_correct'=>$is_correct]);
    }

    static function getOptions($question_id){
        $sql = "SELECT * FROM `options` WHERE `question_id` = :question_id";
        return Database::query($sql, [':question_id'=>$question_id]);
    }

    static function getOption($id){
        $sql = "SELECT * FROM `options` WHERE `id` = :id";
        return Database::query($sql, [':id'=>$id]);
    }

    static function get_correct_option_id($question_id){
        $db =  Database::connect();
        if($db == null){
            return;
        }
        $sql = "SELECT id FROM `options` WHERE `question_id` = :question_id AND `is_correct` = 1";
        $sql_parms = [':question_id'=>$question_id];
        $smt = $db->prepare($sql);
        $smt->execute($sql_parms);
        $row = $smt->fetch();
        $smt = null;
        $db = null;
        return $row['id'];
    }

    static function updateOptionText($id, $option_text){
        $sql = "UPDATE `options` SET `option_text` = :option WHERE `id` = :id";
        return Database::execute($sql, [':id'=>$id, ':option'=>$option_text]);
    }

    static function deleteOption($id){
        $sql = "DELETE FROM `options` WHERE `id` = :id";
        return Database::execute($sql, [':id'=>$id]);
    }

    static function updateOption($id, $option_text, $is_correct){
        $sql = "UPDATE `options` SET `option_text` = :option_text, `is_correct` = :is_correct WHERE `id` = :id";
        return Database::execute($sql, [':id'=>$id, ':option_text'=>$option_text, ':is_correct'=>$is_correct]);
    }
}