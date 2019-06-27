<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;

use EasyWeChat\Factory;
use App\Models\Order;
use Config;
use Log;

class PayController extends Controller
{

	private $orderRepository;
    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepository = $orderRepo;
    }

    /**
     * 小程序用户发起微信支付
     *
     * @SWG\Get(path="/api/pay_weixin",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序用户发起微信支付",
     *   description="小程序用户发起微信支付,需要token信息",
     *   operationId="miniWechatPayUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),    
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回banner图链接列表",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期",
     *     )
     * )
     */
    public function miniWechatPay(Request $request)
    {
        $order_id = $request->input('order_id');

    	$order = $this->orderRepository->findWithoutFail($order_id);
        
    	if (empty($order)) {
    		return api_result_data_tem('订单信息不存在',1);
    	}

        $out_trade_no = $order->snumber.'_'.time();
        $order->out_trade_no = $out_trade_no;
        $order->save();

        $body = '支付订单'.$order->snumber.'费用';

        $user =auth()->user();

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

        // Log::info('version');
        // Log::info(Config::get('version.state'));

        if(Config::get('version.state')=='local'){
  
            app('commonRepo')->processOrder($order, '微信支付', $order->snumber);

            return api_result_data_tem('支付成功');
        }
        else{

        $payment = Factory::payment(Config::get('wechat.payment.xiaochengxu'));

        $result = $payment->order->unify($attributes);

        if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS'){
            $prepayId = $result['prepay_id'];
            $json = $payment->jssdk->bridgeConfig($prepayId);

            return ['status_code' => 0, 'message' => $json];

        }
        else{
            return ['status_code' => 1, 'message' => $result];
        }
      }
    }
}
