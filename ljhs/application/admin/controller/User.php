<?php
namespace app\admin\controller;
use app\Controllers\BaseController;
use app\Models\User as UserModel;
class User extends BaseController
{
    public $Model;
    public function initialize(){
        parent::initialize();
        $this->Model=new UserModel();
    }
    //判断登录
    public function login(){
        $res=$this->Model->login();
        Back($res,"登陆成功",$this->Model->getError());
    }
    //退出登录
    public function logout(){
        $res=$this->Model->logout();
        Back($res,"退出成功",$this->Model->getError());
    }
    //修改登录密码与账号
    public function UpPwd(){
        $res=$this->Model->UpPwd();
        Back($res,"修改成功",$this->Model->getError());
    }

}