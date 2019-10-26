<?php
namespace app\validate;
class NameValidate extends BaseValidate
{
    protected $rule = [
        //require是内置规则，而tp5并没有正整数的规则，所以下面这个positiveInt使用自定义的规则
        'name' => ['require'],
    ];
    protected $message = [
        'name.require' => '缺少必要参数name',
    ];
}