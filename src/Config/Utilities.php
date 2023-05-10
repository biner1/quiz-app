<?php

namespace App\Config;

class Utilities{

    static function redirect($url){
        header("Location: /mvc/$url");
        die();
    }


    static function is_post(){
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    static function is_get(){
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }


    
    static function ensure_user_is_authenticated(){
        if(!self::is_user_authenticated()){
            self::redirect('login');
        }
    }
    
    static function is_user_authenticated(){
        return isset($_SESSION['id']);
    }

    static function countQuestionsSubmitted($array) {
        $count = count(array_filter($array, function($key) {
            return preg_match('/^question_/', $key);
        }, ARRAY_FILTER_USE_KEY));
    
        return $count;
    }

    static function get_logged_in_user(){
        return $_SESSION['id'];
    }


    static function setSession($key, $value){
        $_SESSION[$key] = $value;
    }

    static function getSession($key){
        return $_SESSION[$key];
    }

    static function destroySession(){
        session_unset();
        session_destroy();
    }


    // Update user's password in database
    static function updateUserPassword($email, $password) {
        $sql = 'UPDATE user SET password = :password WHERE email = :email';
        return Database::query($sql, [':password'=>md5($password), ':email'=>$email]);
    }


    static function responde($success = true, $data = array()){
        $data = json_encode($data);
        $response = [];
        if($success === true){
            $response['success'] = $success;
            if(!empty($data))
                $response['data'] = $data;
        }else{
            $response['success'] = $success;
            if(!empty($data))
                $response['errors'] = $data;
        }
        echo json_encode($response);
        exit();
    }

    static function validateSignupInputs($name, $email, $password, $confirm_password){
        $errors = array();
        if (empty($name)) {
            $errors['name_err'] = "Name is required.";
        }
        if (empty($email)) {
            $errors['email_err'] = "Email is required.";
        }
        if (empty($password)) {
            $errors['pass_err'] = "Password is required.";
        }
        if ($password !== $confirm_password) {
            $errors['con_err'] = "Passwords do not match.";
        }

        return $errors;
    }


    static function outputQusestionAndOptionsOFquiz($results){
        foreach ($results as $quiz_id => $quiz_data) {
            echo "Quiz ID: $quiz_id\n<br>";
            
            foreach ($quiz_data['questions'] as $question_id => $question_data) {
                echo "Question ID: $question_id\n";
                echo "Question Text: {$question_data['question_text']}\n";
                
                foreach ($question_data['options'] as $option_data) {
                    echo "Option ID: {$option_data['option_id']}\n<br>";
                    echo "Option Text: {$option_data['option_text']}\n<br>";
                    echo "Is Correct: {$option_data['is_correct']}\n<br><br>";
                }
            }
        }

    }



}