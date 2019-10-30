<?php
namespace app\Models;
use app\Validate\TempOrder as TempOrderValidate;
class TempOrder extends BaseModel
{
    protected $table="temporder";

    public function AddOne()
    {
        $post=Request::post();
        (new TempOrderValidate())->goCheck($post);
        if($post['zweight']!=""||$post['zheight']!=""){
            if(strlen($post['saleolist'])>0){
                $SaleTempModel=new SaleTempOrder();
                $this->startTrans();
                $res=$SaleTempModel->MAdd($post);
                if($res){
                    $saledata=PushGarbage($post['saleolist'],$res,'temporderid','saleorderid');
                    if($saledata){
                        $SaleShopOrderModel=new SaleShopOrder();
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
                        $this->error="添加订单数据有误";
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