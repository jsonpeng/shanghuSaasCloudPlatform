<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

use EasyWeChat\Factory;
use App\Models\Order;

class PayController extends Controller
{

	private $orderRepository;
    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepository = $orderRepo;
    }

    public function payWechat(Request $request, $order_id)
    {
    	$order = $this->orderRepository->findWithoutFail($order_id);
    	if (empty($order)) {
    		return ['code' => 0, 'message' => '订单信息不存在'];
    	}

        $out_trade_no = $order->snumber.'_'.time();
        $order->out_trade_no = $out_trade_no;
        $order->save();

        $body = '支付订单'.$order->snumber.'费用';
        $user =auth('web')->user();

        $attributes = [
            'trade_type'       => 'JSAPI', // JSAPI，NATIVE，APP...
            'body'             => $body,
            'detail'           => '订单编号:'.$order->snumber,
            'out_trade_no'     => $out_trade_no,
            'total_fee'        => intval( $order->price * 100 ), // 单位：分
            'notify_url'       => $request->root().'/notify_wechcat_pay', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            'openid'           => $user->openid, // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            'attach'           => '支付订单',
        ];

        $payment = Factory::payment(Config::get('wechat.payment.default'));
        $result = $payment->order->unify($attributes);

        if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS'){
            $prepayId = $result['prepay_id'];
            $json = $payment->jssdk->bridgeConfig($prepayId);

            return ['code' => 0, 'message' => $json];

        }else{
            //$payment->payment->reverse($order_no);
        }
    }

    public function payWechatNotify(Request $request)
    {

        $payment = Factory::payment(Config::get('wechat.payment.default'));
        $response = $payment->handlePaidNotify(function($message, $fail){
            $order = Order::where('out_trade_no', $message['out_trade_no'])->first();
            if (empty($order)) { // 如果订单不存在
                return true; 
            }

            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($order->order_pay == '已支付') {
                // 已经支付成功了就不再更新了
                return true; 
            }

            ///////////// <- 建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////
            if ($message['return_code'] === 'SUCCESS') { // return_code 表示通信状态，不代表支付状态
                // 用户是否支付成功
                if (array_get($message, 'result_code') === 'SUCCESS') {
                    app('commonRepo')->processOrder($order, '微信支付', $message['transaction_id']);

                // 用户支付失败
                } elseif (array_get($message, 'result_code') === 'FAIL') {
                    
                }
            } else {
                return $fail('通信失败，请稍后再通知我');
            }

            return true; // 返回处理完成
        });

        return $response;
    }


    /**
    *PAYS API支付
    */
    public function paysApi(Request $request, $order_id)
    {
        // $user = auth('web')->user();
        // if ($user->member && Carbon::now()->lt(Carbon::parse($user->member_end_time))) {
        //     return ['code' => 1, 'message' => '您已经是会员了，无需再次购买'];
        // }

        // $product = Product::first();
        // $order = Order::create([
        //     'money' => $product->price,
        //     'pay_status' => '未支付',
        //     'platform' => '支付宝',
        //     'user_id' => $user->id,
        //     'pay_no' => time().'_'.random_int(1, 20000)
        // ]);

        $order = $this->orderRepository->findWithoutFail($order_id);
        if (empty($order)) {
            return ['code' => 0, 'message' => '订单信息不存在'];
        }

        $out_trade_no = $order->snumber.'_'.time();
        $order->out_trade_no = $out_trade_no;
        $order->save();

        $body = '支付订单'.$order->snumber.'费用';
        $user =auth('web')->user();

        $orderuid = $user->id;       //此处传入您网站用户的用户名，方便在paysapi后台查看是谁付的款，强烈建议加上。可忽略。

        //校验传入的表单，确保价格为正常价格（整数，1位小数，2位小数都可以），支付渠道只能是1或者2，orderuid长度不要超过33个中英文字。
        $istype = 2;
        if ($request->has('type') && $request->input('type') == 1) {
            $istype = 1;
        }

        //此处就在您服务器生成新订单，并把创建的订单号传入到下面的orderid中。
        $goodsname = $body;
        $orderid = $out_trade_no;    //每次有任何参数变化，订单号就变一个吧。
        $uid = Config::get('paysapi.PAYS_API_UID');//"此处填写PaysApi的uid";
        $token = Config::get('paysapi.PAYS_API_TOKEN');//"此处填写PaysApi的Token";
        $return_url = $request->root().'/paysapi_return';
        $notify_url = $request->root().'/paysapi_notify';
        $price = $order->price;
        
        $key = md5($goodsname. $istype . $notify_url . $orderid . $orderuid . $price . $return_url . $token . $uid);
        //经常遇到有研发问为啥key值返回错误，大多数原因：1.参数的排列顺序不对；2.上面的参数少传了，但是这里的key值又带进去计算了，导致服务端key算出来和你的不一样。

        $returndata['goodsname'] = $goodsname;
        $returndata['istype'] = $istype;
        $returndata['key'] = $key;
        $returndata['notify_url'] = $notify_url;
        $returndata['orderid'] = $orderid;
        $returndata['orderuid'] =$orderuid;
        $returndata['price'] = $price;
        $returndata['return_url'] = $return_url;
        $returndata['uid'] = $uid;
        return ['code' => 0, 'message' => $returndata];
    }

    /**
     * PAYS API返回
     * @Author   yangyujiazi
     * @DateTime 2018-03-16
     * @param    Request     $request [description]
     * @return   [type]               [description]
     */
    public function paysapiReturn(Request $request)
    {
        $inputs = $request->all();
        $orderid = $inputs["orderid"];
        $order = Order::where('out_trade_no', $orderid)->first();

        if (empty($order) || $order->pay_status == '未支付') { 
            return view(frontView('pay.pay_failure'));
        }else{
            return view(frontView('pay.pay_success'));
        }
    }

    /**
     * PAYS API 返回
     * @Author   yangyujiazi
     * @DateTime 2018-03-16
     * @param    Request     $request [description]
     * @return   [type]               [description]
     */
    public function paysapiNotify(Request $request)
    {
        $inputs = $request->all();
        $paysapi_id = $inputs["paysapi_id"];
        $orderid = $inputs["orderid"];
        $price = $inputs["price"];
        $realprice = $inputs["realprice"];
        $orderuid = $inputs["orderuid"];
        $key = $inputs["key"];

        //校验传入的参数是否格式正确，略

        $token = Config::get('paysapi.PAYS_API_TOKEN');
        
        $temps = md5($orderid . $orderuid . $paysapi_id . $price . $realprice . $token);

        if ($temps != $key){
            return $this->jsonError("key值不匹配");
        }else{
            $order = Order::where('out_trade_no', $orderid)->first();

            if (empty($order)) { // 如果订单不存在
                return $this->jsonError("订单不存在"); 
            }

            // 检查订单是否已经更新过支付状态
            if ($order->pay_status == '已支付') {
                return $this->jsonSuccess("成功"); 
            }
            app('commonRepo')->processOrder($order, '微信(PAYSAPI)', $paysapi_id);

        }

    }

    /**
     * PAYS API返回
     */
    //返回错误
    private function jsonError($message = '',$url=null) 
    {
        $return['msg'] = $message;
        $return['data'] = '';
        $return['code'] = -1;
        $return['url'] = $url;
        return json_encode($return);
    }

    /**
     * PAYS API返回
     */
    //返回正确
    private function jsonSuccess($message = '',$data = '',$url=null) 
    {
        $return['msg']  = $message;
        $return['data'] = $data;
        $return['code'] = 1;
        $return['url'] = $url;
        return json_encode($return);
    }
}
