<?php
namespace app\admin\controller;
use app\Controllers\BaseController;
use app\Models\TiXian as TiXianModel;
class TiXian extends BaseController
{
    public $Model;
    public function initialize(){
        parent::initialize();
        $this->Model=new TiXianModel();
    }
}