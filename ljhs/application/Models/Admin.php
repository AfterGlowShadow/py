<?php
namespace app\Models;
use app\validate\LimitValidate;
use app\validate\LoginValidate;
use app\validate\LoginChange as LoginChangeValidate;
use app\validate\TokenValidate;
use think\facade\Request;
use app\validate\AdminAdd as AdminAddValidate;
class Admin extends BaseModel
{
    protected $table = 'administrator';
    public  function login(){
        $post=Request::post();
        (new LoginValidate())->goCheck($post);
    	$acont['name']=$post['name'];
    	$acont['status']=1;
    	$acont['del']=0;
    	$admin=$this->MFind($acont);
    	if(!$admin){
    		$this->error="帐号或密码错误";
    		return false;	
    	}else{
    		if($post['pwd']!==$admin['pwd']){
    			$this->error="帐号或密码错误";
    			return false;
    		}else{
                $cache['userInfo']=$admin;
                $cache['time']=time();
                $cache['authKey']=md5($admin['id'].$admin['name'].$admin['pwd'].$cache['time']);
                session('admin',$cache,'think');
                return $cache['authKey'];
    		}
    	}
    }
    //退出登录
    public function logout(){
        Session("admin","");
        return 1;
    }
    //修改登录密码与账号
    public function UpPwd(){
        $post=Request::post();
        (new LoginChangeValidate())->goCheck($post);
        $seadmin=Session("userInfo");
        $acont['id']=$seadmin['id'];
        $admin=$this->MFind($acont);
        if($admin){
            if($admin['name']==$post['name']&&$admin['pwd']==$post['oldpwd']){
                $this->error="密码错误";
                return false;
            }else{
                $data['name']=$post['name'];
                $data['pwd']=$post['pwd'];
                $res=$this->MUpdate($data,$acont);
                if($res){
                    $cache['userInfo']=$data;
                    $cache['time']=time();
                    $cache['authKey']=md5($admin['ad_id'].$data['name'].$data['pwd'].$cache['time']);
                    session('admin',$cache,'think');
                    return $cache['authKey'];
                }else{
                    $this->error="修改失败";
                    return false;
                }
            }
        }else{
            $this->error="网络错误,请重新登录";
            return false;
        }
    }
    //添加一个管理员
    public function AddOne()
    {
        $post=Request::post();
        (new AdminAddValidate())->goCheck($post);
        $mcont['name']=$post['name'];
        $mcont['status']=1;
        $mcont['del']=0;
        $fadmin=$this->MFind($mcont);
        if($fadmin){
            $this->error="此用户名已经存在";
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
    }
    //修改管理员信息
    public function ChangeOne()
    {
        $post=Request::post();
        (new AdminAddValidate())->goCheck($post);
        (new TokenValidate())->goCheck($post);
        $mcont['name']=$post['name'];
        $mcont['status']=1;
        $mcont['del']=0;
        $fadmin=$this->MFind($mcont);
        if($fadmin){
            if($fadmin['token']==$post['token']){
                $this->error="此用户名已经存在";
                return false;
            }else{
                $acont['token']=$post['token'];
                $res=$this->MUpdate($acont,$post);
                if($res){
                    return $res;
                }else{
                    $this->error="修改失败";
                    return false;
                }
            }
        }else{
            $acont['token']=$post['token'];
            $res=$this->MUpdate($acont,$post);
            if($res){
                return $res;
            }else{
                $this->error="修改失败";
                return false;
            }
        }
    }
    //分页查询信息
    public function GetList()
    {
        $post=Request::post();
        (new LimitValidate())->goCheck($post);
        $config['page']=$post['page'];
        $config['list_rows']=$post['list_rows'];
        $field=array("token","name","phone",'id');
        $where['status']=1;
        $where['del']=0;
        $res=$this->MLimitSelect($where,$config,"id desc",$field);
        if($res){
            return $res;
        }else{
            $this->error="查询失败";
            return false;
        }
    }
    //删除用户
    public function DeleteOne(){
        $post=Request::post();
        if(array_key_exists("token",$post)){
            $mcont['token']=$post['token'];
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
}