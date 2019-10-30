<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/24
 * Time: 11:59
 */

namespace app\home\controller;
use app\Controllers\BaseController;
use app\Models\GarbagePrice;
use app\Models\Retrospect as MRetrospect;
use think\facade\Request;

class Retrospect extends BaseController
{
    public $Model;
    public function initialize(){
        parent::initialize();
        $this->Model=new MRetrospect();
    }

    /**
     * 预估报价列表
     */
    public function GetRetrospectList(){
        $post=Request::post();
        if(empty($post['ids'])){
            Back(false,'',"缺少必传参数");
        }
        $return = array();
        $ids_arr = explode(',',$post['ids']);
        foreach ($ids_arr as $k=>$v){
            $mcont['id'] = $v;
            $return[$k]['data'] = $this->Model->MFind($mcont);
            $tempRes = getGarbagePrice($return[$k]['data']["g_c_id"],new GarbagePrice());
            if($tempRes['status'] == 0){
                Back(false,'',"暂无报价信息，请稍候再试");
            }
            $return[$k]['data']['price'] = $tempRes['data'];
        }
        Back($return,"获取成功",$this->Model->getError());
    }
}