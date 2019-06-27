<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Carbon\Carbon;
use App\Models\CouponUser;

class Kernel extends ConsoleKernel
{
    // private $orderRepository;

    // public function __construct(OrderRepository $orderRepo)
    // {
    //     $this->orderRepository = $orderRepo;
    // }

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //备份
        $schedule->command('backup:clean')->daily()->at('01:00');
        $schedule->command('backup:run')->daily()->at('02:00');

        //自动确认收货
        $schedule->call(function () {
            app('commonRepo')->orderRepo()->autoConfirmOrder();
        })->everyMinute();

        //清理过期未支付订单
        $schedule->call(function () {
            app('commonRepo')->orderRepo()->clearExpiredOrder();
        })->everyFiveMinutes();

        
        $schedule->call(function () {
            //清理过期优惠券
            $this->clearExpiredCoupon();
            //清理用户过期的服务
            app('commonRepo')->userRepo()->clearExpiredService();
            //清理过期预约
            app('commonRepo')->subscribeRepo()->clearExpiredSub();
        })->hourly();

       
         $schedule->call(function () {
             //每天凌晨零点给用户生日提醒
             birthdayNotice();
         })->daily(); 

        //晚上查询退款结果
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    private function clearExpiredCoupon()
    {
        CouponUser::where('status', 0)->where('time_end', '<', Carbon::today())->update(['status' => 3]);
    }

}
