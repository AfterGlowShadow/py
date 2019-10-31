<?php

namespace app\http\middleware;

use think\facade\Request;

class AdminCheck
{
    /**
     * @param $request
     * @param \Closure $next
     * @return mixed
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2019-10-26
     * Time: 09:40
     */
    public function handle($request, \Closure $next)
    {
        if (session('admin') == "") {
            BackData(400, "请登录账号");
            exit;
        } else {
            $user = session('admin');
            $param = Request::param();
            if ($user['authKey'] != $param['token']) {
                BackData(400, "请登录账号");
                exit;
            }else{
                if($user['admin']!=1){
                    BackData(400,'权限不足');
                }
            }
        }
        return $next($request);
    }
}
