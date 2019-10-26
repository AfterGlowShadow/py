<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/25
 * Time: 14:24
 */

namespace app\home\controller;


use app\Controllers\BaseController;
use app\Models\Sms;

class WechatSms extends BaseController
{
    public $Model;
    public function initialize(){
        parent::initialize();
        $this->Model=new Sms();
    }
    /**
     * 发送短信
     */
    public function index()
    {
        $res=$this->Model->index();
        Back($res,"发送成功",$this->Model->getError());
    }
}