<?php
namespace app\admin\controller;
use app\Controllers\BaseController;
use app\Models\GarbagePrice as GarbagePriceModel;

class GarbagePrice extends BaseController
{
    public $Model;
    public function initialize(){
        parent::initialize();
        $this->Model=new GarbagePriceModel();
    }
    //计算临时价格(根据垃圾的id和地区的组id调用存放在redis中的数据计算)
    public function TempPrice()
    {
        $res=$this->TempOrderModel->TempPrice();
        Back($res,"添加成功",$this->Model->getError());
    }
}