<?php
namespace app\home\controller;
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
    //获取当前用户的用户信息
    public function GetDQOne()
    {
        $user=session("user");
        print_r($user);
        Back($user,"查询成功",$this->Model->getError());
    }
    //查询暂存点用户列表
    public function GetTempList()
    {
        $res=$this->Model->GetTempList();
        Back($res,"查询成功",$this->Model->getError());
    }
    //查询业务员点用户列表
    public function GetSaleList()
    {
        $res=$this->Model->GetSaleList();
        Back($res,"查询成功",$this->Model->getError());
    }
    //查询门店用户列表
    public function GetShopList()
    {
        $res=$this->Model->GetShopList();
        Back($res,"查询成功",$this->Model->getError());
    }
    //根据id修改
    public function UpdateOneById()
    {
        $res=$this->Model->UpdateOneById();
        Back($res,"修改成功",$this->Model->getError());
    }
    //门店注册
    public function Register()
    {
        $res=$this->Model->Register();
        Back($res,"注册成功",$this->Model->getError());
    }
    //通过或驳回审核
    public function Confirm()
    {
        $res=$this->Model->Confirm();
        Back($res,"审核成功",$this->Model->getError());
    }
}