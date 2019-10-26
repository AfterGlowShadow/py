<?php
	namespace app\validate;
class TokenValidate extends BaseValidate{
	 protected $rule = [
    //require是内置规则，而tp5并没有正整数的规则，所以下面这个positiveInt使用自定义的规则
        'token' => ['require'],
    ];
    protected $message = [
    	'token.require' => '缺少必要参数token',
    ];
   
}
?>