<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Repositories\ItemRepository;
use App\Repositories\OrderRefundRepository;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

use App\Models\Order;
use App\Models\OrderRefund;
use App\Models\RefundLog;
use App\Models\TeamSale;

class OrderController extends Controller
{

	/** @var  OrderRepository */
    private $orderRepository;
    private $itemRepository;
    private $orderRefundRepository;

    public function __construct(OrderRepository $orderRepo, ItemRepository $itemRepo, OrderRefundRepository $orderRefundRepo)
    {
        $this->orderRepository = $orderRepo;
        $this->itemRepository = $itemRepo;
        $this->orderRefundRepository = $orderRefundRepo;
    }

    public function index(Request $request, $type = 1)
    {
    	$user = auth('web')->user();

    	$orders = $this->orderRepository->ordersOfType($user, $type, 0, 18);

    	return view(frontView('order.index'), compact('orders', 'type'));
    }

    /**
     * 加载订单接口
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function orders(Request $request)
    {
        $user = auth('web')->user();

        $skip = 0;
        $take = 18;
        $type = 1;
        $inputs = $request->all();
        if (array_key_exists('skip', $inputs)) {
            $skip = intval($inputs['skip']);
        }
        if (array_key_exists('take', $inputs)) {
            $take = intval($inputs['take']);
        }
        if (array_key_exists('type', $inputs)) {
            $type = intval($inputs['type']);
        }

        $orders = $this->orderRepository->ordersOfType($user, $type, $skip, $take);
        return ['status_code' => 0, 'data' => $orders];
    }

    public function detail(Request $request, $id)
    {

        $order = $this->orderRepository->findWithoutFail($id);
        if (empty($order)) {
            return redirect('/orders');
        }
        $user = auth('web')->user();
        //防止访问他人订单
        if ($user->id != $order->user_id) {
            return redirect('/orders');
        }

        $show_pay = false;
        if ($request->has('show_pay')) {
            $show_pay = true;
        }

        $cancel_order = false;
        if ($request->has('cancel_order')) {
            $cancel_order = true;
        }
        
        $cancelStatus = $order->cancels;
        $teamSale = null;
        if ($order->prom_type == 5) {
            $teamSale = TeamSale::where('id', $order->prom_id)->first();
        }
        return view(frontView('order.detail'), compact('order', 'show_pay', 'cancel_order', 'cancelStatus', 'teamSale'));
    }


    public function cancel(Request $request, $id)
    {
        return $this->orderRepository->cancelOrder($id, $request->input('reason'), auth('web')->user()->nickname);
    }

    public function confirm(Request $request, $id)
    {
        return $this->orderRepository->confirmOrder($id, auth('web')->user()->nickname);
    }

    //售后列表
    public function refundList()
    {
        $orderRefunds = OrderRefund::all();
        return view(frontView('order.refundList'), compact('orderRefunds'));
    }

    public function refund($item_id)
    {
        $item = $this->itemRepository->findWithoutFail($item_id);
        if (empty($item)) {
            return redirect()->back();
        }
        $order = $this->orderRepository->findWithoutFail($item->order_id);
        if (empty($order)) {
            return redirect()->back();
        }
        $user = auth('web')->user();
        if ($user->id != $order->user_id) {
            return redirect()->back();
        }
        $product = $item->product;

        return view(frontView('order.refund'), compact('item', 'order', 'product'));
    }

    public function postRefund(Request $request, $item_id)
    {

        $item = $this->itemRepository->findWithoutFail($item_id);
        if (empty($item)) {
            return redirect()->back();
        }
        $user = auth('web')->user();
        $input = $request->all();
        $input['user_id'] = $user->id;
        $input['order_id'] = $item->order_id;
        $input['item_id'] = $item_id;

        $order = $item->order;
        if (empty($order)) {
            return redirect()->back();
        }
        //计算退还比例
        $return_rate = ($item->price * $input['count'])/$order->origin_price;
        if ($return_rate < 0) {
            $return_rate = 0;
        }
        if ($return_rate > 1) {
            $return_rate = 1;
        }
        //计算需退还的金额
        $refund_money = round($return_rate * $order->price , 2);
        //计算需退还的余额
        $refund_deposit = round($return_rate * $order->user_money_pay, 2);
        //计算需退还的积分
        $refund_credit = round($return_rate * $order->credits, 2);
        
        $input['refund_money'] = $refund_money;
        $input['refund_deposit'] = $refund_deposit;
        $input['refund_credit'] = $refund_credit;
        $refundDetail = OrderRefund::create($input);
        return redirect('/refundStatus'.'/'.$refundDetail->id);

    }

    public function refundStatus(Request $request, $id)
    {
        $orderRefund = $this->orderRefundRepository->findWithoutFail($id);
        $progress = $this->orderRefundRepository->getProgressArray($id);
        return view(frontView('order.refund_status'), compact('orderRefund', 'progress'));
    }

    public function canRefund(Request $request, $id)
    {
        $count = OrderRefund::where('item_id', $id)->count();
        if ($count) {
            return ['code' => 1, 'message' => '该商品已经申请过售后，无法再次申请'];
        } else {
            return ['code' => 0, 'message' => '可以申请售后'];
        }
        
    }

    public function refundChangeDelivery(Request $request, $id)
    {
        if (!$request->has('return_delivery_company') || !$request->has('return_delivery_no')) {
            return ['code' => 1, 'message' => '参数不正确'];
        }
        $orderRefund = $this->orderRefundRepository->findWithoutFail($id);
        if (empty($orderRefund)) {
            return ['code' => 1, 'message' => '信息不存在'];
        }
        $this->orderRefundRepository->update([
            'return_delivery_company' => $request->input('return_delivery_company'),
            'return_delivery_no' => $request->input('return_delivery_no'),
            'return_delivery_money' => $request->input('return_delivery_money'),
            'return_status' => 1
        ],$id);

        $user = auth('web')->user();
        RefundLog::create(['order_refund_id' =>$id, 'name' => $user->nickname ? $user->nickname : '用户:'.$user->id, 'des' => '用户寄回商品,快递公司:'.$request->input('return_delivery_company').'快递编号:'.$request->input('return_delivery_no'), 'time' => \Carbon\Carbon::now()]);

        return ['code' => 0, 'message' => '更新成功'];
    }

    public function refundCancel(Request $request, $id)
    {
        $orderRefund = $this->orderRefundRepository->findWithoutFail($id);
        if (empty($orderRefund)) {
            return ['code' => 1, 'message' => '信息不存在'];
        }
        if ($orderRefund->status == 0 || $orderRefund->status == 1) {
            $this->orderRefundRepository->update([
                'status' => -2
            ],$id);
            
            $user = auth('web')->user();
            RefundLog::create(['order_refund_id' =>$id, 'name' => $user->nickname ? $user->nickname : '用户:'.$user->id, 'des' => '用户取消申请售后服务', 'time' => \Carbon\Carbon::now()]);

            return ['code' => 0, 'message' => '已取消'];
        }else{
            return ['code' => 1, 'message' => '目前状态不支持取消操作'];
        }
    }

}
