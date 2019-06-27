<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use App\User;

use EasyWeChat\Factory;

class AuthMiddleware
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
        // if (!Auth::guard('web')->check()) {
        //     if (Config::get('web.app_env') == 'local') {
        //         $user= User::where('openid', 'odh7zsgI75iT8FRh0fGlSojc9PWM')->first();
        //         auth('web')->login($user);
        //     }else{
        //         //当前微信用户
        //         $weixin_user = session('wechat.oauth_user.default')->getOriginal();

        //         //防止access_token过期
        //         if (array_key_exists('errcode', $weixin_user) && $weixin_user['errcode'] == 40001) {
        //             $app = Factory::officialAccount(Config::get('wechat.official_account.default'));
        //             // 强制重新从微信服务器获取 token.
        //             $token = $app->access_token->getToken(true); 
        //             //修改 $app 的 Access Token

        //             $app['access_token']->setToken($token['access_token'], 7000);
        //             //return redirect('/usercenter');
        //             $weixin_user = session('wechat.oauth_user.default')->getOriginal(); 

        //             // return $response = $app->oauth->scopes(['snsapi_userinfo'])
        //             //       ->redirect();
        //             return redirect('/');
        //         }

        //         $user = null;
        //         if (array_key_exists('unionid', $weixin_user)) {
        //             $user = User::where('unionid', $weixin_user['unionid'])->first();
        //         } else {
        //             $user = User::where('openid', $weixin_user['openid'])->first();
        //         }
        //         if (empty($user)) {
        //             $user = app('commonRepo')->CreateUserFromWechatOauth($weixin_user);
        //             auth('web')->login($user);
        //         } else {
        //             auth('web')->login($user);
        //         }
        //         //保存用户登录信息
        //         $user->last_ip = $request->ip();
        //         $user->last_login = \Carbon\Carbon::now();
        //         $user->save();
        //     }
        // }

        return $next($request);
    }
}
