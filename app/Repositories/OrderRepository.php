<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderCancel;
use App\Models\Setting;
use App\Models\TeamFound;
use App\Models\TeamFollow;
use App\Models\Product;
use App\Models\SpecProductPrice;
use App\Models\Item;
use App\Models\CouponUser;
use App\Models\StoreShop;
use InfyOm\Generator\Common\BaseRepository;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Events\OrderEvent;



class OrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'customer_id',
        'address_id',
        'price',
        'order_status',
        'order_delivery',
        'order_pay',
        'remark',
        'backup01'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Order::class;
    }

    /**
     * [createOrder description]
     * @param  [type] $user   [用户]
     * @param  [type] $items  [购物车商品]
     * @param  [type] $inputs [其他如优惠券、积分使用等信息]
     * @return [type]         [description]
     */
    public function createOrder($user, $items, $inputs)
    {
        $inputs['user_id'] = $user->id;
        $inputs['snumber'] = '';
        //发票信息
        if (array_key_exists('invoice', $inputs)) {
            $inputs['invoice'] = '要';
        }else{
            $inputs['invoice'] = '不要';
        }
        $order = Order::create($inputs);
     
        $result = $this->saveItems($order, $items);

        Log::info('result');
        Log::info($result);

        //总成本
        $totalCost = $result['totalCost'];
        //总价格
        $totalprice = $result['total'];
        
        //$totalprice = ShoppingCart::total();

        //优惠券优惠金额
        $couponPreference = 0;
        if (array_key_exists('coupon_id', $inputs)) {
            $finalResult = app('commonRepo')->CouponPreference($inputs['coupon_id'], $totalprice, $items);
            if ($finalResult['code'] == 0) {
                $couponPreference = $finalResult['message']['discount'];
                //冻结优惠券
                CouponUser::where('id', $inputs['coupon_id'])->update(['status' => 1]);
            }
        }

        //计算订单优惠
        $orderPreference = app('commonRepo')->orderPreference($totalprice);

        //会员优惠
        $userLevelPreference = app('commonRepo')->UserLevelPreference($user, $totalprice);

        //积分抵扣
        //$creditResult = app('commonRepo')->CreditPreference($user, $totalprice, $order->credits);

        // $creditPreference = $creditResult['creditPreference'];
        // $credits = $creditResult['credits'];
        // 
        $creditPreference = 0;
        $credits  = 0;
        $price = $totalprice - $couponPreference - $orderPreference['money'] -$userLevelPreference - $creditPreference + $order->freight;
        //使用余额支付
        $user_money_pay = 0;
        if (array_key_exists('user_money_pay', $inputs)) {
            $user_money_pay = $inputs['user_money_pay'];
            $user_money_pay = $user_money_pay > $user->user_money ? $user->user_money : $user_money_pay;
            $user_money_pay = $user_money_pay > $price ? $price : $user_money_pay;
        }

        if ($price - $user_money_pay > 0) {
            // 更新订单编号和总金额
            $this->update([
                'price' => $price - $user_money_pay,
                'origin_price' => $totalprice,
                'cost' => $totalCost,
                'preferential' => $orderPreference['money'], 
                'coupon_money' => $couponPreference, 
                'credits_money' => $creditPreference, 
                'user_level_money' => $userLevelPreference, 
                'credits' => $credits, 
                'snumber' => 6000000 + $order->id,
                'user_money_pay' => $user_money_pay
                ], $order->id);
        } else {
            // 不需要再支付
            $this->update([
                'price' => $price - $user_money_pay,
                'origin_price' => $totalprice,
                'cost' => $totalCost,
                'preferential' => $orderPreference['money'], 
                'coupon_money' => $couponPreference, 
                'credits_money' => $creditPreference, 
                'user_level_money' => $userLevelPreference, 
                'credits' => $credits, 
                'order_pay' => '已支付',
                'snumber' => 6000000 + $order->id,
                'user_money_pay' => $user_money_pay
                ], $order->id); 
        }

        //消耗用户余额
        $user->user_money = $user->user_money - $user_money_pay;
        //消耗用户积分
        $user->credits = $user->credits - $credits;
        $user->save();

        app('commonRepo')->addCreditLog($user->credits, -$credits, '用户使用积分消费，订单编号:'.$order->id, 3, $user->id);
        app('commonRepo')->addMoneyLog($user->user_money, -$user_money_pay, '用户使用余额消费，订单编号:'.$order->id, 2, $user->id);

        return $order;
    }

    public function cancelOrder($id, $reason='无', $operator='系统',$api=false)
    {
        try {
            $order = $this->findWithoutFail($id);
            if (empty($order)) {
                return $api 
                        ? api_result_data_tem('订单不存在',1)
                        : web_result_data_tem('订单不存在',1);
            }

            if (OrderCancel::where('order_id', $id)->count()) {
                return $api 
                        ? api_result_data_tem('订单已被取消过，无法再次取消',1)
                        : web_result_data_tem('订单已被取消过，无法再次取消',1);
            }

            if ($order->order_delivery != '未发货') {
                return $api 
                        ? api_result_data_tem('商家已发货，无法取消订单',1)
                        : web_result_data_tem('商家已发货，无法取消订单',1);
            }

            $order->update(['order_status' => '已取消']);

            //订单操作记录
            // app('commonRepo')->addOrderLog(
            //     $order->order_status, 
            //     $order->order_delivery, 
            //     $order->order_pay, 
            //     '取消订单', 
            //     $reason, 
            //     $operator, 
            //     $order->id);

            if ($order->order_pay == '已支付') {
                //已支付的订单进入退款流程
                OrderCancel::create([
                    'order_id' => $id,
                    'reason' => $reason,
                    'money' => $order->price,
                    'user_money' => $order->user_money_pay,
                    'credits' => $order->credits,
                    'auth' => 0,
                    'refound' => 0,
                ]);
            }else{
                //没有支付，但是使用了积分跟余额，则退还
                $user = $order->customer;
                if (!empty($user) && ($order->user_money_pay || $order->credits)) {
                    $user->user_money += $order->user_money_pay;
                    $user->credits += $order->credits;
                    $user->save();

                    if ($order->credits) {
                        app('commonRepo')->addCreditLog($user->credits, $order->credits, '订单取消，返还积分，订单编号:'.$order->id, 0, $user->id);
                    }
                    if ($order->user_money_pay) {
                        app('commonRepo')->addMoneyLog($user->user_money, $order->user_money_pay, '订单取消，返还余额，订单编号:'.$order->id, 0, $user->id);
                    }
                }
            }
            return $api 
            ? api_result_data_tem('订单取消成功')
            : web_result_data_tem('订单取消成功')
            ;
            //return ['code' => 0, 'message' => '订单取消成功'];
        } catch (Exception $e) {
            return  $api 
            ? api_result_data_tem('未知错误',1)
            : web_result_data_tem('未知错误',1);
           
        }
    }

    public function confirmOrder($id, $operator='系统')
    {
        try {
            $order = $this->findWithoutFail($id);
            if (empty($order)) {
                return ['code' => 1, 'message' => '订单不存在'];
            }

            if (OrderCancel::where('order_id', $id)->count()) {
                return ['code' => 1, 'message' => '订单已被取消'];
            }

            if ($order->order_delivery == '未发货') {
                return ['code' => 1, 'message' => '商家还未发货，无法确认订单'];
            }

            if ($order->order_delivery == '已收货') {
                return ['code' => 0, 'message' => '订单确认成功'];
            }

            $order->update(['order_delivery' => '已收货', 'confirm_time' => Carbon::now()]);

            //订单操作记录
            app('commonRepo')->addOrderLog(
                $order->order_status,
                $order->order_delivery, 
                $order->order_pay, 
                '确认订单', 
                '无', 
                $operator, 
                $order->id);

            //用户确认事件
            event(new OrderEvent($order));

            return ['code' => 0, 'message' => '订单确认成功'];
        } catch (Exception $e) {
            return ['code' => 1, 'message' => '未知错误'];
        }
    }

    public function deleteOrder($order)
    {
        //如果订单处于某种特定的状态，不应该能被删除
        //如果是团购，清除拼团信息
        if ($order->prom_type == 5) {
            TeamFound::where('order_id', $id)->delete();
            TeamFollow::where('order_id', $id)->delete();
        }
        //还原优惠券状态
        $order->coupons()->update(['order_id' => null, 'use_time' => null, 'status' => 0]);
        //删除订单商品
        Item::where('order_id', $id)->delete();
        //删除订单
        $this->delete($id);
    }

    //消减库存
    public function deduceInventory($order_id)
    {
        $items = Item::where('order_id', $order_id)->get();
        foreach ($items as $item) {
            if (empty($item->spec_key)) {
                //无规格商品
                $product = Product::where('id', $item->product_id)->first();
                if ($product && $product->inventory != -1 && !empty($product)) {
                    $product->inventory = $product->inventory - $item->count;
                    $product->save();
                }
            } else {
                $specProductPrice = SpecProductPrice::where('product_id', $item->product_id)->where('key', $item->spec_key)->first();
                if ($specProductPrice && $specProductPrice->inventory != -1 && !empty($specProductPrice)) {
                    $specProductPrice->inventory = $specProductPrice->inventory - $item->count;
                    $specProductPrice->save();
                }
            }
        }
    }

    //计算按商品提成金额
    public function productCommission($order_id)
    {
        $total = 0;
        $items = Item::where('order_id', $order_id)->get();
        foreach ($items as $key => $value) {
            $total += $value->product->commission;
        }
        return $total;
    }

    //重新计算订单价格
    public function reCaculateOrderPrice($order_id)
    {
        //重新计算订单价格
        $order = $this->findWithoutFail($order_id);
        if (!empty($order)) {
            $items = $order->items()->get();
            $origin_price = 0;
            foreach ($items as $key => $item) {
                $origin_price += $item->price * $item->count;
            }
            //计算运费(待定)

            //如果使用了优惠券，则计算优惠价格
            $coupon = $order->coupons()->first();
            if (is_null($coupon)) {
                $new_price = $origin_price - $order->preferential + $order->freight;
                $this->update(['origin_price' => $origin_price, 'price' => $new_price], $order->id);
            }else{
                $youhui = 0;
                if ($coupon->type == '满减') {
                    $youhui = $coupon->given;
                } else if ($coupon->type == '打折'){
                    $youhui = $origin_price * (100 - $coupon->discount) / 100;
                }
                // 将优惠券冻结
                $new_price = $origin_price - $youhui + $order->freight;
                $this->update(['origin_price' => $origin_price, 'price' => $new_price, 'preferential' => $youhui], $order->id);
            }
        }
    }

    /**
     * 飞蛾小票打印
     * @param  [type] $id [订单ID]
     * @return [type]     [description]
     */
    public function printOrder($id){
        $order = $this->findWithoutFail($id);
        $items = $order->items()->get();
        if (!empty($order)) {
            $orderInfo = '<CB>订单编号'.$order->snumber.'</CB><BR>';
            $orderInfo .= '联系人：'.$order->customer_name.'<BR>';
            $orderInfo .= '联系方式：'.$order->customer_phone.'<BR>';
            $orderInfo .= '送货地址：'.$order->customer_address.'<BR>';
            $orderInfo .= '订单金额：'.$order->price.'<BR>';
            $orderInfo .= '商品总价：'.$order->origin_price.'<BR>';
            if($order->preferential){ $orderInfo .= '订单减免：-'.$order->preferential.'<BR>';}
            if($order->coupon_money){ $orderInfo .= '优惠券减免：-'.$order->coupon_money.'<BR>';}
            if($order->credits_money){ $orderInfo .= '积分抵扣：-'.$order->credits_money.'<BR>';}
            if($order->user_level_money){ $orderInfo .= '会员折扣：-'.$order->user_level_money.'<BR>';}
            if($order->user_money_pay){ $orderInfo .= '余额支付：-'.$order->user_money_pay.'<BR>';}
            if($order->price_adjust){ $orderInfo .= '价格调整：-'.$order->price_adjust.'<BR>';}
            if($order->freight){ $orderInfo .= '运费：'.$order->freight.'<BR>';}
            $orderInfo .= '支付方式：'.$order->pay_type.'<BR>';
            $orderInfo .= '支付平台：'.$order->pay_platform.'<BR>';
            $orderInfo .= '支付状态：'.$order->order_pay.'<BR>';
            if($order->remark){ $orderInfo .= '客户留言：'.$order->remark.'<BR>';}
            if($order->backup01){ $orderInfo .= '订单备注：'.$order->backup01.'<BR>';}
            $orderInfo .= '商品列表：<BR>';
            $orderInfo .= '--------------------------------<BR>';
            $items->each(function ($item, $key) use (&$orderInfo) {
                $orderInfo .= $item->name.' '.$item->spec_keyname.'*'.$item->count.' 单价：'.$item->price.'<BR>';
            });
            $orderInfo .= '--------------------------------<BR>';
            return $this->wp_print($orderInfo, 1);
        }

        return '订单不存在';
    }
    /*
    define('USER', 'yyjz@foxmail.com');    //*用户填写*：飞鹅云后台注册账号
    define('UKEY', 'BDacddSLJsXnGb9h');    //*用户填写*: 飞鹅云注册账号后生成的UKEY
    //API URL
    define('IP','api.feieyun.cn');      //接口IP或域名
    define('PORT',80);                  //接口IP端口
    define('HOSTNAME','/Api/Open/');    //接口路径
    define('STIME', time());            //公共参数，请求时间
    define('SIG', sha1(USER.UKEY.STIME)); //公共参数，请求公钥
    */
    private function wp_print($orderInfo, $times){
        $time = time();
        $sig = sha1(getSettingValueByKeyCache('feie_user').getSettingValueByKeyCache('feie_ukey').$time);
        $content = array(
            'user'=>getSettingValueByKeyCache('feie_user'),
            'stime'=>$time,
            'sig'=>$sig,
            'apiname'=>'Open_printMsg',

            'sn'=>getSettingValueByKeyCache('feie_sn'),
            'content'=>$orderInfo,
            'times'=>$times//打印次数
        );

        $request = new GuzzleRequest('POST', '/Api/Open/');
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://api.feieyun.cn',
            // You can set any number of default request options.
            'timeout'  => 10.0,
        ]);
        $response = $client->send($request, ['form_params' => $content]);
        return $response->getBody();
    }

    /**
     * 自动确认超时订单
     * @return [type] [description]
     */
    public function autoConfirmOrder()
    {
        $autoConfirmDays = getSettingValueByKeyCache('auto_complete');
        $orders = Order::where('order_pay', '已支付')
        ->where('order_status', '<>' , '无效')
        ->where('order_status', '<>' , '已取消')
        ->where('order_delivery', '已发货')
        ->get();
        foreach ($orders as $order) {
            if ( !empty($order->sendtime) && Carbon::parse($order->sendtime)->addDays($autoConfirmDays)->lt(Carbon::now()) ) {
                $this->confirmOrder($order->id, '系统');
            }
        }
    }

    /**
     * 处理超时订单
     * @return [type] [description]
     */
    public function clearExpiredOrder()
    {
        $hours = getSettingValueByKeyCache('order_expire_time');
        if ($hours <= 0) {
            return;
        }
        $orders = Order::where('order_pay', '未支付')
        ->where('pay_type', '在线支付')
        ->where('order_status', '<>' , '无效')
        ->where('order_status', '<>' , '已取消')
        ->where('order_delivery', '未发货')
        ->get();
        foreach ($orders as $order) {
            if ( Carbon::parse($order->created_at)->addHours($hours)->lt(Carbon::now()) ) {
                $this->cancelOrder($order->id, '超时未支付，系统取消订单');
            }
        }
    }

    private function saveItems($order, $items){
        $totalCost = 0;
        $total = 0;
        foreach ($items as $item) {
    
            $item_id = $item['id'];
            $item_name = $item['name'];
            $item_qty = $item['qty'];
            $item_price = $item['price'];
            
            $tmp =  $item_id;

            $product = Product::where('id', $tmp)->first();
            if (empty($product)) {
                $this->delete($order->id);
                return ['code'=>1, 'message' => '对不起，商品'.$item_name.'已下架'];
            }
                Item::create([
                    'name' => $product->name,
                    'pic' => $product->image,
                    'price' => $item_price,
                    'cost' => $item_price,
                    'count' => $item_qty,
                    'unit' => '',
                    'order_id' => $order->id,
                    'product_id' => $product->id
                ]);
                // 计算订单总金额
                $totalCost += $product->cost * $item_qty;
                $total += $item_price * $item_qty;
                
        }
        return ['total' => $total, 'totalCost' => $totalCost];
    }

    /**
     * 获取订单接口
     * @param  [type]  $user [description]
     * @param  integer $type [description]
     * @param  integer $skip [description]
     * @param  integer $take [description]
     * @return [type]        [description]
     */
    public function ordersOfType($user, $type = 1, $skip = 0, $take = 18)
    {
        switch ($type) {
            case 1:
                // 全部
                $orders = $user->orders()->orderBy('created_at', 'desc')->with('items')->skip($skip)->take($take)->get();
                break;
            case 2:
                // 待付款
                $orders = $user->orders()->orderBy('created_at', 'desc')->where([
                    ['order_status', '<>', '无效'],
                    ['order_status', '<>', '已取消'],
                    ['order_pay', '=', '未支付']
                ])->with('items')->skip($skip)->take($take)->get();
                break;
            case 3:
                // 待发货
                $orders = $user->orders()->orderBy('created_at', 'desc')->where([
                    ['order_status', '<>', '无效'],
                    ['order_status', '<>', '已取消'],
                    ['order_pay', '=', '已支付'],
                    ['order_delivery', '=', '未发货']
                ])->with('items')->skip($skip)->take($take)->get();
                break;
            case 4:
                // 待确认
                $orders = $user->orders()->orderBy('created_at', 'desc')->where([
                    ['order_status', '<>', '无效'],
                    ['order_status', '<>', '已取消'],
                    ['order_pay', '=', '已支付'],
                    ['order_delivery', '=', '已发货']
                ])->with('items')->skip($skip)->take($take)->get();
                break;
            case 5:
                // 完成
                $orders = $user->orders()
                    ->orderBy('created_at', 'desc')
                    ->where('order_delivery', '已收货')
                    ->with('items')->skip($skip)->take($take)->get();
                break;
            default:
                # code...
                $orders = $user->orders()->orderBy('created_at', 'desc')->skip($skip)->take($take)->get();
                break;
        }

        $orders = $orders->each(function ($order, $key) {
            $order['status'] = $order->status;
            $items = $order->items;
            $count = 0;
            foreach ($items as $key => $item) {
                $count += $item['count'];
            }
            $order['count'] = $count;
        });

        return $orders;
    }
    /**
     * [统计用户单个店子的订单金额和成长值]
     * @param  [type] $user [description]
     * @param  [type] $shop [description]
     * @return [type]       [description]
     */
    public function countSinglePriceAndGrowth($user,$shop_id){
            $growth_order = 0;
            $price_order = 0;
            if(!empty(StoreShop::find($shop_id))){
                #这个店的成长值方式
                $count_type = empty(getSettingValueByKey('growth_type',null,$user->account,$shop_id));
                #订单金额 计算方式 是 1元 多少点 默认是一元一点
                $order_price_unit = empty(getSettingValueByKey('product_get_growth',null,$user->account,$shop_id)) ? 1 : getSettingValueByKey('product_get_growth',null,$user->account,$shop_id);
                $orders  = defaultSearchState($this->model());
                $orders  =  $count_type 
                        ? $orders 
                        : $orders 
                        ->whereBetween('created_at',[Carbon::now()->subYear(),Carbon::now()]);
                $user_orders_price = $orders
                    ->where('shop_id',$shop_id)
                    ->where('user_id',$user->id)
                    ->where([
                        ['order_status', '<>', '无效'],
                        ['order_status', '<>', '已取消'],
                        ['order_pay', '=', '已支付']
                    ])->get()->sum('price');
                $price_order = $user_orders_price;
                #用户在这个店的成长值
                $growth_order =  $user_orders_price * $order_price_unit;
            }
            return ['growth'=>$growth_order,'price'=>$price_order];
    }

    /**
     * [计算用户订单的金额和成长值]
     * @param  [type] $user [description]
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function countUserOrderPriceAndGrowth($user){
        $shops =  account(StoreShop::class,$user->account)->get();
        $growth_order = 0;
        $price_order = 0;
        if(count($shops)){
            #分店 分批统计订单成长值
            foreach ($shops as $key => $shop) {
                $growth_order += $this->countSinglePriceAndGrowth($user,$shop->id)['growth'];
                $price_order += $this->countSinglePriceAndGrowth($user,$shop->id)['price'];
            }
        }
        return ['growth'=>$growth_order,'price'=>$price_order];
    }

    /**
     * 查询物流
     * @param  [string]    $company    [物流公司名称]
     * @param  [string]    $number     [运单号]
     * @param  [integer]   $muti       [0单行还是1所有]
     * @param  [string]    $sort       [desc默认倒序]
     * @return [json]                  [返回数据集合]
     */
    public function getLogicInfo($company,$number,$muti=0,$sort='desc'){
        $client = new Client(['base_uri' => 'http://api.kuaidi100.com']);
        $response = $client->request('GET', '/api?id=9a814ddd2cc41ed8&com='.$company.'&nu='.$number.'&show=0&muti='.$muti.'&order='.$sort);
        $data=$response->getBody();
        return $data;
    }

}
