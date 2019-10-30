<?php


namespace app\Validate;


class TempOrder extends BaseValidate
{
    protected $rule = [
        //require是内置规则，而tp5并没有正整数的规则，所以下面这个positiveInt使用自定义的规则
        'zsnumber' => ['require'],
        'zweight' => ['require'],
        'saleolist'=>['require'],
        'price' =>['request','number'],
    ];
    protected $message = [
        'zsnumber.require' => '总个数不能没有',
        'zweight.require' => '总重量不能没有',
        'saleolist.require' => '必许选择订单列表',
        'price.require' => '总价格不能为空',
        'price.number' => '总价格必须是数字',
    ];
}