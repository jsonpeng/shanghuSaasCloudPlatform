<?php

namespace App\Repositories;


use App\Repositories\BannerRepository;
use App\Repositories\ProductRepository;
use App\Repositories\CouponRepository;
use App\Repositories\CouponUserRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ServicesRepository;
use App\Repositories\StoreShopRepository;
use App\Repositories\OrderRepository;
use App\Repositories\TeamSaleRepository;
use App\Repositories\FlashSaleRepository;
use App\Repositories\NoticeRepository;
use App\Repositories\SettingRepository;
use App\Repositories\UserLevelRepository;
use App\Repositories\OrderPrompRepository;
use App\Repositories\SubscribeRepository;
use App\Repositories\UserRepository;
use App\Repositories\CreditsServiceRepository;
use App\Repositories\CreditServiceUserRepository;
use App\Repositories\TechnicianRepository;
use App\Repositories\TopupGiftsRepository;
use App\Repositories\TopupLogRepository;
use App\Repositories\DiscountOrderRepository;
use App\Repositories\AdminPackageRepository;
use App\Repositories\StatRepositoryRepository;
use App\Repositories\ProductImageRepository;
use App\Repositories\ChargePackageRepository;
use App\Repositories\PackageLogRepository;
use App\Repositories\ChargePackagesPriceRepository;

use Auth;
use Config;
use ShoppingCart;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\CouponUser;
use App\Models\UserLevel;
use App\Models\CreditLog;
use App\Models\MoneyLog;
use App\Models\ServicesUser;

use Redirect,Response;
use Image;

use App\Models\DistributionLog;
use App\User;
use Log;

use EasyWeChat\Factory;
use App\Events\OrderPay;
use Overtrue\EasySms\EasySms;

class CommonRepository
{

    private $productRepository;
    private $couponRepository;
    private $categoryRepository;
    private $couponUserRepository;
    private $orderRepository;
    private $bannerRepository;
    private $teamSaleRepository;
    private $flashSaleRepository;
    private $noticeRepository;
    private $settingRepository;
    private $storeShopRepository;
    private $servicesRepository;
    private $userLevelRepository;
    private $orderPrompRepository;
    private $userRepository;
    private $creditsServiceRepository;
    private $creditServiceUserRepository;
    private $technicianRepository;
    private $topupGiftsRepository;
    private $topupLogRepository;
    private $discountOrderRepository;
    private $adminPackageRepository;
    private $statRepositoryRepository;
    private $productImageRepository;
    private $chargePackageRepository;
    private $packageLogRepository;
    private $chargePackagesPriceRepository;
    public function __construct(
        ServicesRepository $servicesRepo,
        StoreShopRepository $storeShopRepo,
        CouponRepository $couponRepo, 
        CategoryRepository $categoryRepo, 
        CouponUserRepository $couponUserRepo, 
        ProductRepository $productRepo,
        OrderRepository $orderRepo,

        BannerRepository $bannerRepo,
        TeamSaleRepository $teamSaleRepo,
        FlashSaleRepository $flashSaleRepo,
        NoticeRepository $noticeRepo,
        SettingRepository $settingRepo,
        UserLevelRepository $userLevelRepo,
        OrderPrompRepository $orderPrompRepo,
        SubscribeRepository $subscribeRepo,
        UserRepository $userRepo,
        CreditsServiceRepository $creditsServiceRepo,
        CreditServiceUserRepository $creditServiceUserRepo,
        TechnicianRepository $technicianRepo,
        TopupGiftsRepository $topupGiftsRepo,
        TopupLogRepository $topupLogRepo,
        DiscountOrderRepository $discountOrderRepo,
        AdminPackageRepository $adminPackageRepo,
        StatRepositoryRepository $statRepo,
        ProductImageRepository $productImageRepo,
        ChargePackageRepository $chargePackageRepo,
        PackageLogRepository $packageLogRepo,
        ChargePackagesPriceRepository $chargePackagesPriceRepo
    )
    {
        $this->servicesRepository = $servicesRepo;
        $this->storeShopRepository = $storeShopRepo;
        $this->productRepository = $productRepo;
        $this->couponRepository = $couponRepo;
        $this->categoryRepository = $categoryRepo;
        $this->couponUserRepository = $couponUserRepo;
        $this->orderRepository = $orderRepo;
        $this->bannerRepository = $bannerRepo;
        $this->teamSaleRepository = $teamSaleRepo;
        $this->flashSaleRepository = $flashSaleRepo;
        $this->noticeRepository = $noticeRepo;
        $this->settingRepository = $settingRepo;
        $this->userLevelRepository = $userLevelRepo;
        $this->orderPrompRepository = $orderPrompRepo;
        $this->subscribeRepository = $subscribeRepo;
        $this->userRepository   = $userRepo;
        $this->creditsServiceRepository = $creditsServiceRepo;
        $this->creditServiceUserRepository = $creditServiceUserRepo;
        $this->technicianRepository = $technicianRepo;
        $this->topupGiftsRepository = $topupGiftsRepo;
        $this->topupLogRepository = $topupLogRepo;
        $this->discountOrderRepository = $discountOrderRepo;
        $this->adminPackageRepository = $adminPackageRepo;
        $this->statRepositoryRepository = $statRepo;
        $this->productImageRepository = $productImageRepo;
        $this->chargePackageRepository = $chargePackageRepo;
        $this->packageLogRepository = $packageLogRepo;
        $this->chargePackagesPriceRepository = $chargePackagesPriceRepo;
    }
    
    public function packagePriceRepo(){
        return $this->chargePackagesPriceRepository;
    }

    public function packageLogRepo(){
        return $this->packageLogRepository;
    }

    public function chargePackageRepo(){
        return $this->chargePackageRepository;
    }
    
    public function productImageRepo(){
        return $this->productImageRepository;
    }

    public function statRepo(){
        return $this->statRepositoryRepository;
    }

    public function adminPackageRepo(){
        return $this->adminPackageRepository;
    }

    public function serviceUserModel(){
        return ServicesUser::class;
    }

    public function discountOrderRepo(){
        return $this->discountOrderRepository;
    }

    public function topupLogRepo(){
        return $this->topupLogRepository;
    }

    public function topupGiftsRepo(){
        return $this->topupGiftsRepository;
    }

    public function technicianRepo(){
        return $this->technicianRepository;
    }

    public function creditServiceUserRepo(){
        return $this->creditServiceUserRepository;
    }

    public function creditsServiceRepo(){
        return $this->creditsServiceRepository;
    }

    public function couponRepo(){
        return $this->couponRepository;
    }

    public function userRepo(){
        return $this->userRepository;
    }
    
    public function subscribeRepo(){
        return $this->subscribeRepository;
    }
    
    public function userLevelRepo(){
        return $this->userLevelRepository;
    }

    public function serviceRepo(){
        return $this->servicesRepository;
    }

    public function shopRepo(){
        return $this->storeShopRepository;
    }

    public function settingRepo(){
        return $this->settingRepository;
    }

    public function bannerRepo()
    {
        return $this->bannerRepository;
    }

    public function orderRepo()
    {
        return $this->orderRepository;
    }


    public function categoryRepo()
    {
        return $this->categoryRepository;
    }

    public function teamSaleRepo()
    {
        return $this->teamSaleRepository;
    }

    public function flashSaleRepo()
    {
        return $this->flashSaleRepository;
    }

    public function productRepo()
    {
        return $this->productRepository;
    }

    public function noticeRepo()
    {
        return $this->noticeRepository;
    }


    //为account生成字符串数字组合
    public function accountString($length = 8)
    { 
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789'; 
        $password = ''; 
        for ( $i = 0; $i < $length; $i++ ) 
        { 
            $password .= $chars[ mt_rand(0, strlen($chars) - 1) ]; 
        }
        //判断是否重复
        if (Admin::where('account', $password)->count()) {
            return $this->randomString();
        } else {
            return $password; 
        }
    } 

    /**
     * 计算优惠券优惠金额
     * @param [integer] $coupon_id [优惠券ID]
     */
    public function CouponPreference($coupon_id, $total)
    {
        //计算优惠券能不能用
        $coupon = $this->couponUserRepository->findWithoutFail($coupon_id);
        if (empty($coupon)) {
            return ['code' => 1, 'message' => '优惠券不存在'];
        }
        //检查优惠券状态
        if ($coupon->status != 0) {
            switch ($coupon->status) {
                case 1:
                    return ['code' => 1, 'message' => '优惠券被冻结'];
                    break;
                case 2:
                    return ['code' => 1, 'message' => '优惠券已使用'];
                    break;
                case 3:
                    return ['code' => 1, 'message' => '优惠券已过期'];
                    break;
                case 4:
                    return ['code' => 1, 'message' => '优惠券已作废'];
                    break;
                default:
                    return ['code' => 1, 'message' => '优惠券无法被使用'];
                    break;
            }
        }

        //检查优惠券的有效期
        $today = Carbon::today();
        if ( Carbon::parse($coupon->time_begin)->gt($today) || Carbon::parse($coupon->time_end)->lt($today) ) {
            return ['code' => 1, 'message' => '不在优惠券的使用期限内'];
        }
        //检查优惠券的使用条件
        //金额是否可以达到
        $originCoupon = $coupon->coupon;

        if ($originCoupon->base > $total) {
            return ['code' => 1, 'message' => '无法使用该优惠券，购物金额还差'.($originCoupon->base - $total)];
        }

        $totalPrice = 0;
        $youhui = 0;
        $preferPriceTotal = 0;

        $preferPriceTotal = $total;
    
        $name = '';
        if ($originCoupon->type == '满减') {
            $youhui = $originCoupon->given;
            $name = '满'.$originCoupon->base.'减'.$originCoupon->given;
        }else{
            $youhui = round((100 - $originCoupon->discount) * $preferPriceTotal/100, 2);
            $name = '满'.$originCoupon->base.'打'.$originCoupon->discount.'折';
        }

        return ['code' => 0, 'message' => [
            'discount' => $youhui,
            'coupon_id' => $coupon->id,
            'name' => $name
        ]];
    }

    /**
     * 订单优惠金额
     * @param  [float] $totalPrice [订单总金额]
     * @return [type]             [description]
     */
    public function orderPreference($totalPrice)
    {
        $orderPromp = $this->orderPrompRepository->getSuitablePromp($totalPrice);
        if (empty($orderPromp)) {
            return ['prom_id' => 0, 'money' => 0, 'name' => ''];
        }else{
            if ($orderPromp->type) {
                //减价
                return ['prom_id' => $orderPromp->id, 'money' => $orderPromp->value, 'name' => '购物满'.$orderPromp->base.'减'.$orderPromp->value];
            } else {
                //打折
                $final = round($totalPrice * (100 - $orderPromp->value) / 100, 2);
                return ['prom_id' => $orderPromp->id, 'money' => $final, 'name' => '购物满'.$orderPromp->base.'打'.$orderPromp->value.'折'];
            }
        }
    }

    /**
     * 用户等级优惠
     * @param [mixed] $user  [用户对象]
     * @param [float] $total [订单总金额]
     */
    public function UserLevelPreference($user, $total)
    {
        if (getSettingValueByKeyCache('user_level_switch') == '不开启') {
            return 0;
        }
        $user_level = UserLevel::where('id',$user->user_level)->first();
        if (!empty($user_level) && $user_level->discount < 100) {
            return round($total * (100 - $user_level->discount) / 100, 2);
        }else{
            return 0;
        }
    }

    /**
     * 用户积分日志
     * @param [type] $amount  [积分余额]
     * @param [type] $change  [ 积分变动，正为增加，负为支出 ]
     * @param [type] $detail  [详情]
     * @param [type] $type    [0注册赠送，1推荐好友赠送， 2购物赠送, 3消耗 4管理员操作]
     * @param [type] $user_id [用户ID]
     */
    public function 
    addCreditLog($amount, $change, $detail, $type, $user_id)
    {
        if (empty($change)) {
            return;
        }
        
        CreditLog::create([
            'amount' => $amount,
            'change' => $change,
            'detail' => $detail,
            'type' => $type,
            'user_id' => $user_id,
        ]);  
    }

    /**
     * 用户余额日志
     * @param [type] $amount  [余额余额]
     * @param [type] $change  [ 余额变动，正为增加，负为支出 ]
     * @param [type] $detail  [详情]
     * @param [type] $type    [0注册赠送，1推荐好友赠送， 2购物赠送, 3消耗]
     * @param [type] $user_id [用户ID]
     */
    public function addMoneyLog($amount, $change, $detail, $type, $user_id)
    {
        if (empty($change)) {
            return;
        }
        MoneyLog::create([
            'amount' => $amount,
            'change' => $change,
            'detail' => $detail,
            'type' => $type,
            'user_id' => $user_id,
        ]);  
    }

    /**
     * 添加分佣记录
     * @param [type] $order            [订单信息]
     * @param [type] $get_money_id     [分佣用户ID]
     * @param [type] $distribute_level [推荐用户等级]
     * @param [type] $given_money      [分佣金额]
     */
    public function addDistributionLog($order, $get_money_id, $distribute_level, $given_money)
    {
        DistributionLog::create([
            'order_user_id' => $order->user_id,
            'user_id' => $get_money_id,
            'commission' => $given_money,
            'order_money' => $order->price,
            'user_dis_level' => $distribute_level,
            'status' => '已发放',
            'order_id' => $order->id
        ]);
    }

    /**
     * 售后日志
     * @param [type] $name            [description]
     * @param [type] $des             [description]
     * @param [type] $order_refund_id [description]
     */
    public function addRefundLog($name, $des, $order_refund_id)
    {
        RefundLog::create([
            'order_refund_id' => $order_refund_id,
            'name' => $name,
            'des' => $des,
            'time' => \Carbon\Carbon::now()
        ]);  
    }
    /**
     * 添加订单操作日志
     * @param [type] $order_status    [订单状态]
     * @param [type] $shipping_status [物流状态]
     * @param [type] $pay_status      [支付状态]
     * @param [type] $action          [操作]
     * @param [type] $status_desc     [描述]
     * @param [type] $user            [操作用户]
     * @param [type] $order_id        [订单ID]
     */
    public function addOrderLog($order_status, $shipping_status, $pay_status, $action, $status_desc, $user, $order_id)
    {
        OrderAction::create([
            'order_status' => $order_status,
            'shipping_status' => $shipping_status,
            'pay_status' => $pay_status,
            'action' => $action,
            'status_desc' => $status_desc,
            'user' => $user,
            'order_id' => $order_id,
        ]);
    }
    
    /**
     * 计算积分减免金额
     * @param [mixed] $user       [用户对象]
     * @param [float] $totalprice [订单总金额]
     * @param [integer] $credits    [积分数目]
     */
    public function CreditPreference($user, $totalprice, $credits)
    {
        $credits = $user->credits > $credits ? $credits : $user->credits;
        //积分现金兑换比例
        $creditRate = getSettingValueByKeyCache('credits_rate');
        //积分最多可抵用金额比例
        $maxTotalRate = getSettingValueByKeyCache('credits_max');
        //最多抵扣金额
        $maxCancel = round($totalprice * $maxTotalRate / 100);

        $credits = ($credits > $maxCancel * $creditRate) ? $maxCancel * $creditRate : $credits;
        return ['credits' => $credits, 'creditPreference' => round($credits / $creditRate, 2)];
    }

    /**
     * 微信授权登录,根据微信用户的授权信息，创建或更新用户信息
     * @param [mixed] $socialUser [微信用户对象]
     */
    public function CreateUserFromWechatOauth($socialUser)
    {
        $user = null;
        $unionid = null;
        //用户是否公众平台用户
        if (array_key_exists('unionid', $socialUser)) {
            $unionid = $socialUser['unionid'];
            $user = User::where('unionid', $socialUser['unionid'])->first(); 
        }
        //不是，则是否是微信用户
        if (empty($user)) {
            $user = User::where('openid', $socialUser['openid'])->first();
        }
        
        if (is_null($user)) {
            $first_level = UserLevel::orderBy('amount', 'asc')->first();
            $user_level  = empty($first_level) ? 0 : $first_level->id;

            //是否自动成为分销用户
            $is_distribute = 0;
            if (getSettingValueByKeyCache('distribution_condition') == '注册用户' && getSettingValueByKeyCache('distribution') == '是') {
                $is_distribute = 1;
            }
            // 新建用户
            $user = User::create([
                'openid' => $socialUser['openid'],
                'unionid' => $unionid,
                'name' => $socialUser['nickname'],
                'nickname' => $socialUser['nickname'],
                'head_image' => $socialUser['headimgurl'],
                'sex' => empty($socialUser['sex']) ? '男' : $socialUser['sex'],
                'province' => $socialUser['province'],
                'city' => $socialUser['city'],
                'user_level' => $user_level,
                'oauth' => '微信',
                'is_distribute' => $is_distribute
            ]);
            //新注册用户的好处发放
            
        }else{
            if (array_key_exists('unionid', $socialUser) && empty($user->unionid)) {
                $user->update([
                    'nickname' => $socialUser['nickname'],
                    'head_image' => $socialUser['headimgurl'],
                    'sex' => empty($socialUser['sex']) ? '男' : $socialUser['sex'],
                    'province' => $socialUser['province'],
                    'city' => $socialUser['city'],
                    'unionid' => $unionid,
                ]);
            } else {
                $user->update([
                    'nickname' => $socialUser['nickname'],
                    'head_image' => $socialUser['headimgurl'],
                    'sex' => empty($socialUser['sex']) ? '男' : $socialUser['sex'],
                    'province' => $socialUser['province'],
                    'city' => $socialUser['city']
                ]);
            }
            
            
        }
        return $user;
    }


    /**
     * 支付成功后，处理商品订单信息
     * @param  [mixed] $order [订单信息]
     * @return [type]        [description]
     */
    public function processOrder($order, $pay_platform, $pay_no){
        //修改订单状态
        $order->update(['order_pay' => '已支付', 'pay_time' => Carbon::now(), 'pay_platform' => $pay_platform, 'pay_no' => $pay_no]);

        //分发给用户服务
        $this->attachServicesForUserFromOrder($order);

        //发送提醒
        event(new OrderPay($order));

        //支付成功的用户
        $user = getUserById($order->user_id);

        //该订单的item
        $items = $order->items()->first();

        //增加商品销量
        $product = getProductById($items->product_id);
        ++$product->sales_count;
        $product->save();

        //给用户送积分
        $this->attachCreditsFromUser($order->price,$user);

        //发给商户提醒
        sendNotice(admin($user->account)->id,'用户'.a_link($user->nickname,'/zcjy/users/'.$user->id).'在您的店铺下的订单编号为'.tag($order->snumber).a_link('[点击查看详情]'.tag('支付成功','green'),'/zcjy/orders/'.$order->id).',请注意查看');

        //通知用户
        sendNotice($user->id,'您的订单 ['.$items->name.'] 已支付成功请在个人中心查看服务',false);

        //填写支付记录
        
        //购物券
        CouponUser::where('order_id', $order->id)->update(['status' => '已使用']);
    }

    //支付成功给用户送积分
    public function attachCreditsFromUser($order_price,$user){
        #送的比例
        $consume_credits = empty(getSettingValueByKey('consume_credits',null,$user->account)) ? 0 : getSettingValueByKey('consume_credits',null,$user->account);
        #订单的积分
        $order_credits = intval($order_price * $consume_credits / 100);
        #更新后的积分
        $updated_credits = intval($user->credits) +  $order_credits ;
        $user->update(['credits'=> + $updated_credits]);

        #添加积分记录
        $this->addCreditLog($user->credits, $order_credits, '购买产品,赠送积分', 2,  $user->id);

        #通知用户
        sendNotice($user->id,'您此次购买了['.$order_price.']的产品,赠送给您'.$order_credits.'积分,当前积分为'.$updated_credits,false);
    }

    /**
     * 从订单中取出服务分发给用户
     * @param  [type] $order [description]
     * @return [type]        [description]
     */
    public function attachServicesForUserFromOrder($order){
        #支付过该订单的用户
        $user = getUserById($order->user_id);
        if(!empty($user)){
            #订单中附加的商品
            $item = $order->items()->first();
            #具体的商品
            $product = getProductById($item->product_id);
            if(!empty($product)){
                #该商品附带的服务
                $services =  $product->services()->get();
                #循环取出来给用户
                foreach ($services as $k => $v) {
                
                    $this->givenUserServices($user,$v,'product');
                     
                }
            }
        }
    }

   /**
    * [给用户直接分发服务]
    * @param  [type] $user    [description]
    * @param  [type] $service [description]
    * @param  [type] $type    [description]
    * @return [type]          [description]
    */
    public function givenUserServices($user,$service,$type=null){
             $service_num = 1;
             if($type == 'product'){
                $service_num = $service->pivot->num;
             }
             #如果服务的类型是指定的起始时间
             if($service->time_type == 0){
                #检测服务是否过期 
                $guoqi = Carbon::parse($service->time_end)->lt(Carbon::now());
                $status = $guoqi ? '已过期' : '待使用';
                $user->services()->attach($service->id,['num'=> $service_num ,'time_begin'=>$service->time_begin,'time_end'=>$service->time_end,'status'=>$status]);
                #给用户提示附送的服务及来源
             }
             else{
                $user->services()->attach($service->id,['num'=> $service_num ,'time_begin'=>Carbon::now(),'time_end'=>Carbon::now()->addDays($service->expire_days)]);
                #给用户提示附送的服务及来源
             }
    }

    /**
     * 取消订单操作
     * @param  [type] $orderCancel [order对象]
     * @return [type]              [description]
     */
    public function cancelOrderOperation($orderCancel)
    {
        if ($orderCancel->auth == 0) {
            //待审核不处理
            return;
        }

        if ($orderCancel->auth == 1) {
            //通过审核
            $order = $this->orderRepository->findWithoutFail($orderCancel->order_id);
            if ($order->order_pay == '未支付') {
                return;
            }
            if ($orderCancel->refound == 0) {
                //资金原路返回
                //返还现金
                $payment = Factory::payment(Config::get('wechat.payment.default'));
                // 参数分别为：商户订单号、商户退款单号、订单金额、退款金额、其他参数
                $result = $payment->refund->byOutTradeNumber($order->snumber, $order->snumber.'refund', $order->price, $order->price, [
                    'refund_desc' => '订单取消退款',
                ]);
                //返还积分
                $user = User::find($order->user_id);
                $user->credits = $user->credits + $order->credits;
                $this->addCreditLog($user->credits, $order->credits, '订单取消，退还积分', 0, $order->user_id);
                
                //返还余额
                $user->user_money = $user->user_money + $order->user_money_pay;
                $user->save();
                $this->addMoneyLog($user->user_money, $order->user_money_pay, '订单取消，退还余额', 0, $order->user_id);

                //返还优惠券
                CouponUser::where('order_id', $order->id)->update(['status' => '未使用']);
            } else {
                //资金返回到余额
                //返还积分
                $user = User::find($order->user_id);
                $user->credits = $user->credits + $order->credits;
                $this->addCreditLog($user->credits, $order->credits, '订单取消，退还积分', 0, $order->user_id);
                
                //返还余额
                $user->user_money = $user->user_money + $order->user_money_pay + $order->price;
                $user->save();
                $this->addMoneyLog($user->user_money - $order->price, $order->user_money_pay, '订单取消，退还余额', 0, $order->user_id);
                $this->addMoneyLog($user->user_money, $order->price, '订单取消，将用户支付的现金退还到余额', 0, $order->user_id);

                //返还优惠券
                CouponUser::where('order_id', $order->id)->update(['status' => '未使用']);
            }
        }

        if ($orderCancel->auth == 2) {
            //审核不通过
            $order->status = '未确认';
            $order->save();
        }
        
    }

    /**
     * 给用户发放优惠券
     * @param  [mixed] $user   [用户对象]
     * @param  [mixed] $coupon [优惠券对象]
     * @param  [integer] $count  [发放数量]
     * @param  string $reason [发送理由]
     * @return [type]         [description]
     */
    public function issueCoupon($user, $coupon, $count, $reason='系统发放',$shop_id=null)
    {
        // 拥有该优惠券的数量受限
        if ($coupon->max_count) {
            $coupon_issue_count = CouponUser::where('user_id', $user->id)->where('coupon_id', $coupon->id)->count();
            if ($coupon_issue_count >= $coupon->max_count) {
                return;
            }
        }

        $time_begin = null;
        $time_end = null;
        if ($coupon->time_type == 0) {
            //固定时间有效期
            $time_begin = $coupon->time_begin;
            $time_end = $coupon->time_end;
        }else{
            //领券开始计算
            $time_begin = Carbon::today();
            $time_end = Carbon::today()->addDays($coupon->expire_days);
        }
        if(empty($shop_id)){
            $shop_id = now_shop_id();
        }
        // 发放
        for ($i=0; $i < $count; $i++) { 
            CouponUser::create([
                'from_way' => $reason,
                'time_begin' => $time_begin,
                'time_end' => $time_end,
                'status' => 0,
                'user_id' => $user->id,
                'coupon_id' => $coupon->id,
                'shop_id' => $shop_id
            ]);
        }
    }

    /**
     * [processGivenCoupon 给用户发放优惠券]
     * @param  [type] $users          [$user collection]
     * @param  [type] $couponIdsArray [coupon ids array]
     * @param  [type] $count          [发放数量]
     * @return [type]                 [description]
     */
    public function processGivenCoupon($users, $couponIdsArray, $count, $reason = '系统发放')
    {
        if (!is_array($couponIdsArray)) {
            return;
        }
        foreach ($users as $user) {
            foreach ($couponIdsArray as $key => $id) {
                $coupon = $this->couponRepository->findWithoutFail($id);
                if (empty($coupon)) {
                    continue;
                }
                $this->issueCoupon($user, $coupon, $count, $reason);
            }
        }
    }

    /**
     * 根据product_id和spec_price_id查找商品信息
     * @param  [type]  $idArray  [description]
     * @param  [type]  $products [description]
     * @return boolean           [description]
     */
    private function isInProducts($idArray, $products){
        foreach ($products as $product) {
            if ($idArray[0] == $product->id && $idArray[1] == $product->pivot->spec_price_id) {
                return $product;
            }
        }
        return null;
    }


    //发送短信验证码
    public function sendVerifyCode($mobile)
    {

        $config = [
            // HTTP 请求的超时时间（秒）
            'timeout' => 5.0,

            // 默认发送配置
            'default' => [
                // 网关调用策略，默认：顺序调用
                'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

                // 默认可用的发送网关
                'gateways' => [
                    'aliyun',
                ],
            ],
            // 可用的网关配置
            'gateways' => [
                'errorlog' => [
                    'file' => '/tmp/easy-sms.log',
                ],
                'aliyun' => [
                    'access_key_id' => Config::get('SMS_ID'),
                    'access_key_secret' => Config::get('SMS_KEY'),
                    'sign_name' => Config::get('SMS_SIGN'),
                ]
            ],
        ];

        $easySms = new EasySms($config);

        $num = rand(1000, 9999); 

        $easySms->send($mobile, [
            'content'  => '验证码'.$num.'，您正在注册成为新用户，感谢您的支持！',
            'template' => Config::get('SMS_TEMPLATE_VERIFY'),
            'data' => [
                'code' => $num
            ],
        ]);
        return $num;
    }

    /**
     * 计算购物车中商品的真实价格
     * @return [type] [description]
     */
    public function processShoppingCartItems($items){
        //$items = ShoppingCart::all();
        //如果是带规格的就要加上规格
        foreach ($items as $item) {
            $tmp = explode('_', $item['id']);
            $product = $this->productRepository->findWithoutFail($tmp[0]);
            //if ($tmp[1] < 1) {
                //不带规格
                $item['type'] = 0;
                $item['product'] = $product;
                $item['realPrice'] = $this->productRepository->getSalesPrice($product, false);
            // } else {
            //     $specPrice = $this->specProductPriceRepository->findWithoutFail($tmp[1]);
            //     $item['type'] = 1;
            //     $item['product'] = $product;
            //     $item['spec'] = $specPrice;
            //     $item['realPrice'] = $this->specProductPriceRepository->getSalesPrice($specPrice, false);
            // }
        }
        return $items;
    }

    /**
     * 商品最大可买数量
     * @param  [type] $product [description]
     * @param  [type] $qty     [description]
     * @param  [type] $spec_id [description]
     * @return [type]          [description]
     */
    public function maxCanBuy($product, $qty, $spec_id = null)
    {
        if ($product->prom_type == 1) {
            //秒杀
            $flashSale = $this->flashSaleRepository->findWithoutFail($product->prom_id);
            if (!empty($flashSale) && $flashSale->status == '进行中') {
                if ($qty > $flashSale->buy_limit) {
                    $qty = $flashSale->buy_limit;
                }
            }
        }else{
            //普通购买，检查库存
            //if (empty($spec_id)) {
                if ($product->inventory != -1) {
                    $qty = $qty > $product->inventory ? $product->inventory : $qty;
                }
            // }else{
            //     $specPrice = $this->specProductPriceRepository->findWithoutFail($spec_id);
            //     if ($specPrice->inventory != -1) {
            //         if (empty($specPrice)) {
            //             $qty = 0;
            //         } else {
            //             $qty = $qty > $specPrice->inventory ? $specPrice->inventory : $qty;
            //         }
            //     }
            // }
        }
        return $qty;
    }

    /**
     * [图片上传]
     * @param  [type] $file     [description]
     * @param  string $api_type [description]
     * @return [type]           [description]
     */
    public function uploadImages($file,$api_type='web',$user=null){
        $allowed_extensions = ["png", "jpg", "gif","jpeg"];
       
        if(!empty($file)) {
            if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
                return zcjy_callback_data('图片格式不正确',1,$api_type);
            }
        }

        #图片文件夹
        $destinationPath = empty($user) ? "uploads/admin/" : "uploads/user/";

        if (!file_exists($destinationPath)){
            mkdir($destinationPath,0777,true);
        }
       
        $extension = $file->getClientOriginalExtension();
        $fileName = str_random(10).'.'.$extension;
        $file->move($destinationPath, $fileName);

        $image_path=public_path().'/'.$destinationPath.$fileName;
        
        $img = Image::make($image_path);
        $img->resize(640, 640);
        $img->save($image_path,70);

        $host='http://'.$_SERVER["HTTP_HOST"];

        if(env('online_version') == 'https'){
             $host='https://'.$_SERVER["HTTP_HOST"];
        }

        #图片路径
        $path=$host.'/'.$destinationPath.$fileName;

        return zcjy_callback_data([
                'src'=>$path,
                'current_time' => date('Y-m-d H:i:s')
            ],0,$api_type);
    }

    public function createQrCodes($parameter,$size=45){
        $path='/qrcodes/'.str_random(10).'.png';
        $prefix = http().domain();
        if(!file_exists(public_path($path))){
            \QrCode::format('png')->size($size)->generate($parameter,public_path($path));
        }
        return  $prefix.$path;
    }

    /**
     * [创建套餐购买记录]
     * @param  [type] $package_price_id [description]
     * @return [type]             [description]
     */
    public function createPackageLog($package_price_id,$admin_id,$type='购买',$price=null){
            //$package = $this->chargePackageRepository->findWithoutFail($package_id);
            $package_price =$this->chargePackagesPriceRepository->findWithoutFail($package_price_id);

            if(empty($package_price)){
                return null;
            }

            $package = $this->chargePackageRepository->findWithoutFail($package_price->package_id);

            if(empty($package)){
                return null;
            }

            #商户
            $shanghu = admin($admin_id);
          
            if(empty($shanghu)){
                return null;
            }

            #一级分佣人
            $shanghu_one = admin_parent($shanghu,'代理商');

            #二级分佣人
            $shanghu_two = admin_parent($shanghu_one,'代理商');
           

            #自动删除之前的未支付的套餐购买记录
            $this->packageLogRepository->model()::where('admin_id',$admin_id)->where('status','未支付')->delete();

            #生成记录
            $package_log = $this->packageLogRepository->create([
                'package_name'=>$package->name,
                'price'=> $package_price->price,
                'pay_price' => $price,
                'admin_id'=>$admin_id,
                'type'=>$type,
                'bonus_one'=>$package_price->bonus_one,
                'bonus_two'=>$package_price->bonus_two,
                'distribution_one'=>$shanghu_one->nickname,
                'distribution_two'=>empty($shanghu_two) ? '无' : $shanghu_two->nickname,
                'status' => '未支付',
                'years' => $package_price->years
            ]);

            $package_re_name = $package->name.'['.$package_price->years.'年]';

            #给商户提示站内信
            sendNotice($admin_id,'您当前下单'.a_link($package_re_name.'[查看详情]',route('package.detail',$package->id)).'成功,当前状态'.tag('未支付').',请及时完成支付');

            return $package_log;
    }




    /**
     * [处理套餐购买根据id]
     * @param  [type] $package_id [description]
     * @return [type]             [description]
     */
    public function processPackageById($package_id){
                $package = $this->packageLogRepository->findWithoutFail($package_id);
                $package->update(['status'=>'已完成']);

                #升级会员
                $this->adminPackageRepository->generateAdminPackage($package->admin_id,$package_id,$package->type);

                $admin = admin($package->admin_id);

                $admin_package_endtime = optional($admin->package()->first())->package_endtime;

                $package_name = $package->package_name.'['.$package->years.'年]';
                #给商户提示站内信
                sendNotice($package->admin_id,'您下单的'.tag($package_name).tag('已'.$package->type.'成功','orange').',剩余有效期为'.tag(count_time_days($admin_package_endtime)).'天');
                
                #一级分佣人
                $shanghu_one = admin($package->distribution_one,'nickname');
                #二级分佣人
                $shanghu_two = admin($package->distribution_two,'nickname');
                #给予一级分佣人分佣
                $shanghu_one->update(['use_money'=>$shanghu_one->use_money+$package->bonus_one]);

                #给一级分佣代理商提示站内信
                sendNotice($shanghu_one->id,'您线下的商户'.tag($admin->nickname).tag($package->type,'orange').'套餐'.tag($package_name).'成功,您已获取一级代理商的佣金'.tag($package->bonus_one).',当前账户余额为'.tag($shanghu_one->use_money));
                if(!empty($shanghu_two)){
                    #给予二级分佣人分佣
                    $shanghu_two->update(['use_money'=>$shanghu_two->use_money+$package->bonus_two]);
                    #给二级分佣代理商提示站内信
                    sendNotice($shanghu_two->id,'您线下的商户'.tag($admin->nickname).tag($package->type,'orange').'套餐'.tag($package_name).'成功,您已获取二级代理商的佣金'.tag($package->bonus_two).',当前账户余额为'.tag($shanghu_two->use_money));
                }

                 #给总部管理员提示站内信
                 sendGroupNotice('商户'.tag($admin->nickname).'下单的'.tag($package_name).tag('已'.$package->type.'成功','orange').',剩余有效期为'.tag(count_time_days($admin_package_endtime)).'天,对应代理商已获得对应的分佣金额');
                
    }
   


}
