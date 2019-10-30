<?php


namespace app\Models;


use app\validate\Order as OrderValidate;
use think\facade\Request;

class ShopSarleOrder extends BaseModel
{
    protected $table="shopsarleorder";
    //订单
    public function AddOder(){
        $post=Request::post();
        (new OrderValidate())->goCheck($post);
        $nwdata=$this->CheckGarbage($post['garbagelist']);
        if($nwdata){
            $post['number']=md5(time().$post['garbagelist']);
            $post['znumber']=$nwdata['number'];
            $post['zweight']=$nwdata['weight'];
            $shopinfo=session('shop');
            $post['shopid']=$shopinfo['userInfo']['id'];
            $post['saleid']=$shopinfo['userInfo']['upid'];
            $post['garbageremark']=json_encode($post['garbagelist']);
            $this->startTrans();
            $res=$this->MAdd($post);
            if($res){
                $Garbage=$this->PushGarbage($post['garnagelist'],$res,'orderid','garbageid');
                $res1=$this->MBulkAdd($Garbage);
                if($res1){
                    $this->commit();
                    return $res1;
                }else{
                    $this->rollback();
                    $this->error="订单添加失败";
                    return false;
                }
            }else{
                $this->rollback();
                $this->error="订单添加失败";
                return false;
            }
        }else{
            $this->error="垃圾不许填写重量或者个数";
            return false;
        }
    }
    //验证垃圾参数
    public function CheckGarbage($data)
    {
        $weight=0;
        $number=0;
        foreach ($data as $key => $value){
            if(array_key_exists("garbageid",$value)&&$value['garbageid']!=""){
                if((array_key_exists("number",$value)&&$value['number']!=""&&is_numeric($value['number']))||(array_key_exists("weight",$value)&&$value['weight']!=""&&is_numeric($value['weight']))){
                    if(array_key_exists("number",$value)&&$value['number']!=""&&is_numeric($value['number'])){
                        $number+=$value['numner'];
                    }else{
                        $weight+=$value['weight'];
                    }
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
        $data['wight']=$weight;
        $data['number']=$number;
        return $data;
    }
}