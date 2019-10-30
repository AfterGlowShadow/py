<?php
namespace app\admin\controller;
use app\Controllers\BaseController;
use app\Models\SaleTempOrder as SaleTempOrderModel;
use app\Models\TempOrder as TempOrderModel;

class Order1 extends BaseController
{
//    public $Model;
//    public $SaleTempModel;
//    public $TempOrderModel;
//    public function initialize(){
//        parent::initialize();
//        $this->SaleTempModel=new SaleTempOrderModel();
//        $this->TempOrderModel = new TempOrderModel();
//        $this->Model= $this->SaleTempModel;
//    }
//
//    public function SaleAddOne()
//    {
//        $res=$this->SaleTempModel->AddOne();
//        Back($res,"添加成功",$this->Model->getError());
//    }
//    public function TempAddOne()
//    {
//        $res=$this->TempOrderModel->AddOne();
//        Back($res,"添加成功",$this->Model->getError());
//    }
    public $Model;
        public function initialize(){
        parent::initialize();
        $this->SaleTempModel=new SaleTempOrderModel();
        $this->TempOrderModel = new TempOrderModel();
        $this->Model= $this->SaleTempModel;
    }
}