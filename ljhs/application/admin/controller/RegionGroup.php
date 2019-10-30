<?php
namespace app\admin\controller;
use app\Controllers\BaseController;
use app\Models\RegionGroup as RegionGroupModel;
class RegionGroup extends BaseController
{
    public $Model;
    public function initialize(){
        parent::initialize();
        $this->Model=new RegionGroupModel();
    }
}