<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Zizaco\Entrust\EntrustFacade as Entrust;
use Route,URL;
use Illuminate\Support\Facades\Log;

class AdminAuthenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $input=$request->all();
        //dd($request);
        if (Auth::guard('admin')->guest()) { 
            if($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else { 
                #如果总部管理员一个都没有就跳到注册
                //if(app('manager')->count()){
                    return redirect()->guest('zcjy/login');
                 // }else{
                 //    return redirect()->guest('zcjy/register');
                 // }
            } 
        }


        return $next($request);
    }
}
