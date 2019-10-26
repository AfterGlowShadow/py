<?php
namespace app\Models;
use app\validate\LimitValidate;
use  app\Models\User as UserModel;
use think\facade\Request;

class TiXian extends BaseModel
{
    protected  $table="tixian";
    //添加单个
    public function AddOne()
    {
        $post=Request::post();
        if(array_key_exists("price",$post)&&$post['price']!=""&&is_numeric($post['price'])){
            $data['price']=$post['price']*100;
            $user=session("user");
            $data['user']=$user['userInfo'];
            $data['type']=$user['userInfo']['type'];
            $data['txnumber']=md5($data['user']['id'].$data['type'].time());
            $data['token']=md5($data['user']['id'].time());
            $data['status']=1;
            $data['del']=0;
            $userModel=new UserModel();
            $uwhere['id']=$user['userInfo']['id'];
            $uwhere['status']=1;
            $uwhere['del']=0;
            $user=$userModel->MFind($uwhere);
            if($user&&$user['price']-$data['price']>=0){
                $changeuser['price']=$user['price']-$data['price'];
                $changeuser['txprice']=$user['txprice']+$data['price'];
                $changeuser['jifen']=$user['jifen']+$data['price'];
                $uwhere['price']=$user['price'];
                $this->startTrans();
                $res=$userModel->MUpdate($uwhere,$changeuser);
                if($res){
                    $res=$this->MAdd($data);
                    if($res){
                        $this->commit();
                        return $res;
                    }else{
                        $this->rollback();
                        $this->error="添加失败";
                        return false;
                    }
                }else{
                    $this->rollback();
                    $this->error="网络错误";
                    return false;
                }
            }else{
                $this->error="余额不足,不能提现";
                return false;
            }
        }else{
            $this->error="缺少必要参数";
            return false;
        }
    }
    public function GetList(){
        $post=Request::post();
        (new LimitValidate())->goCheck($post);
        $user=session("user");
        $where['a.del']=0;
        $config['page']=$post['page'];
        $config['list_rows']=$post['list_rows'];
        $table1="tixian";
        $table2='user';
        $table1n="userid";
        $table2n="id";
        $field=array("a.id,a.token,a.txnumber,a.create_time,w.name");
        $res=$this->MDBSelect($table1,$table2,$table1n,$table2n,$where,$config,$order=array('a.id','desc'),$field);
        if($res){
            return $res;
        }else{
            $this->error="查询失败";
            return false;
        }
    }
}