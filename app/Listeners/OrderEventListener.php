<?php

namespace App\Listeners;

use App\Events\OrderEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Repositories\CouponRepository;
use App\Repositories\OrderRepository;

use App\User;
use App\Models\UserLevel;
use Log;

class OrderEventListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    private $couponRepository;
    private $orderRepository;

    public function __construct(CouponRepository $couponRepo, OrderRepository $orderRepo)
    {
        $this->couponRepository = $couponRepo;
        $this->orderRepository = $orderRepo;
    }

    /**
     * Handle the event.
     *
     * @param  Event  $event
     * @return void
     */
    public function handle(OrderEvent $event)
    {
        //处理用户订单成功后的信息
        $order = $event->order;
        $user = $order->customer;
        
        if (funcOpen('FUNC_COUPON')) {
            //购物满送优惠券
            $coupons = $this->couponRepository->getCouponOfRule(1, $order->price);

            $couponsArrays = [];
            foreach ($coupons as $key => $value) {
                array_push($couponsArrays, $value->id);
            }
            app('commonRepo')->processGivenCoupon([$user], $couponsArrays, 1, '购物满送');
            //推荐新用户下单送优惠券
            if ($user->leader1 && $user->orders()->where('order_pay', '已支付')->where('order_delivery', '已收货')->count() <= 1) {
                //首单才送
                $coupons = $this->couponRepository->getCouponOfRule(3);
                $parent = User::where('id', $user->leader1)->first();

                $couponsArrays = [];
                foreach ($coupons as $key => $value) {
                    array_push($couponsArrays, $value->id);
                }
                if (!empty($parent)) {
                    app('commonRepo')->processGivenCoupon([$parent], $couponsArrays, 1, '推荐新用户下单赠送');
                }
            }
        }
        
        
        //积分
        if (funcOpen('FUNC_CREDITS')) {
            $credit_rate = getSettingValueByKeyCache('consume_credits');
            if ($credit_rate) {
                $newCredits = intdiv($order->price*$credit_rate, 100);
                if ($newCredits) {
                    $user->credits += $newCredits;
                    //添加积分记录
                    app('commonRepo')->addCreditLog($user->credits, $newCredits, '用户购物赠送，订单编号为:'.$order->snumber, 2, $user->id);
                }
            }
        }
        
        //已开启分销功能
        if (funcOpen('FUNC_DISTRIBUTION') && getSettingValueByKeyCache('distribution') == '是') {
            //总提成金额
            $total_commission = 0;
            //按订单或者商品提成  
            if (getSettingValueByKeyCache('distribution_type') == '商品') {
                $total_commission = $this->orderRepository->productCommission($order->id);
            } else {
                //按订单提成
                $total_commission = round($order->price * getSettingValueByKeyCache('distribution_percent') / 100, 2);
            }

            //自己提成
            if (getSettingValueByKeyCache('distribution_selft')) {
                if (!empty($user) && (getSettingValueByKeyCache('distribution_condition') == '注册用户' || $user->is_distribute)) {

                    $user_given_money = round($total_commission * floatval(getSettingValueByKeyCache('distribution_selft')) / 100 , 2);

                    if ($user_given_money) {
                        $user->user_money += $user_given_money;
                        $user->distribut_money += $user_given_money;
                        //添加金额变动记录
                        app('commonRepo')->addMoneyLog($user->user_money, $user_given_money, '用户消费提成，订单编号为:'.$order->snumber, 2, $user->id);
                        app('commonRepo')->addDistributionLog($order, $user->id, 0, $user_given_money);
                    }
                    
                }
            }
            
            //一级分销
            if ($user->leader1) {
                $leader1 = User::where('id', $user->leader1)->first();
                //该用户有分销资格
                if (!empty($leader1) && (getSettingValueByKeyCache('distribution_condition') == '注册用户' || $leader1->is_distribute)) {
                    $level1_given_money = round($total_commission * floatval(getSettingValueByKeyCache('distribution_level1_percent')) / 100, 2);
                    if ($level1_given_money) {
                        $leader1->user_money += $level1_given_money;
                        $leader1->distribut_money += $level1_given_money;
                        $leader1->save();

                        //添加金额变动记录
                        app('commonRepo')->addMoneyLog($leader1->user_money, $level1_given_money, '一级推荐用户消费提成，订单编号为:'.$order->snumber, 2, $leader1->id);
                        app('commonRepo')->addDistributionLog($order, $leader1->id, 1, $level1_given_money);
                    }
                }
            }

            //二级分销
            if ($user->leader2) {
                $leader2 = User::where('id', $user->leader2)->first();
                //该用户有分销资格
                if (!empty($leader2) && (getSettingValueByKeyCache('distribution_condition') == '注册用户' || $leader2->is_distribute)) {
                    $level2_given_money = round($total_commission * floatval(getSettingValueByKeyCache('distribution_level2_percent')) / 100, 2);
                    if ($level2_given_money) {
                        $leader2->user_money += $level2_given_money;
                        $leader2->distribut_money += $level2_given_money;
                        $leader2->save();

                        //添加金额变动记录
                        app('commonRepo')->addMoneyLog($leader2->user_money, $level2_given_money, '二级推荐用户消费提成，订单编号为:'.$order->snumber, 2, $leader2->id);
                        app('commonRepo')->addDistributionLog($order, $leader2->id, 2, $level2_given_money);
                    }
                }
            }

            //三级分销
            if ($user->leader3) {
                $leader3 = User::where('id', $user->leader3)->first();
                //该用户有分销资格
                if (!empty($leader3) && (getSettingValueByKeyCache('distribution_condition') == '注册用户' || $leader3->is_distribute)) {
                    $level3_given_money = round($total_commission * floatval(getSettingValueByKeyCache('distribution_level3_percent')) / 100, 2);
                    if ($level3_given_money) {
                        $leader3->user_money += $level3_given_money;
                        $leader3->distribut_money += $level3_given_money;
                        $leader3->save();

                        //添加金额变动记录
                        app('commonRepo')->addMoneyLog($leader3->user_money, $level3_given_money, '三级推荐用户消费提成，订单编号为:'.$order->snumber, 2, $leader3->id);
                        app('commonRepo')->addDistributionLog($order, $leader3->id, 3, $level3_given_money);
                    }
                    
                }
            }

            //更新用户信息
            //用户总消费金额
            $user->consume_total += $order->price;
            if (funcOpen('FUNC_CREDITS')) {
                //会员等级是否可以升级
                $userLevel = UserLevel::where('amount', '<=', $user->consume_total)->orderBy('amount', 'desc')->first();
                if (!empty($userLevel) && $user->user_level != $userLevel->id) {
                    $user->user_level = $userLevel->id;
                }
            }

            if (funcOpen('FUNC_DISTRIBUTION') && getSettingValueByKeyCache('distribution') == '是' && getSettingValueByKeyCache('distribution_condition') == '购买商品') {
                //未获取分销资格，则取得分销资格
                if ($user->is_distribute == 0) {
                    $user->is_distribute = 1;
                }
            }
            
            $user->save();
        }
        
    }
}
