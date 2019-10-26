<?php
namespace app\validate;
class Message extends BaseValidate
{
    protected $rule = [
        'title' => ['require'],
        'info' => ['require'],
    ];
    protected $message = [
        'title.require' => '标题不能为空',
        'info.require' => '内容不能为空',
        // 'yzm.require'=>'验证码不能为空',
    ];
}