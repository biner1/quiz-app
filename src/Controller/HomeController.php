<?php

namespace App\Controller;


use App\Config\Utilities as utils;

class HomeController
{
    // index : list all users;
    public function index()
    {
        utils::redirect('dashboard');
    }

}