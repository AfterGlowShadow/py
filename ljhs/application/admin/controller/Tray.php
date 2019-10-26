<?php
namespace app\admin\controller;
use app\Controllers\BaseController;
use app\Models\Tray as TrayModel;

class Tray extends BaseController
{
    public $Model;
    public function initialize(){
        parent::initialize();
        $this->Model=new TrayModel();
    }
}