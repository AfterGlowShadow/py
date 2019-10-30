<?php
namespace app\admin\controller;
use app\Controllers\BaseController;
use app\Models\Message as MessageModel;
class Message extends BaseController
{
    public $Model;
    public function initialize(){
        parent::initialize();
        $this->Model=new MessageModel();
    }
}