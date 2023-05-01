<?php


namespace App\Config\exceptions;


class ForbiddenException extends \Exception
{
    protected $message = 'Permission denied';
    protected $code = 403;
}