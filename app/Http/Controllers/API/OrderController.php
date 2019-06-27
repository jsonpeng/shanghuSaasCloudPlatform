<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\OrderRepository;
use App\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

use EasyWeChat\Factory;
use App\Models\Order;

class OrderController extends Controller
{
    private $orderRepository;

    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepository = $orderRepo;
    }


    /**
     * 小程序获取用户的订单列表
     *
     * @SWG\Get(path="/api/orders",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序获取用户的订单列表",
     *   description="小程序获取用户的订单列表,需要token信息",
     *   operationId="ordersUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
    *   @SWG\Parameter(
     *     in="formData",
     *     name="shop_id",
     *     type="string",
     *     description="店铺id",
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
    public function orders(Request $request)
    {
        $type = 1;
        $user = auth()->user();
        $account = $user->account;
        $take = 18;
        
        if($request->has('type')){
            $type = $request->input('type');
        }
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }

        switch ($type) {
            case 1:
                // 全部
                $orders = $user->orders()->where('account',$account)->orderBy('created_at', 'desc')->with('items')->skip($skip)->take($take)->get();
                break;
            case 2:
                // 待付款
                $orders = $user->orders()->where('account',$account)->orderBy('created_at', 'desc')->where([
                    ['order_status', '<>', '无效'],
                    ['order_status', '<>', '已取消'],
                    ['order_pay', '=', '未支付']
                ])->with('items')->skip($skip)->take($take)->get();
                break;
            case 3:
                // 待发货
                $orders = $user->orders()->where('account',$account)->orderBy('created_at', 'desc')->where([
                    ['order_status', '<>', '无效'],
                    ['order_status', '<>', '已取消'],
                    ['order_pay', '=', '已支付'],
                    ['order_delivery', '=', '未发货']
                ])->with('items')->skip($skip)->take($take)->get();
                break;
            case 4:
                // 待确认
                $orders = $user->orders()->where('account',$account)->orderBy('created_at', 'desc')->where([
                    ['order_status', '<>', '无效'],
                    ['order_status', '<>', '已取消'],
                    ['order_pay', '=', '已支付'],
                    ['order_delivery', '=', '已发货']
                ])->with('items')->skip($skip)->take($take)->get();
                break;
            case 5:
                // 退换货
                $orders = $user->orders()
                    ->where('account',$account)
                    ->orderBy('created_at', 'desc')
                    ->where('order_status', '无效')
                    ->orWhere('order_status', '已取消')
                    ->orWhere(function ($query) {
                        $query->where('order_pay', '已支付')
                            ->where('order_delivery', '已收货');
                    })->with('items')->skip($skip)->take($take)->get();
                break;
            default:
                # code...
                $orders = $user->orders()->where('account',$account)->orderBy('created_at', 'desc')->skip($skip)->take($take)->get();
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
        return ['status_code' => 0, 'data' => $orders];
    }

    /**
     * 订单详情
     * @param  Request $request [description]
     * @param  [type]  $id      [订单编号]
     * @return [type]           [description]
     */
    public function detail(Request $request, $id)
    {
        $order = $this->orderRepository->findWithoutFail($id);
        $items = $order->items;
        return ['status_code' => 0, 'data' => ['order' => $order, 'items' => $items]];
    }

    /**
     * 保存订单
     * @param  Request $request [description]
     *  customer_name:
        customer_phone:
        customer_address:
        freight:
        address_id:
        coupon_id:
        credits:
        user_money_pay:
        prom_type:
        prom_id:
        remark:
     * @return [type]           [description]
     * 
     */
    /**
     * 小程序用户创建新的订单
     *
     * @SWG\Post(path="/api/order/create",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序用户创建新的订单",
     *   description="小程序用户创建新的订单,需要token信息",
     *   operationId="ordersCreateUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
    *   @SWG\Parameter(
     *     in="formData",
     *     name="shop_id",
     *     type="string",
     *     description="店铺id",
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
    public function create(Request $request)
    {
        try {
            //当前用户
            $user = auth()->user();

            //订单信息
            $inputs = $request->all();

            //附带account信息
            $inputs['account'] = $user->account;

            $items = json_decode($inputs['items'], true);

            $order = $this->orderRepository->createOrder($user, $items, $inputs);

            #通知管理员
            sendNotice(admin($user->account)->id,'用户'.a_link($user->nickname,'/zcjy/users/'.$user->id).'在您的店铺下单了一笔订单'.a_link('[点击查看详情]','/zcjy/orders/'.$order->id).',请注意查看');

            $items = optional($items);
            
            #通知用户
            sendNotice($user->id,'您的订单 ['.$items[0]['name'].'] 已创建成功请及时支付',false);


            return ['status_code'=>0, 'data' => $order->id];

        } catch (Exception $e) {

        }
    
    }

    /**
     * 取消订单
     * @param  Request $request [description]
     * @param  [int,string]     $id,$reason      [订单id,取消原因]
     * @return [type]           [description]
     */
    /**
     * 小程序用户取消订单
     *
     * @SWG\Get(path="/api/order/cancel",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序用户取消订单",
     *   description="小程序用户取消订单,需要token信息",
     *   operationId="ordersCancelUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
    *   @SWG\Parameter(
     *     in="formData",
     *     name="shop_id",
     *     type="string",
     *     description="店铺id",
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
    public function cancel(Request $request){
        $id = $request->input('id');
        $user = auth()->user();
        return $this->orderRepository->cancelOrder($id, $request->input('reason'), $user->nickname , true);
    }

    /**
     * 查询物流
     * @param  [string]    $company    [物流公司名称]
     * @param  [string]    $number     [运单号]
     * @param  [integer]   $muti       [0单行还是1所有]
     * @param  [string]    $sort       [desc默认倒序]
     * @return [json]                  [返回数据集合]
     */
    public function getLogicInfo(Request $request){
        $company=$request->input('company');
        $number=$request->input('number');
        $muti=empty($request->input('muti')) ? 0 : $request->input('muti');
        $sort=empty($request->input('sort')) ? 'desc' : $request->input('sort');
        $data=app('commonRepo')->orderRepo()->getLogicInfo($company,$number,$muti,$sort);
        return $data;
        //return ['status_code'=>0,'data'=> $data];
    }

}
