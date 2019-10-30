<?php
namespace app\Models;
use app\validate\LimitValidate;
use think\facade\Request;

/**
 * Class Garbage
 * 垃圾(涉及到垃圾表和垃圾价格表)
 * @package app\Models\
 */
class Garbage extends BaseModel
{
    protected $table = 'garbage';
    public function comments()
    {
        return $this->hasMany('GarbagePrice','garbageid');
    }
    //添加一个垃圾
    public function AddOne()
    {
        $post=Request::post();
        if(array_key_exists("name",$post)&&$post['name']!=""){
            $mcont['name']=$post['name'];
            $fadmin=$this->MFind($mcont);
            if($fadmin){
                $this->error="此垃圾名称存在";
                return false;
            }else{
                if(array_key_exists("pga",$post)&&$post['pga']!=""){
                    $where['id']=$post['pga'];
                    $garbage=$this->MFind($where);
                    if($garbage){
                        if($garbage['pgalist']){
                            $post['pgalist']=$garbage['pgalist'].",".$post['pga'];
                        }else{
                            $post['pgalist']=$post['pga'];
                        }
                    }else{
                        $this->error = "修改失败";
                        return false;
                    }
                }
                $post['token']=md5(time().$post['name']);
                $res=$this->MAdd($post);
                if($res){
                    return $res;
                }else{
                    $this->error="添加失败";
                    return false;
                }
            }
        }else{
            $this->error="垃圾名称必许填写";
            return false;
        }
    }
    //修改垃圾信息
    public function ChangeOne()
    {
        $post=Request::post();
        if(array_key_exists("name",$post)&&$post['name']!="") {
            $mcont['name'] = $post['name'];
            $fadmin = $this->MFind($mcont);
            if ($fadmin) {
                if ($fadmin['token'] != $post['token']) {
                    $this->error = "此垃圾名已经存在";
                    return false;
                } else {
                    if(array_key_exists("pga",$post)&&$post['pga']!=""){
                        $where['id']=$post['pga'];
                        $garbage=$this->MFind($where);
                        if($garbage){
                            if($garbage['pgalist']){
                                $post['pgalist']=$garbage['pgalist'].",".$post['pga'];
                            }else{
                                $post['pgalist']=$post['pga'];
                            }
                        }else{
                            $this->error = "修改失败";
                            return false;
                        }
                    }
                    $acont['token'] = $post['token'];
                    $res = $this->MUpdate($acont, $post);
                    if ($res) {
                        return $res;
                    } else {
                        $this->error = "修改失败";
                        return false;
                    }
                }
            } else {
                $acont['token'] = $post['token'];
                $res = $this->MUpdate($acont, $post);
                if ($res) {
                    return $res;
                } else {
                    $this->error = "修改失败";
                    return false;
                }
            }
        }else{
            $this->error="垃圾名称必须填写";
            return false;
        }
    }
    //分页查询信息
    public function GetList()
    {
        $post=Request::post();
        (new LimitValidate())->goCheck($post);
        if(array_key_exists("pga",$post)&&$post['pga']!=""){
            $config['page']=$post['page'];
            $config['list_rows']=$post['list_rows'];
//        $field=array("token","name","pga");
            $res=$this->MLimitSelect(["del"=>0,'pga'=>$post['pga']],$config,"id desc");
            if($res){
//                $res['data']=list_to_tree($res['data'],'id','pga');
                return $res;
            }else{
                $this->error="查询失败";
                return false;
            }
        }else{
            $this->error="缺少参数";
            return false;
        }
    }
    //查询所有信息
    public function GetAllList()
    {
        $post=Request::post();
        $res=$this->MSelect(["del"=>0],"id desc");
        if($res){
            $res=list_to_tree($res,'id','pga');
            return $res;
        }else{
            $this->error="查询失败";
            return false;
        }
    }
    //删除垃圾
    public function DeleteOne(){
        $post=Request::post();
        if(array_key_exists("id",$post)){
            $mcont['id']=$post['id'];
            $this->startTrans();
            $res=$this->MDelete($mcont);
            if($res){
                $GarPriceModel=new GarbagePrice();
                $where['garbageid']=$mcont['id'];
                $res1=$GarPriceModel->MFind($where);
                if($res1){
                    $res2=$GarPriceModel->MDelete($where);
                    if($res2){
                        $this->commit();
                        return $res2;
                    }else{
                        $this->rollback();
                        $this->error="删除失败1";
                        return false;
                    }
                }else{
                    $this->commit();
                    return $res;
                }
            }else{
                $this->rollback();
                $this->error="删除失败";
                return false;
            }
        }else{
            $this->error="缺少必要参数";
            return false;
        }
    }
    //获取单个垃圾
    public function GetOne()
    {
        $post=Request::post();
        if(array_key_exists("token",$post)){
            $mcont['token']=$post['token'];
            $res=$this->MFind($mcont);
            if($res){
                return $res;
            }else{
                $this->error="查询失败";
                return false;
            }
        }else{
            $this->error="缺少必要参数";
            return false;
        }
    }
}