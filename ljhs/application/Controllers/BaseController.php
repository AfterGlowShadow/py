<?php

namespace app\Controllers;

use Request;
use app\validate\TokenValidate;
use app\validate\LimitValidate;
use app\validate\LimitByLmValidate;
use app\util\Upload;
use think\Controller;

class BaseController extends Controller
{

    public $param;
    public $Model;

    public function initialize()
    {
        parent::initialize();
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

        $allow_origin = array(
            'http://localhost:8080',
            'http://localhost:8081'
        );
        if (in_array($origin, $allow_origin)) {
            header('Access-Control-Allow-Origin:' . $origin);
        }
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId");
        $param = Request::instance()->param();
        $this->param = $param;
    }

    public function AddOne()
    {
        $res = $this->Model->AddOne();
        Back($res, "添加成功", $this->Model->getError());
    }

    public function DeleteOne()
    {
        $res = $this->Model->DeleteOne();
        Back($res, "删除成功", $this->Model->getError());
    }

    public function GetOne()
    {
        $res = $this->Model->GetOne();
        Back($res, "查询成功", $this->Model->getError());
    }

    public function UpdateOne()
    {
        $res = $this->Model->ChangeOne();
        Back($res, "修改成功", $this->Model->getError());
    }
//    public function GetAll(){
//        $res=$this->Model->GetSort();
//        Back($res,"查询成功",$this->Model->getError());
//    }
    public function GetList()
    {
        $res = $this->Model->GetList();
        Back($res, "查询成功", $this->Model->getError());
    }
}
