<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

use App\Models\Product;
use App\Repositories\OrderRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\User;
use App\Models\Item;
use App\Models\Order;
use App\Models\SpecProductPrice;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;


class OrderController extends AppBaseController
{
    /** @var  OrderRepository */
    private $orderRepository;
    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepository = $orderRepo;
    }

    /**
     * Display a listing of the Order.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        #清除空字符串
        $input = $request->all();

        #过滤空字符串
        $input = array_filter( $input, function($v, $k) {
            return $v != '';
        }, ARRAY_FILTER_USE_BOTH );

        #验证是否展开搜索栏
        $tools=$this->varifyTools($input,true);

        #带上account信息
        $input = attachAccoutInput($input);

        $orders = Order::orderBy('created_at', 'desc');
        
        $orders=$this->varifyOrderInput($orders,$input);
      
        $orders = $orders->paginate($this->defaultPage());

        return view('admin.orders.index')
            ->with('tools',$tools)
            ->with('orders', $orders)
            ->with('input',$input);
    }

    /**
     * Show the form for creating a new Order.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.orders.create');
    }

    /**
     * Store a newly created Order in storage.
     *
     * @param CreateOrderRequest $request
     *
     * @return Response
     */
    public function store(CreateOrderRequest $request)
    {
        $input = $request->all();

        $order = $this->orderRepository->create($input);

        Flash::success('Order saved successfully.');

        return redirect(route('orders.index'));
    }

    /**
     * Display the specified Order.
     *
     * @param  int $id++
     *
     * @return Response
     */
    public function show($id)
    {
        $order = $this->orderRepository->findWithoutFail($id);

        if (empty($order)) {
            Flash::error('Order not found');

            return redirect(route('orders.index'));
        }
        
        $items = $order->items()->get();
        //$actions=$order->actions()->orderBy('created_at','desc')->paginate($this->defaultPage());
        $kuaidi = Config::get('kuaidi');
        return view('admin.orders.show', compact('order', 'items','kuaidi'));
    }


    //批量订单导出
    public function reportOrderToMany(Request $request){
        $input = $request->all();
        $input = array_filter( $input, function($v, $k) {
            return $v != '';
        }, ARRAY_FILTER_USE_BOTH );
        $orders = Order::orderBy('created_at', 'desc');
        $orders=$this->varifyOrderInput($orders,$input);
        $order=$orders;
        $time='';
        if(array_key_exists('create_start',$input) || array_key_exists('create_end',$input)) {
            $start=Carbon::now()->format('Y-m-d');
            $end=Carbon::now()->format('Y-m-d');
            if(!empty($input['create_start'])){
                $start= $input['create_start'];
                $time=$time.'从'.$start.'起';
            }
            if(!empty($input['create_end'])){
                $end=$input['create_end'];
                $time=$time.'到'.$end.'为止';
            }
        }

        Excel::create($time.'订单报告', function($excel) use($order) {
            // 第一列sheet
            $excel->sheet('订单详情', function($sheet) use($order) {
                $sheet->setWidth(array(
                    'A'     =>  11,
                    'B'     =>  10,
                    'C'     =>  10,
                    'D'     =>  10,
                    'E'     =>  20,
                    'F'     =>  20,
                    'G'     =>  10,
                    'H'     =>  18,
                    'I'     =>  14,
                    'J'     =>  14,
                    'K'     =>  10,
                    'L'     =>  10,
                    'M'     =>  20,
                    'N'     =>  20,
                    'O'     =>  20,
                    'P'     =>  10,
                    'Q'     =>  14,
                    'R'     =>  10,
                    'S'     =>  15,
                    'T'     =>  10,
                    'U'     =>  10,
                    'V'     =>  13,
                    'W'     =>  10,
                    'X'     =>  10,
                    'Y'     =>  10,
                    'Z'     =>  10,
                    'AA'     =>  15,
                    'AB'     =>  10,
                    'AC'     =>  10,
                    'AD'     =>  10,
                    'AE'     =>  20,
                    'AF'     =>  20,
                    'AG'     =>  30,
                    'AH'     =>  20,
                ));

                $sheet->appendRow(array('商户订单号', '价格', '成本', '原价', '订单促销优惠金额', '优惠券优惠金额', '使用积分', '使用积分抵扣金额', '会员等级折扣', '用户余额支付', '调整价格', '运费', '发货时间', '确认时间', '支付时间', '支付方式', '支付平台', '支付状态','平台订单号','订单状态','物流状态','要不要发票','发票对象','发票抬头','税号','快递公司','回寄快递单号','快递单号','用户留言','促销类型','收货人姓名','收货人电话','收货人地址','创建时间'));
                $order = $order->chunk(100, function($order) use(&$sheet) {
                    $order->each(function ($item, $key) use (&$sheet) {
                        $sheet->appendRow(array(
                            $item->snumber, //商户订单号
                            $item->price, //价格
                            $item->cost, //成本
                            $item->origin_price,//原价
                            $item->preferential,//订单促销优惠金额
                            $item->coupon_money,//优惠券优惠金额
                            $item->credits,//使用积分
                            $item->credits_money,//使用积分抵扣金额
                            $item->user_level_money,//会员等级折扣
                            $item->user_money_pay,//用户余额支付
                            $item->price_adjust,//调整价格
                            $item->freight,//运费
                            $item->sendtime,//发货时间
                            $item->confirm_time,//确认时间
                            $item->paytime,//支付时间
                            $item->pay_type,//支付方式
                            $item->pay_platform,//支付平台
                            $item->order_pay,//支付状态
                            $item->pay_no,//平台订单号
                            $item->order_status,//订单状态
                            $item->order_delivery,//物流状态
                            $item->invoice,//要不要发票
                            $item->invoice_type,//发票对象
                            $item->invoice_title,//发票抬头
                            $item->tax_no,//税号
                            $item->delivery_company,//快递公司
                            $item->delivery_return,//回寄快递单号
                            $item->delivery_no,
                            $item->remark,
                            $item->prom_type,
                            $item->customer_name,
                            $item->customer_phone,
                            $item->customer_address,
                            $item->created_at
                        ));
                    });
                });
            });
            //第二列sheet
            $excel->sheet('订单商品', function ($sheet) use ($order) {
            $sheet->setWidth(array(
                'A' => 11,
                'B' => 20,
                'C' => 10,
                'D' => 10,
                'E' => 10,
                'F' => 20,
                'G' => 20,
                'H' => 20,
            ));
            $sheet->appendRow(array('商户订单号', '商品名称', '规格', '价格', '成本', '数量', '创建日期', '更新日期'));
                $order = $order->chunk(100, function($order) use(&$sheet) {
                foreach ($order as $item) {
                    $item = $item->items()->get();
                    //dd($item);
                    $item->each(function ($item_child, $key) use (&$sheet) {
                        $sheet->appendRow(array(
                            $item_child->order()->first()->snumber,
                            $item_child->name,
                            $item_child->unit,
                            $item_child->price,
                            $item_child->cost,
                            $item_child->count,
                            $item_child->created_at,
                            $item_child->updated_at
                        ));
                    });
                }
            });
        });
        })->download('xls');
    }

    //单个订单导出
    public function reportOrder($order_id){
        $order = $this->orderRepository->findWithoutFail($order_id);
        if (empty($order)) {
            Flash::error('没有该订单');
            return redirect(route('orders.index'));
        }
        //dd($order);
        $items = $order->items()->get();
        $snumber=$order->snumber;
        Excel::create($snumber.'订单报告', function($excel) use($order, $items,$snumber) {
            // 第一列sheet
            $excel->sheet('订单详情', function($sheet) use($order) {
                $sheet->setWidth(array(
                    'A'     =>  11,
                    'B'     =>  10,
                    'C'     =>  10,
                    'D'     =>  10,
                    'E'     =>  20,
                    'F'     =>  20,
                    'G'     =>  10,
                    'H'     =>  18,
                    'I'     =>  14,
                    'J'     =>  14,
                    'K'     =>  10,
                    'L'     =>  10,
                    'M'     =>  20,
                    'N'     =>  20,
                    'O'     =>  20,
                    'P'     =>  10,
                    'Q'     =>  14,
                    'R'     =>  10,
                    'S'     =>  15,
                    'T'     =>  10,
                    'U'     =>  10,
                    'V'     =>  13,
                    'W'     =>  10,
                    'X'     =>  10,
                    'Y'     =>  10,
                    'Z'     =>  10,
                    'AA'     =>  15,
                    'AB'     =>  10,
                    'AC'     =>  10,
                    'AD'     =>  10,
                    'AE'     =>  20,
                    'AF'     =>  20,
                    'AG'     =>  30,
                    'AH'     =>  20,

                ));
                $sheet->appendRow(array('商户订单号', '价格', '成本', '原价', '订单促销优惠金额', '优惠券优惠金额', '使用积分', '使用积分抵扣金额', '会员等级折扣', '用户余额支付', '调整价格', '运费', '发货时间', '确认时间', '支付时间', '支付方式', '支付平台', '支付状态','平台订单号','订单状态','物流状态','要不要发票','发票对象','发票抬头','税号','快递公司','回寄快递单号','快递单号','用户留言','促销类型','收货人姓名','收货人电话','收货人地址','创建时间'));
                    $item=$order;
                    $sheet->appendRow(array(
                        $item->snumber, //商户订单号
                        $item->price, //价格
                        $item->cost, //成本
                        $item->origin_price,//原价
                        $item->preferential,//订单促销优惠金额
                        $item->coupon_money,//优惠券优惠金额
                        $item->credits,//使用积分
                        $item->credits_money,//使用积分抵扣金额
                        $item->user_level_money,//会员等级折扣
                        $item->user_money_pay,//用户余额支付
                        $item->price_adjust,//调整价格
                        $item->freight,//运费
                        $item->sendtime,//发货时间
                        $item->confirm_time,//确认时间
                        $item->paytime,//支付时间
                        $item->pay_type,//支付方式
                        $item->pay_platform,//支付平台
                        $item->order_pay,//支付状态
                        $item->pay_no,//平台订单号
                        $item->order_status,//订单状态
                        $item->order_delivery,//物流状态
                        $item->invoice,//要不要发票
                        $item->invoice_type,//发票对象
                        $item->invoice_title,//发票抬头
                        $item->tax_no,//税号
                        $item->delivery_company,//快递公司
                        $item->delivery_return,//回寄快递单号
                        $item->delivery_no,
                        $item->remark,
                        $item->prom_type,
                        $item->customer_name,
                        $item->customer_phone,
                        $item->customer_address,
                        $item->created_at
                    ));
            });
            //第二列sheet
            $excel->sheet('订单商品', function($sheet) use($items,$snumber) {
                $sheet->setWidth(array(
                    'A'     =>  11,
                    'B'     =>  20,
                    'C'     =>  10,
                    'D'     =>  10,
                    'E'     =>  10,
                    'F'     =>  20,
                    'G'     =>  20,
                    'H'     =>  20,
                ));
                $sheet->appendRow(array('商户订单号','商品名称', '规格','价格','成本', '数量', '创建日期','更新日期'));
                $items=$items->each(function ($item, $key) use(&$sheet,$snumber) {
                    $sheet->appendRow(array(
                        $snumber,
                        $item->name,
                        $item->unit,
                        $item->price,
                        $item->cost,
                        $item->count,
                        $item->created_at,
                        $item->updated_at
                    ));
                });
            });
        })->download('xls');
    }




    /**
     * Show the form for editing the specified Order.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $order = $this->orderRepository->findWithoutFail($id);

        if (empty($order)) {
            Flash::error('Order not found');

            return redirect(route('orders.index'));
        }

        return view('admin.orders.edit')->with('order', $order);
    }

    /**
     * Update the specified Order in storage.
     *
     * @param  int              $id
     * @param UpdateOrderRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOrderRequest $request)
    {
        $order = $this->orderRepository->findWithoutFail($id);
        if (empty($order)) {
            return ['message' => "您要编辑的订单不存在", 'code' => 404];
        }
        $inputs = $request->all();
  
        $action = '' ;
        $status_desc = '';

        if(array_key_exists('backup01', $inputs)){
            $action="修改备注信息";
            $status_desc = "修改备注信息为" . $inputs['backup01'];

        }
        if(array_key_exists('add_product', $inputs)){
            $action="添加商品";
            $product=Product::find($inputs['product_id']);
            if(!empty($product)) {
                $this->orderRepository->reCaculateOrderPrice($id);
                $status_desc = "添加商品" . $product->name;
            }
        }

        if(array_key_exists('del_product',$inputs)){
            $action="删除商品";
            $product=Product::find($inputs['product_id']);
            if(!empty($product)) {
                $this->orderRepository->reCaculateOrderPrice($id);
                $status_desc = "删除商品" . $product->name;
            }
        }

        if(array_key_exists('delivery_company',$inputs)){
            $action="配送信息修改";
            $status_desc="修改快递公司为".$inputs['delivery_company'].",修改快递单号为".$inputs['delivery_no'];
        }

        if(array_key_exists('order_pay', $inputs)){
            $action="支付状态修改";
            $status_desc=is_null($inputs['operation_log'])?'无':$inputs['operation_log'];
            //设置订单支付时间
            if (array_key_exists('order_pay', $inputs) && $inputs['order_pay'] == '已支付') {
                // $inputs['pay_time'] = Carbon::now();
                // $inputs['pay_platform'] = '管理员操作';
                app('commonRepo')->processOrder($order, '管理员操作', '');
            }
        }

        if(array_key_exists('order_status',$inputs)){
            $action="订单状态修改";
            $status_desc=is_null($inputs['operation_log'])?'无':$inputs['operation_log'];
            //设置确认订单时间
            if (array_key_exists('order_status', $inputs) && $inputs['order_status'] == '已确认') {
                $inputs['confirm_time'] = Carbon::now();
            }
        }

        if(array_key_exists('order_delivery',$inputs)){
            $action="物流状态修改";
            $status_desc=is_null($inputs['operation_log'])?'无':$inputs['operation_log'];
            //设置发货时间
            if (array_key_exists('order_delivery', $inputs) && $inputs['order_delivery'] == '已发货') {
                $inputs['sendtime'] = Carbon::now();
            }
        }

        if(array_key_exists('customer_name', $inputs)){
            $action="收货地址修改";
            $status_desc="修改收货人为".$inputs['customer_name'];
            $status_desc=$status_desc.",修改收货电话为".$inputs['customer_phone'];
           // $status_desc=$status_desc.",修改地址为".$inputs['customer_address'];
        }

        if (array_key_exists('freight', $inputs)) {
            $inputs['price'] = $order->price - $order->freight + $inputs['freight'];
            $action="运费调整";
            $status_desc="调整运费为".$inputs['freight'];

        }

        if (array_key_exists('price_adjust', $inputs)) {
            $inputs['price'] += $inputs['price_adjust'] - $order->price_adjust;
            $action=$action.",调整价格";
            $status_desc= $status_desc.",调整价格为".$inputs['price_adjust'];
        }

        $order = $this->orderRepository->update($inputs, $id);
        #添加操作记录
        // if(!empty($order)) {

        //     app('commonRepo')->addOrderLog(
        //         $order->order_status, 
        //         $order->order_delivery, 
        //         $order->order_pay, 
        //         $action, 
        //         $status_desc, 
        //         auth('admin')->user()->name, 
        //         $order->id
        //     );
        // }

        return ['message' => '修改成功', 'code' => 0];
    }

    /**
     * Remove the specified Order from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $order = $this->orderRepository->findWithoutFail($id);

        if (empty($order)) {
            Flash::error('Order not found');

            return redirect(route('orders.index'));
        }

        $this->orderRepository->delete($id);

        Flash::success('Order deleted successfully.');

        return redirect(route('orders.index'));
    }

    public function deleteOrder($id)
    {
        return $this->orderRepository->cancelOrder($id, '取消订单', auth('admin')->user()->name);
    }

    //打印订单
    public function printOrder($id){
        return $this->orderRepository->printOrder($id);
    }

    // 打印三联订单
    public function tripperprintOrder($id){
        $order = $this->orderRepository->findWithoutFail($id);

        if (empty($order)) {
            Flash::error('Order not found');

            return redirect(route('orders.index'));
        }
        return view('admin.orders.print')->with('order', $order);
    }



    public function addProductList(Request $request){
        $input=$request->all();
        if(array_key_exists('product_id',$input)) {
            $product = Product::find($input['product_id']);
            if(!empty($product)) {
                $order_id = $input['order_id'];
                if ($input['spec_id'] != 0) {
                    $spec = SpecProductPrice::find($input['spec_id']);
                    if (empty($spec)) {
                        return ['code' => 1, 'message' => '没有规格信息'];
                    }
                    $item = Item::create([
                        'name' => $product->name,
                        'pic' => '',
                        'price' => $spec->price,
                        'cost' => $product->cost,
                        'count' => 1,
                        'unit' => $spec->key_name,
                        'order_id' => $order_id,
                        'product_id' => $product->id,
                        'spec_key' => $spec->key,
                        'spec_keyname' => $spec->key_name,
                    ]);
                    return ['code' => 0, 'message' => $item->id];
                } else {
                    $item = Item::create([
                        'name' => $product->name,
                        'pic' => '',
                        'price' => $product->price,
                        'cost' => $product->cost,
                        'count' => 1,
                        'unit' => '--',
                        'order_id' => $order_id,
                        'product_id' => $product->id,
                        'spec_key' => null,
                        'spec_keyname' => null
                    ]);
                    return ['code' => 0, 'message' => $item->id];
                }
            }else{
                return ['code'=>1,'message'=>'没有该商品'];
            }
        }else{
            return ['code'=>1,'message'=>'没有商品id'];
        }
    }

    public function delProductList($item_id){
        $item=Item::where('id',$item_id);
        if($item->count()) {
            $item->delete();
            return ['code' => 0, 'message' => ''];
        }else{
            return ['code' => 1, 'message' => '未知错误'];
        }
    }

    public function print(Request $request, $id)
    {
        $order = $this->orderRepository->findWithoutFail($id);

        if (empty($order)) {
            Flash::error('Order not found');

            return redirect(route('orders.index'));
        }
        
        $items = $order->items()->get();
        $actions=$order->actions()->orderBy('created_at','desc')->paginate(15);
        return view('admin.orders.print', compact('order', 'items','actions'));
    }

    private function varifyOrderInput($orders,$input){

        $orders = $orders->where('account',$input['account'])->where('shop_id',now_shop_id());

        if (array_key_exists('snumber', $input)) {
            $orders = $orders->where('snumber', $input['snumber']);
        }
        if (array_key_exists('menu_type', $input)) {
            if($input['menu_type']!='6') {
                $orders = $orders->where('prom_type', $input['menu_type']);
            }else{
                $input['order_pay']='已支付';
                $input['order_delivery']='未发货';
            }
        }
        if (array_key_exists('order_type', $input)) {
            if($input['order_type']!='6') {
                $orders = $orders->where('prom_type', $input['order_type']);
            }else{
                $input['order_pay']='已支付';
                $input['order_delivery']='未发货';
            }
        }
        if (array_key_exists('price_start', $input)) {
            $orders = $orders->where('price', '>=', $input['price_start']);
        }
        if (array_key_exists('price_end', $input)) {
            $orders = $orders->where('price', '<=', $input['price_end']);
        }
        if (array_key_exists('order_status', $input)) {
            $orders = $orders->where('order_status', $input['order_status']);
        }
        if (array_key_exists('order_delivery', $input)) {
            $orders = $orders->where('order_delivery', $input['order_delivery']);
        }
        if (array_key_exists('pay_type', $input)) {
            $orders = $orders->where('pay_type', $input['pay_type']);
        }

        if (array_key_exists('order_pay', $input)) {
            $orders = $orders->where('order_pay', $input['order_pay']);
        }
        if (array_key_exists('invoice', $input)) {
            $orders = $orders->where('invoice', $input['invoice']);
        }
        if (array_key_exists('sendtime_start', $input)) {
            $orders = $orders->where('sendtime', '>=', Carbon::createFromFormat('Y-m-d', $input['sendtime_start'])->setTime(0, 0, 0));
        }
        if (array_key_exists('sendtime_end', $input)) {
            $orders = $orders->where('sendtime', '<', Carbon::createFromFormat('Y-m-d', $input['sendtime_end'])->addDay()->setTime(0, 0, 0));
        }
        if (array_key_exists('create_start', $input)) {
            $orders = $orders->where('created_at', '>=', Carbon::createFromFormat('Y-m-d', $input['create_start'])->setTime(0, 0, 0));
        }
        if (array_key_exists('create_end', $input)) {
            $orders = $orders->where('created_at', '<', Carbon::createFromFormat('Y-m-d', $input['create_end'])->addDay()->setTime(0, 0, 0));
        }
        if (array_key_exists('address', $input)) {
            $orders = $orders->where('customer_address', 'like', '%'.$input['address'].'%');
        }
        if (array_key_exists('name', $input)) {
            $orders = $orders->where('customer_name', 'like', '%'.$input['name'].'%');
        }
        if (array_key_exists('contact', $input)) {
            $orders = $orders->where('customer_phone', 'like', '%'.$input['contact'].'%');
        }
        return $orders;
    }

}
