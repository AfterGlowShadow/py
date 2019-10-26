<?php

namespace app\http\middleware;

class Check
{
    public function handle($request, \Closure $next)
    {
 		if(session('admin')=="")
		{
			return redirect('/admin/login');
		}
        return $next($request);
    }
}
