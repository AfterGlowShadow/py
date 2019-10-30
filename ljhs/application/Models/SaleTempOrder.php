<?php
namespace app\Models;
use app\Validate\SaleTempOrder as SaleTempOrderValidate;
use think\facade\Request;

class SaleTempOrder extends BaseModel
{
    protected $table="saletemporder";

    public function AddOne()
    {
        $post=Request::post();
        (new SaleTempOrderValidate())->goCheck($post);
        if($post['zweight']!=""||$post['zheight']!=""){
            if(strlen($post['shopolist'])>0){
                $SaleTempModel=new SaleTempOrder();
                $this->startTrans();
                $res=$SaleTempModel->MAdd($post);
                if($res){
                    $SaleShopOrderModel=new SaleShopOrder();
                    $saledata=PushGarbage($post['shopolist'],$res,'saletempid','shoporderid');
                    $res1=$SaleShopOrderModel->MBulkAdd($saledata);
                    if($res1){
                        return $res1;
                    }else{
                        $this->rollback();
                        $this->error="添加失败";
                        return false;
                    }
                }else{
                    $this->rollback();
                    $this->error="添加失败";
                    return false;
                }
            }else{
                $this->error="必须勾选订单";
                return false;
            }
        }else{
            $this->error = "总重量,总数量不能同时为空";
            return false;
        }
    }
}