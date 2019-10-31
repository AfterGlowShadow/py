<?php
namespace app\validate;
class UserAdd extends BaseValidate
{
    protected $rule = [
        //require是内置规则，而tp5并没有正整数的规则，所以下面这个positiveInt使用自定义的规则
        //'code' => ['require'],
        'name' => ['require'],
        'pwd' => ['require'],
        'realname'=>['require'],
        'phone'=>['require'],
        'zhicheng'=>['require'],
        'province'=>['require'],
        'city'=>['require'],
        'county'=>['require'],
        'address'=>['require'],
        'longitude'=>['require'],
        'latitude'=>['require'],
//        'type'=> ['require']
    ];
    protected $message = [
//        'type.require' =>'缺少必要参数',
        'name.require' => '用户名不能为空',
        'pwd.require' => '密码不能为空',
        'phone.require'=>'手机号不能为空',
        'zhicheng.require'=>'门店名称不能为空',
        'realname.require'=>'真实姓名不能为空',
        'province.require'=>'省不能为空',
        'city.require'=>'市不能为空',
        'county.require'=>'县不能为空',
        'address.require'=>'详细地址不能为空',
        'longitude.require'=>'经度不能为空',
        'latitude.require'=>'纬度不能为空',
    ];
}