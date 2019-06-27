<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Mail;
use Log;
use App\Mail\OrderPaied;

class OrderPayListener
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //订单支付成功
        if (getSettingValueByKeyCache('email')) {
            $order = $event->order;
            //给管理员发邮件
            Mail::to(getSettingValueByKeyCache('email'))->send(new OrderPaied($order));
        }
    }
}
