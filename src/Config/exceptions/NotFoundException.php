<?php


namespace App\Config\exceptions;

use App\Config\Application;

class NotFoundException extends \Exception
{
    protected $message = 'Not Found';
    protected $code = 404;
    
}