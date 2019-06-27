<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

// use App\Models\WechatMenu;
use App\User;
use Faker\Generator AS FakerGenerator;
use Faker\Factory as FakerFactory;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        \Carbon\Carbon::setLocale('zh');

        // WechatMenu::observe('App\Observers\WechatMenuObserver');
        User::observe('App\Observers\UserObserver');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('setting', 'App\Repositories\SettingRepository');
        $this->app->singleton('commonRepo', 'App\Repositories\CommonRepository');
        $this->app->singleton('manager','App\Repositories\ManagerRepository');
        $this->app->singleton(FakerGenerator::class, function(){
            return FakerFactory::create('zh_CN');
        });
        View::composer(
                '*', 'App\Http\ViewComposers\BaseComposer'
            );
    }
}
