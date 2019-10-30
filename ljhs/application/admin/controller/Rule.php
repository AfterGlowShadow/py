<?php
namespace app\admin\controller;
use app\Controllers\BaseController;
use app\Models\Rule as RuleModel;
class Rule extends BaseController
{
    public $Model;
    public function initialize(){
        parent::initialize();
        $this->Model=new RuleModel();
    }
}