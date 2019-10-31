<?php
namespace app\Models;
use app\validate\LimitValidate;
use app\validate\Message as MessageValidate;
use app\validate\TokenValidate;
use think\facade\Request;

class Message extends BaseModel
{
    protected $table="message";

    //添加一个权限
    public function AddOne()
    {
        $post=Request::post();
        $res="";
        (new MessageValidate())->goCheck($post);
        if(array_key_exists("type",$post)&&$post['type']!=""){
            if($post['type']){
                if(!(array_key_exists("utype",$post)&&$post['utype']!=""&&array_key_exists("userid",$post)&&$post['userid']!="")){
                    $this->error="缺少必要参数";
                    return false;
                }
            }
        }
        $post['token']=md5(time());
        $res=$this->MAdd($post);
        if($res){
            return $res;
        }else{
            $this->error="添加失败";
            return false;
        }
    }
    //其他方法调用的添加消息方法
    public function AddMessage($utype,$userid,$title,$info)
    {
       $data['utype']=$utype;
       $data['userid']=$userid;
       $data['title']=$title;
       $data['info']=$info;
       $data['token']=md5(time());
       $res=$this->MAdd($data);
       if($res){
           return $res;
       }else {
           $this->error = "添加失败";
           return false;
       }
    }
    //修改管理员信息
    public function ChangeOne()
    {
        $post=Request::post();
        (new MessageValidate())->goCheck($post);
        (new TokenValidate())->goCheck($post);
        if(array_key_exists("type",$post)&&$post['type']!=""){
            if($post['type']){
                if(!(array_key_exists("utype",$post)&&$post['utype']!=""&&array_key_exists("userid",$post)&&$post['userid']!="")){
                    $this->error="缺少必要参数";
                    return false;
                }
            }
        }
        $acont['token']=$post['token'];
        $res=$this->MUpdate($acont,$post);
        if($res){
            return $res;
        }else{
            $this->error="修改失败";
            return false;
        }
    }
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
    //单个查询信息
    public function GetOne()
    {
        $post=Request::post();
        (new TokenValidate())->goCheck($post);
        $where['token']=$post['token'];
        $res=$this->MFind($where);
        if($res){
            return $res;
        }else{
            $this->error="查询失败";
            return false;
        }
    }
    //查询公告
    public function GetNotice(){
        $post=Request::post();
//        print_r($post);
//        exit;
        (new LimitValidate())->goCheck($post);
        $where['type']=0;
        $config['page']=$post['page'];
        $config['list_rows']=$post['list_rows'];
        $res=$this->MLimitSelect($where,$config);
        if($res){
            return $res;
        }else{
            $this->error="查询失败";
            return false;
        }
    }
    //查询用户公告
    public function GetUserNotice(){
        $post=Request::post();
        (new LimitValidate())->goCheck($post);
        $user=session("user");
        $where['utype']=$user['userInfo']['type'];
        $where['type']=1;
        $where['userid']=$user['userInfo']['id'];
        $config['page']=$post['page'];
        $config['list_rows']=$post['list_rows'];
        $res=$this->MLimitSelect($where,$config);
        if($res){
            return $res;
        }else{
            $this->error="查询失败";
            return false;
        }
    }
    //查询没读过的用户公告个数
    public function GetNoRead(){
        $post=Request::post();
        (new LimitValidate())->goCheck($post);
        $user=session("user");
        $where['utype']=$user['userInfo']['type'];
        $where['type']=1;
        $where['userid']=$user['userInfo']['id'];
        $where['isread']=0;
        $config['page']=$post['page'];
        $config['list_rows']=$post['list_rows'];
        $res=$this->MLimitSelect($where,$config);
        if($res){
            return $res['count'];
        }else{
            $this->error="查询失败";
            return false;
        }
    }
}