<?php
namespace app\validate;
class Order extends BaseValidate
{
    protected $rule = [
        //require是内置规则，而tp5并没有正整数的规则，所以下面这个positiveInt使用自定义的规则
        'number' => ['require'],
        'weight' => ['require'],
        'price'=>['require','isInt']
    ];
    protected $message = [
//        'garbagelist.require' => '必须添选垃圾',
        'number.require' => '总数量不能为空',
        'weight.require' => '总重量不能为空',
        'price.require' => '总价格不能为空',
        'price.isInt' => '总价格必须是正整数',
    ];
}