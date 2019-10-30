<?php
namespace app\admin\controller;
use app\Controllers\BaseController;
use app\Models\Group as GroupModel;
class Group extends BaseController
{
    public $Model;
    public function initialize(){
        parent::initialize();
        $this->Model=new GroupModel();
    }
}