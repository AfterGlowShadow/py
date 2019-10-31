<?php
namespace app\home\controller;
use app\Controllers\BaseController;
use app\Models\Order as OrderModel;
class Order extends BaseController
{
//    public $Model;
//    public function initialize(){
//        parent::initialize();
//        $this->Model=new ShopSarleOrderModel();
//    }
//    //添加订单
//    public function AddOder(){
//        $res=$this->Model->AddOder();
//        Back($res,"添加成功",$this->Model->getError());
//    }

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

    public function ConfirmOrder()
    {
        $res=$this->Model->ConfirmOrder();
        Back($res,"确认成功",$this->Model->getError());
    }
}