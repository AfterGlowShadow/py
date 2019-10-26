<?php
namespace app\Models;

use app\validate\TokenValidate;
use think\Db;
use think\facade\Request;
use think\Model;
use think\model\Pivot;
class BaseModel extends Pivot{
	protected $autoWriteTimestamp = true;     //开启自动写入时间戳
    protected $createTime = "create_time";            //数据添加的时候，create_time 这个字段不自动写入时间戳
    protected $updateTime = "update_time";
    protected $table = '';

	//添加单个数据
    public function MAdd($data)
    {
        $data=$this->removeid($data);
        return Db::name($this->table)->strict(false)->insertGetId($data);
    }
    //批量添加
    public function MBulkAdd($data)
    {
        $data=$this->removeid($data);
        return Db::name($this->table)->insertAll($data);
    }
    public function MFDelete($where)
    {
        return Db::name($this->table)->where($where)->delete();
    }
    //删除单个
    public function MDelete($where)
    {
        return Db::name($this->table)->where($where)->setField("del",1);
    }
    //修改单个
    public function MUpdate($where,$data)
    {
        $data=$this->removeid($data);
        return Db::name($this->table)->where($where)->data($data)->update();
    }
    //查询单个数据
    public function MFind($where,$order=array(),$field=array())
    {
        return Db::name($this->table)->where($where)->order($order)->field($field)->find();
    }
    //查询所有数据
    public function MSelect($where,$order=array(),$field=array())
    {
        return Db::name($this->table)->where($where)->order($order)->field($field)->select();
    }
    //分页查询数据
    public function MLimitSelect($where=array(),$config,$order=array(),$field=array())
    {
        $res['data']=Db::name($this->table)->where($where)->order($order)->field($field)->limit($config['page']*$config['list_rows'],$config['list_rows'])->select();
        $cont=Db::name($this->table)->where($where)->order($order)->field($field)->limit($config['page']*$config['list_rows'],$config['list_rows'])->count();
        $res['count']=$cont;
        $res['page']=$config['page'];
        $res['list_rows']=$config['list_rows'];
        $res['total']=ceil($cont/$config['list_rows']);
        if($res){
            return $res;
        }else{
            return "";
        }
    }
    //带时间的查询一个数据
    public function MgetOneByTime($mcont,$time,$field="")
    {
        $find=$this->where($time[0],$time[1],$time[2],'and')->where($mcont[0],$mcont[1])->field($field)->find();
        if($find){
            $find=$find->toArray();
            return $find;
        }else{
            return "";
        }
    }
    //带时间的查询一个数据
    public function MBetweenTime($where,$mcont,$starttime,$endtime,$order="",$field="")
    {
        $find=Db::name($this->table)
            ->whereBetweenTime($mcont, $starttime, $endtime)->where($where)->order($order)->field($field)
            ->find();
        return $find;
    }
    //获取当前时间数据库中有无符合条件时间段
    public function MFHTime($where,$order="",$field="")
    {
        Db::name($this->table)
            ->whereBetweenTimeField('start_time','end_time')->where($where)->order($order)->field($field)
            ->select();
    }
// 查询2017年6月1日
    //多表查询数据
    public function MDBSelect($table1,$table2,$table1n,$table2n,$where,$config,$order=array('id','asc'),$field=array(),$join="leftjoin"){
        $res['data']=Db::name($table1)
            ->where($where)
            ->alias('a')
            ->$join($table2.' w','a.'.$table1n.' = w.'.$table2n)
            ->order($order[0],$order[1])
            ->limit($config['page']*$config['list_rows'],$config['list_rows'])
            ->field($field)
            ->select();
        $cont=Db::name($table1)
            ->where($where)
            ->alias('a')
            ->$join($table2.' w','a.'.$table1n.' = w.'.$table2n)
            ->count();
        foreach ($res['data'] as $key => $value){
            if(array_key_exists("create_time",$value)){
                $res['data'][$key]['create_time']=date("Y-m-d",$value['create_time']);
            }
        }
        $res['count']=$cont;
        $res['list_row']=$config['list_rows'];
        $res['total']=ceil($cont/$config['list_rows']);
        if($res){
            return $res;
        }else{
            return "";
        }
    }
    private function removeid($data){
        if(array_key_exists("id",$data)){
            unset($data['id']);
        }
        return $data;
    }
//    //原生sql
//    public function MQuery($sql)
//    {
//        return Db::query($sql);
//    }


//提出的相同方法
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
    //获取单个垃圾
    public function GetOne()
    {
        $post=Request::post();
        (new TokenValidate())->goCheck($post);
        $mcont['token']=$post['token'];
        $mcont['del']=0;
        $mcont['status']=1;
        $res=$this->MFind($mcont);
        if($res){
            return $res;
        }else{
            $this->error="查询失败";
            return false;
        }
    }
    //添加一组数据
    public function MSaveList($dataarray){
        $this->table="lj_".$this->table;
        $res=$this->saveAll($dataarray);
        if($res){
            return $res;
        }else{
            return 0;
        }
    }
}
?>