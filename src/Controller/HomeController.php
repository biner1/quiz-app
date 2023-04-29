<?php

namespace App\Controller;

use App\Model\User;

class HomeController{
    // index : list all users;
    public function index(){
        echo "index";
    }
    // create : view add form;
    public function create(){
        echo "create";
    }
    // store : action of add form;
    public function store(){
        $user = new User('Ali', 'ali', '123');
        echo "stored: ".$user->getName();
    }
    // edit : view edit form;
    public function edit(){
        echo "edit";
    }
    // update : action of edit form;
    public function update(){
        echo "update";
    }
    // delete : action of delete;
    public function delete(){
        echo "delete";
    }
}