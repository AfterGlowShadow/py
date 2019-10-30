<?php

namespace app\http\middleware;
use think\facade\Request;
class UserCheck
{
    public function handle($request, \Closure $next)
    {
 		if(session('user')=="")
		{
			BackData(400,"请登录账号");
      exit;
		}else{
      $user=session('user');
      $param=Request::param();
      if($user['authKey']!=$param['token']){
        BackData(400,"请登录账号");
        exit;
      }
    }
      return $next($request);
    }
}
