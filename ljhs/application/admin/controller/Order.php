<?php
namespace app\admin\controller;
use app\Controllers\BaseController;
use app\Models\Order as OrderModel;
class Order extends BaseController
{
    public $Model;
        public function initialize(){
        parent::initialize();
        $this->Model=new OrderModel();
    }
    public function ShopAddOne()
    {
        $res=$this->Model->ShopAddOne();
        Back($res,"添加成功",$this->Model->getError());
    }
    public function SaleAddOne()
    {
        $res=$this->Model->SaleAddOne();
        Back($res,"添加成功",$this->Model->getError());
    }
    public function TempAddOne()
    {
        $res=$this->Model->TempOrderModel();
        Back($res,"添加成功",$this->Model->getError());
    }
}