<?php

namespace App\Listeners;

use Overtrue\LaravelWeChat\Events\WeChatUserAuthorized;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use EasyWeChat\Factory;

use App\User;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class WeChatUserAuthorizedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  WeChatUserAuthorized  $event
     * @return void
     */
    public function handle(WeChatUserAuthorized $event)
    {
        

        //$app = Factory::officialAccount(Config::get('wechat.official_account.default'));
        //$oauth = $app->oauth;

        // 获取 OAuth 授权结果用户信息
        //$user = $oauth->user();
        
        
        $isNewSession = $event->isNewSession;
        if ($isNewSession) {
            $weixin_user = $event->user;
            $weixin_user = $weixin_user->getOriginal();
            app('commonRepo')->CreateUserFromWechatOauth($weixin_user);
        }
        
        
    }
}
