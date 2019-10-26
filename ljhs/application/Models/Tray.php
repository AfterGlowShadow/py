<?php
namespace app\Models;

use app\validate\AdminUpdate as AdminUpdateValidate;
use app\validate\LimitValidate;
use app\validate\LoginValidate;
use think\facade\Request;

class Tray extends BaseModel
{
    protected $table="tray";
    //添加一个管理员
    public function AddOne()
    {
        $post=Request::post();
        if(array_key_exists("number",$post)&&$post['number']!=""){
            $mcont['number']=$post['number'];
            $fadmin=$this->MFind($mcont);
            if($fadmin){
                $this->error="此编号已经存在";
                return false;
            }else{
                $post['token']=md5(time());
                $res=$this->MAdd($post);
                if($res){
                    return $res;
                }else{
                    $this->error="添加失败";
                    return false;
                }
            }
        }else{
            $this->error="托盘编号不能为空";
            return false;
        }
    }
    //修改管理员信息
    public function ChangeOne()
    {
        $post=Request::post();
        if(array_key_exists("number",$post)&&$post['number']!="") {
            $mcont['number'] = $post['number'];
            $fadmin = $this->MFind($mcont);
            if ($fadmin) {
                if ($fadmin['token'] != $post['token']) {
                    $this->error = "此编号已经存在";
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
            $this->error="托盘编号不能为空";
            return false;
        }
    }
    //分页查询信息
    public function GetList()
    {
        $post=Request::post();
        (new LimitValidate())->goCheck($post);
        $config['page']=$post['page'];
        $where['status']=1;
        $where['del']=0;
        $config['list_rows']=$post['list_rows'];
        $field=array("number","status","zweight","number","cweight","cnumber",'remark');
        $res=$this->MLimitSelect($where,$config,"id desc",$field);
        if($res){
            return $res;
        }else{
            $this->error="查询失败";
            return false;
        }
    }
}