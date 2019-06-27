<?php

namespace App\Observers;

use App\Services\Menu as MenuService;

use Illuminate\Support\Facades\Log;
/**
 * User模型观察者.
 *
 * @author overtrue <anzhengchao@gmail.com>
 */
class WechatMenuObserver
{

    private $menuService;

    public function __construct(
        MenuService $menuService
        )
    {
        $this->menuService = $menuService;
    }

    public function saved()
    {
        $this->menuService->syncToRemote(app('wechat.official_account'));
    }

    public function updated()
    {
        $this->menuService->syncToRemote(app('wechat.official_account'));
    }

    public function created()
    {    
        $this->menuService->syncToRemote(app('wechat.official_account'));
    }

    public function deleted()
    {
        $this->menuService->syncToRemote(app('wechat.official_account'));
    }
}
