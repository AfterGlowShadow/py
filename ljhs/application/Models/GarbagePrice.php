<?php
namespace app\Models;
use app\validate\LimitValidate;
use app\validate\TokenValidate;
use think\facade\Request;
use app\validate\GarbagePriceAdd as GarbagePriceAddValidate;
/**
 * Class Garbage
 * 垃圾(涉及到垃圾表和垃圾价格表)
 * @package app\Models\
 */
use think\model\Pivot;

class GarbagePrice extends  BaseModel
{
    protected $table = 'garbageprice';
    protected $autoWriteTimestamp = true;
    //添加一个垃圾
    public function AddOne()
    {
        $post=Request::post();
        (new GarbagePriceAddValidate())->goCheck($post);
        if((array_key_exists("jprice",$post)&&$post['jprice']!="")||(array_key_exists("gprice",$post)&&$post['gprice']!="")){
            $mcont['garbageid']=$post['garbageid'];
            $fadmin1=$this->MBetweenTime($mcont,'starttime',$post['starttime'],$post['endtime']);
            $fadmin2=$this->MBetweenTime($mcont,'endtime',$post['starttime'],$post['endtime']);
            if($fadmin1||$fadmin2){
                $this->error="时间不能重叠";
                return false;
            }else{
                $post['token']=md5(time().$post['garbageid']);
                $res=$this->MAdd($post);
                if($res){
                    return $res;
                }else{
                    $this->error="添加失败";
                    return false;
                }
            }
        }else{
            $this->error="缺少必要参数";
            return false;
        }
    }
    //修改垃圾信息
    public function ChangeOne()
    {
        $post=Request::post();
        (new GarbagePriceAddValidate())->goCheck($post);
        (new TokenValidate())->goCheck($post);
        $fcont['token']=$post['token'];
        if((array_key_exists("jprice",$post)&&$post['jprice']!="")||(array_key_exists("gprice",$post)&&$post['gprice']!="")){
            $mcont['garbageid']=$post['garbageid'];
            $fadmin1=$this->MBetweenTime($mcont,'starttime',$post['starttime'],$post['endtime']);
            $fadmin2=$this->MBetweenTime($mcont,'endtime',$post['starttime'],$post['endtime']);
            if($fadmin1||$fadmin2){
                if($fadmin1['token']==$post['token']&&$fadmin2['token']==$post['token']){
                    $res=$this->MUpdate($fcont,$post);
                    if($res){
                        return $res;
                    }else{
                        $this->error="修改失败";
                        return false;
                    }
                }else{
                    $this->error="时间不能重叠";
                    return false;
                }
            }else{
                $res=$this->MUpdate($fcont,$post);
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
    //分页查询信息
    public function GetList()
    {
        $post=Request::post();
        (new LimitValidate())->goCheck($post);
        $config['page']=$post['page'];
        $config['list_rows']=$post['list_rows'];
        $field=array("garbageid","jprice","gprice",'starttime','regionz','endtime','token');
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
        $res=$this->MDelete($mcont);
        if($res){
            return $res;
        }else{
            $this->error="删除失败";
            return false;
        }
    }
    //预估价格(需要所选垃圾数组包含垃圾id 重量或者个数)
    public function TempPrice()
    {
        $post=Request::post();
        $checkres=$this->CheckGarbageArray($post);
        if($checkres){
            $userinfo=session("user");
            $region=$userinfo['userInfo']['region'];
            $ReGroup=new ReGroup();
            $where['regionid']=$region;
            $resReGroup=$ReGroup->MFind($where);
            $res=$this->JsTempPrice($resReGroup['regroupid'],$post['garbagearray']);
            if($res){
                return $res;
            }else{
                return false;
            }
        }else{
         return false;
        }
    }
    //计算价格
    public function JsTempPrice($region,$data,$pdata)
    {
        $res['znumber']=0;
        $res['zweight']=0;
        $res['zprice']=0;
        $res['price']=array();
        $where['garbageid']=$data;
        $where['regionz']=$region;
        $resdata=$this->MFHTime($where);
        if($resdata){
            foreach ($pdata as $key => $value)
            {
                $temparray=array();
                $temparray['id']=$value['id'];
                $temparray['price']=0;
                foreach ($data as $k=> $v){
                    if($v['garbageid']==$value['id']){
                        if($value['number']!=""){
                            $res['znumber']+=$value['number'];
                            $temparray['price']=floor(($value['number']/$v['number'])*$v['gprice']);
                            $res['price']+=$temparray['price'];
                        }else{
                            $res['zweight']+=$value['weight'];
                            $temparray['price']=floor(($value['weight']/$v['weight'])*$v['jprice']);
                            $res['price']+=$temparray['price'];
                        }
                    }
                }
                $temparray['price']=0;
                array_push($res['price'],$temparray);
            }
        }else{
            $this->error="当前时间段,不回收垃圾";
            return false;
        }
        return $res;
    }
    //验证垃圾信息
    public function CheckGarbageArray($data)
    {
        if(array_key_exists("garbagearray",$data)&&is_array($data['garbagearray'])&&strlen($data['garbagearray'])>0){
            foreach ($data['garbagearray'] as $key => $value){
                if(array_key_exists('id',$value)&&array_key_exists('number',$value)&&array_key_exists('weight',$value)){
                    if($value['number']==""&&$value['weight']==""){
                        $this->error="重量和个数不能同时为空";
                        return false;
                    }
                }else{
                    $this->error="缺少必要参数";
                    return false;
                }
            }
        }else{
            $this->error="缺少必要参数";
            return false;
        }
    }
}