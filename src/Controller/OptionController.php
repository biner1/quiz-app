<?php


namespace App\Controller;

use App\Config\Utilities as utils;
use App\Config\middlewares\AuthMiddleware;

use App\Model\OptionModel as Options;


class OptionController extends BaseController{

    public function __construct(){
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function store(){
        if(isset($_POST['create_option'])){
            $question_id = $_POST['create_option'];
            $option_text = $_POST['option-text'];
            $is_correct = isset($_POST['is_correct']) && $_POST['is_correct'] === '1';
        
            $option = Options::createOption($question_id, $option_text, $is_correct);

            if($option){
                utils::responde(true);
            }else{
                utils::responde(false);
            }
        }
    }


    public function delete(){
        if(isset($_GET['id'])){
            $option_id = $_GET['id'];
            $option = Options::deleteOption($option_id);
            
            if($option){
                utils::responde(true);
            }else{
                utils::responde(false,['Error'=>'Error deleting option']);
            }
        }
    }


    public function update(){
        if(isset($_POST['update_option'])){
            $option_id = $_POST['update_option'];
            $option_text = $_POST['option_text'];
            $is_correct = isset($_POST['is_correct']) && $_POST['is_correct'] === '1';
            $option = Options::updateOption($option_id, $option_text, $is_correct);
            
            if($option){
                utils::responde(true);
            }else{
                utils::responde(false, ['Error'=>'Error updating option']);
            }
        }else{
            utils::responde(false, ['Error'=>'Error updating option']);
        }
    }


}