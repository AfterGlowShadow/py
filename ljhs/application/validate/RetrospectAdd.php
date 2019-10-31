<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/24
 * Time: 13:17
 */

namespace app\validate;


class RetrospectAdd extends BaseValidate
{
    protected $rule = [
        //require是内置规则，而tp5并没有正整数的规则，所以下面这个positiveInt使用自定义的规则
        'u_id'  => 'require',
        'g_c_id' => 'require',
        'weigthing_num' => 'require',
        'weighting_method' => 'require',
    ];
    protected $message = [
        'u_id.require' => '门店id必填',
        'g_c_id.require' => '垃圾分类id必填',
        'weigthing_num.require' => '重量或数量必填',
        'weighting_method.require' => '计重方式必填',
    ];
}