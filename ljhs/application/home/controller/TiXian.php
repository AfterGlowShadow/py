<?php
namespace app\home\controller;
use app\Controllers\BaseController;
use app\Models\TiXian as TiXianModel;
class TiXian extends BaseController
{
    public $Model;
    public function initialize(){
        parent::initialize();
        $this->Model=new TiXianModel();
    }

    public function GetListById()
    {
        $res=$this->Model->GetSaleList();
        Back($res,"查询成功",$this->Model->getError());
    }
}