<?php
namespace app\Models;
use app\validate\LimitValidate;
use app\validate\NameValidate;
use app\validate\TokenValidate;
use think\facade\Request;
class Group extends BaseModel
{
    protected $table = 'group';
    public function rules()
    {
        return $this->belongsToMany('Rule','grouprule','groupid','id');
    }
    //添加一个权限
    public function AddOne()
    {
        $post=Request::post();
        (new NameValidate())->goCheck($post);
        $mcont['name']=$post['name'];
        $fadmin=$this->MFind($mcont);
        if($fadmin){
            $this->error="此名称已经存在";
            return false;
        }else{
            $post['token']=md5(time());
            $this->startTrans();
            $res=$this->MAdd($post);
            if($res){
                if(array_key_exists("rulelist",$post)&&$post['rulelist']){
                    $rulelist=array();
                    foreach ($post['rulelist'] as $key => $value){
                        $temp=array();
                        $temp['groupid']=$res;
                        $temp['ruleid']=$value;
                        array_push($rulelist,$temp);
                    }
                    $grouprule=new GroupRule();
                    $res1=$grouprule->MSaveList($rulelist);
                    if($res1){
                        $this->commit();
                        return $res;
                    }else{
                        $this->error="添加失败";
                        $this->rollback();
                        return $res;
                    }
                }else{
                    $this->commit();
                    return $res;
                }
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
        (new NameValidate())->goCheck($post);
        if(array_key_exists("id",$post)&&$post['id']!=""){
            $mcont['name']=$post['name'];
            $where['del']=0;
            $where['status']=1;
            $fadmin=$this->MFind($mcont);
            if($fadmin){
                if($fadmin['id']!=$post['id']){
                    $this->error="此名称已经存在";
                    return false;
                }else{
                    $res=$this->Change($post);
                    if($res){
                        return $res;
                    }else{
                        return false;
                    }
                }
            }else{
                $res = $this->Change($post);
                if($res){
                    return $res;
                }else{
                    $this->error="修改失败";
                    return false;
                }
            }
        }else{
            $this->error="缺少必要参数";
            return false;
        }
    }

    public function Change($data)
    {
        $acont['id']=$data['id'];
        $this->startTrans();
        $res=$this->MUpdate($acont,$data);
        if($res){
            $grouprule=new GroupRule();
            $where['groupid']=$data['id'];
            $where['del']=0;
            $field=array("ruleid");
            $grouprulelist=$grouprule->MFind($where,'','',$field);
            if(strlen($grouprulelist)>0){
                $scha=array_diff($grouprulelist,$data['rulelist']);
                $grwhere['groupid']=$data['id'];
                $grwhere['ruleid']=$scha;
                $res2=$grouprule->MFDelete($grwhere);
                if($res2){
                    $rulelist=array();
                    $jcha=array_diff($data['rulelist'],$grouprulelist);
                    foreach ($jcha as $key => $value){
                        $temp=array();
                        $temp['groupid']=$data['id'];
                        $temp['ruleid']=$value;
                        array_push($rulelist,$temp);
                    }
                    $res1=$grouprule->MSaveList($rulelist);
                    if($res1){
                        return $res1;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }else {
                $rulelist=array();
                foreach ($data['rulelist'] as $key => $value){
                    $temp=array();
                    $temp['groupid']=$data['id'];
                    $temp['ruleid']=$value;
                    array_push($rulelist,$temp);
                }
                $res1 = $grouprule->MSaveList($rulelist);
                if($res1){
                    return $res1;
                }else{
                    return false;
                }
            }
        }else{
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
        $field=array("name","remark","token");
        $res=$this->MLimitSelect("",$config,"id desc",$field);
        if($res){
            return $res;
        }else{
            $this->error="查询失败";
            return false;
        }
    }
    //删除垃圾
    public function DeleteOne(){
        $post=Request::post();
        (new TokenValidate())->goCheck($post);
        $mcont['token']=$post['token'];
        $group=$this->MFind($mcont);
        $this->startTrans();
        $res=$this->MDelete($mcont);
        if($res){
            $mcont1['groupid']=$group['id'];
            $grouprule=new GroupRule();
            $res1=$grouprule->MDelete($mcont1);
            if($res1){
                $this->commit();
                return $res;
            }else{
                $this->rollback();
                $this->error="删除失败";
                return false;
            }
        }else{
            $this->error="删除失败";
            return false;
        }
    }
}