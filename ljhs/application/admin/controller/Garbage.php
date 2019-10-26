<?php
namespace app\admin\controller;
use app\Controllers\BaseController;
use app\Models\Garbage as GarbageModel;
class Garbage extends BaseController
{
    public $Model;
    public function initialize(){
        parent::initialize();
        $this->Model=new GarbageModel();
    }
    public function region()
    {
        return $this->belongsToMany('RegionGroup','GarbagePrice','garbageid','id');
    }

    public function GetAllList()
    {
        $res = $this->Model->GetAllList();
        Back($res, "查询成功", $this->Model->getError());
    }
}