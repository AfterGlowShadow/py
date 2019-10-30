<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/24
 * Time: 11:41
 */

namespace app\Models;


use app\validate\LimitValidate;
use app\validate\RetrospectAdd;
use think\facade\Request;
use think\facade\Validate;

class Retrospect extends BaseModel
{
    protected $table = 'retrospect';
    public function comments()
    {
        return $this->hasMany('GarbagePrice','garbageid');
    }
    //添加一个本地库存
    public function AddOne()
    {
        $post=Request::post();
        (new RetrospectAdd())->goCheck($post);
        $res=$this->MAdd($post);
        if ($res) {
            return $res;
        } else {
            $this->error = "添加失败";
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
    //分页查询门店垃圾库存信息
    public function GetList()
    {
        $post=Request::post();
        if(empty($post['u_id'])){
            $this->error="门店id必填";
            return false;
        }
        (new LimitValidate())->goCheck($post);
        $config['page']=$post['page'];
        $config['list_rows']=$post['list_rows'];
        $field=array("u_id","g_c_id","weigthing_num","weighting_method");
        $res=$this->MLimitSelect(["u_id"=>$post['u_id'],'status'=>0,'del'=>0],$config,"id desc",$field);
        if($res){
            return $res;
        }else{
            $this->error="查询失败";
            return false;
        }
    }
    //删除门店垃圾库存
    public function DeleteOne(){
        $post=Request::post();
        if(array_key_exists("id",$post)){
            $mcont['id']=$post['id'];
            $res=$this->MDelete($mcont);
            if($res){
                return $res;
            }else{
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