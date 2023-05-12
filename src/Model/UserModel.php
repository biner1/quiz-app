<?php

namespace App\Model;

use App\Config\Database;

class UserModel extends Database{

    static function getUsers(){
        $sql = "SELECT * FROM `users` order by `is_admin` desc, `is_teacher` desc, `id` asc";
        return Database::query($sql);
    }

    static function getUserByEmail($emailLogin){
        $sql = "SELECT * FROM `user` WHERE `email` = :email";
        return Database::query($sql, [':email'=>$emailLogin]);
    }

    static function getUserById($id){
        $sql = "SELECT * FROM `users` WHERE `id` = :id";
        return Database::query($sql, [':id'=>$id]);
    }

    static function getUserByEmailPassword($email, $password){
        $sql = "SELECT * FROM `users` WHERE `email` = :email and `password` = :password";
        return Database::query($sql, [':email'=>$email, ':password'=>$password]);
    }

    static function createUser($email, $password, $name, $is_teacher){
        try
        {
            $sql = "INSERT INTO `users` (`email`, `password`, `name`, `is_teacher`) VALUES (:email, :password, :fullName, :is_teacher)";
            return Database::execute($sql, [':email'=>$email, ':password'=>$password, ':fullName'=>$name, ':is_teacher'=>$is_teacher]);
        }
        catch(\PDOException $e)
        {
            return false;
        }
    }

    static function updateUser($name, $phone, $email, $id){
        $sql = ("UPDATE `users` SET `name` = :name, `phone` = :phone, `email` = :email WHERE `users`.`id` = :id");
        return Database::execute($sql, [':name'=>$name, ':phone'=>$phone, ':email'=>$email, ':id'=>$id]);
    }

    static function changeUserPassword($password1, $password2, $id){
        $sql = "UPDATE `users` SET `password` = :password WHERE `id` = :id and `password` = :password1";
        $params = array(':password' => $password2, ':id' => $id, ':password1' => $password1);
        return Database::execute($sql, $params);
    }

    static function getUserImage($id){
        $image = Database::query("SELECT image FROM users WHERE id = :id", [':id' => $id])[0]['image'];
        return $image;
    }

    static function updateUserImage($id, $newImageName){
        $query = "UPDATE users SET image = :newImageName WHERE id = :id";
        return Database::execute($query, [':id' => $id, ':newImageName' => $newImageName]);
    }

    static function insertToken($email, $token){
        $sql = 'INSERT INTO password_reset (email, token, created_at) VALUES (:email, :token, NOW())';
        return Database::execute($sql, [':email'=>$email, ':token'=>$token]);
    }

    static function isTeacher($id){
        $sql = "SELECT is_teacher FROM users WHERE id = :id";
        return Database::query($sql, [':id'=>$id])[0]['is_teacher'];
    }

    static function isAdmin($id){
        $sql = "SELECT is_admin FROM users WHERE id = :id";
        return Database::query($sql, [':id'=>$id])[0]['is_admin'];
    }

}