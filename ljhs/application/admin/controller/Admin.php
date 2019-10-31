<?php
namespace app\admin\controller;
use app\Controllers\BaseController;
use app\Models\Admin as AdminModel;
use Redis;

class Admin extends BaseController
{
    public $Model;
    public function initialize(){
        parent::initialize();
        $this->Model=new AdminModel();
    }
    //判断登录

    /**
     * User: Administrator
     * Date: 2019-10-26 15:20
     * RequestType:
     * requestInfo:
     * apiSuccessMock:
     * apiFailureMock:
     */
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
    public function UpPwd()
    {
        $res = $this->Model->UpPwd();
        Back($res, "修改成功", $this->Model->getError());
    }
}
