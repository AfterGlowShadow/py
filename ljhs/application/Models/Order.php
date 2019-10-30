<?php
namespace app\Models;
use app\validate\LimitValidate;
use app\validate\Order as OrderValidate;
use think\facade\Request;

class Order extends BaseModel
{
    protected $table="order";
    //分页查询信息
    public function GetList()
    {
        $post=Request::post();
        (new LimitValidate())->goCheck($post);
        $config['page']=$post['page'];
        $config['list_rows']=$post['list_rows'];
        $where['status']=1;
        $where['del']=0;
        $res=$this->MLimitSelect($where,$config,"id desc");
        if($res){
            return $res;
        }else{
            $this->error="查询失败";
            return false;
        }
    }
    //门店添加订单
    public function ShopAddOne()
    {
        $post=Request::post();
        (new OrderValidate())->goCheck($post);
//        $post['garbagelist']=explode(",",$post['garbagelist']);
        $post['garbagelist']=json_decode($post['garbagelist'],true);
        if(array_key_exists("garbagelist",$post)&&is_array($post['garbagelist'])&&!empty($post['garbagelist'])){
            $user=session("user");
            $GarbageOrderModel=new GarbageOrder();
            $data['price']=$post['price'];
            $data['number']=$post['number'];
            $data['type']=$user['type'];
            $data['weight']=$post['weight'];
            $this->startTrans();
            $data['shopid']=$user['userInfo']['id'];
            $data['ordernumber']=md5(time().$data['price']);
            $res=$this->MAdd($data);
            if($res){
                $saledata=PushGarbage($post['garbagelist'],$res,'orderid','garbageid');
                $res1=$GarbageOrderModel->MBulkAdd($saledata);
                if($res1){
                    //记入日志
                    $log['shopid']=$data['shopid'];
                    $log['shopcreate_time']=time();
                    $log['shopnumber']=$data['ordernumber'];
                    $log['orderid']=$res;
                    $log['status']=0;
                    $orderlogModel=new OrderLog();
                    $res2=$orderlogModel->MAdd($log);
                    if($res2){
                        $this->commit();
                        return $res1;
                    }else{
                        $this->rollback();
                        return false;
                    }
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
            $this->error="必须填写垃圾";
            return false;
        }
    }
    //业务员\暂存点\总库出库添加订单
    public function SaleAddOne()
    {
        $post=Request::post();
        (new OrderValidate())->goCheck($post);
        $post['orderlist']=json_decode($post['orderlist'],true);
        if(array_key_exists("orderlist",$post)&&is_array($post['orderlist'])&&!empty($post['orderlist'])){
            $OrderOrder=new OrderOrder();
            $user=session("user");
            $data['price']=$post['price'];
            $data['number']=$post['number'];
            $data['weight']=$post['weight'];
            $data['type']=$user['type'];
            $user=$user['userInfo'];
            if($user['type']==1){
                $data['saleid']=$user['id'];
            }else if($user['type']==2){
                $data['tempid']=$user['id'];
            }
            $this->startTrans();
            $data['ordernumber']=md5(time().$data['price']);
            $res=$this->MAdd($data);
            if($res){
                $saledata=PushGarbage($post['orderlist'],$res,'orderid','norderid');
                $res1=$OrderOrder->MBulkAdd($saledata);
                if($res1){
                    //修改之前的订单添加上现在的userid
                    $where['id']=$post['orderlist'];
                    if($user['type']==1){
                        $udata['saleid']=$user['id'];
                    }else if($user['type']==2){
                        $udata['tempid']=$user['id'];
                    }
                    $res3=$this->MUpdate($where,$udata);
                    //记录到日志中
                    if($user['type']==1){
                        $log['saleid']=$user['id'];
                        $log['status']=2;
                    }else if($user['type']==2){
                        $log['tempid']=$user['id'];
                        $log['status']=4;
                    }
                    $log['salecreate_time']=time();
                    $log['salenumber']=$data['ordernumber'];
                    $orderlogModel=new OrderLog();
                    $res2=$orderlogModel->MAdd($log);
                    if($res2&&$res3){
                        $this->commit();
                        return $res1;
                    }
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
            $this->error="必须填写订单";
            return false;
        }
    }
    //获取单个垃圾
    public function GetOne()
    {
        $post=Request::post();
        if(array_key_exists("ordernumber",$post)&&$post['ordernumber']!=""){
            $mcont['ordernumber']=$post['ordernumber'];
            $mcont['del']=0;
            $mcont['status']=1;
            $res=$this->MFind($mcont);
            if($res){
                return $res;
            }else{
                $this->error="查询失败";
                return false;
            }
        }else{
            $this->error="缺少必要参数";
        }
    }
    //订单确认
    public function ConfirmOrder()
    {
        $post=Request::post();
        if(array_key_exists("ordernumber",$post)&&$post['ordernumber']!=''){
            $where['ordernumber']=$post['ordernumber'];
            $updata['status']=2;
            $updata['end_time']=time();
            $this->startTrans();
            $res=$this->MUpdate($where,$updata);
            if($res){
                //写入日志
                $order=$this->MFind($where);
                if($order['type']==0){
                    //门店订单确定
                    $res1=$this->ShopConfirm($order);
                }else if($order['type']==1){
                    //业务员订单
                    $res1=$this->SaleConfirm($order);
                }else if($order['type']==2){
                    //暂存点订单
                    $res1=$this->TempConfirm($order);
                }
                if($res1){
                    $this->commit();
                    return $res;
                }else{
                    $this->rollback();
                    $this->error="确认失败";
                    return false;
                }
            }else{
                $this->rollback();
                $this->error="确认失败";
                return false;
            }
        }else{
            $this->error="缺少参数";
            return false;
        }
    }
    //门店订单确定
    private function ShopConfirm($data){
        $where['shopnumber']=$data['ordernumber'];
        $data['status']=1;
        $data['shopend_time']=time();
        $orderlog=new OrderLog();
        $res=$orderlog->MUpdate($where,$data);
        return $res;
    }
    //业务员订单
    private function SaleConfirm($data){
        $where['salenumber']=$data['ordernumber'];
        $data['status']=3;
        $data['saleend_time']=time();
        $orderlog=new OrderLog();
        $res=$orderlog->MUpdate($where,$data);
        return $res;
    }
    //暂存点订单
    private function TempConfirm($data){
        $where['tempnumber']=$data['ordernumber'];
        $data['status']=5;
        $data['tempend_time']=time();
        $orderlog=new OrderLog();
        $res=$orderlog->MUpdate($where,$data);
        return $res;
    }
}