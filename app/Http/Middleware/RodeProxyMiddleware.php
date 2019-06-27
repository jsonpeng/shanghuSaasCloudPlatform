<?php

namespace App\Http\Middleware;

use Closure;

class RodeProxyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth('admin')->user();
        //dd($request->account);
       
        if ($user->type != '代理商') {
            if ($user->type == '管理员') {
             return redirect('/');
            }
            else if ($user->type == '商户') {
                return redirect('/');
            }else{
                auth('admin')->logout();
                return redirect('/zcjy/login');
            }

        }
        return $next($request);
    }
}
