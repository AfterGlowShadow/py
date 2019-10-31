<?php
namespace app\home\controller;
use app\Controllers\BaseController;
use app\Models\Message as MessageModel;
class Message extends BaseController
{
    public $Model;
    public function initialize(){
        parent::initialize();
        $this->Model=new MessageModel();
    }
    //查询公告
    public function GetNotice(){
        $res=$this->Model->GetNotice();
        Back($res,"查询成功",$this->Model->getError());
    }
    //查询用户公告
    public function GetUserNotice(){
        $res=$this->Model->GetUserNotice();
        Back($res,"查询成功",$this->Model->getError());
    }
    //查询没读过的用户公告个数
    public function GetNoRead(){
        $res=$this->Model->GetNoRead();
        Back($res,"查询成功",$this->Model->getError());
    }
}