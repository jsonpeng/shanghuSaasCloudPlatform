<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;

use ShoppingCart;
use App\Models\Order;
use App\Models\Item;
use App\Models\Setting;
use App\Models\UserLevel;
use App\Models\CouponUser;
use App\Models\SpecProductPrice;
use App\Repositories\AddressRepository;
use App\Repositories\ProductRepository;
use App\Repositories\FlashSaleRepository;
use App\Repositories\TeamFoundRepository;
use App\Repositories\TeamFollowRepository;
//use App\Repositories\SpecProductPriceRepository;

use Log;
use Config;
use Carbon\Carbon;
use Auth;


class CartController extends Controller
{
    private $addressRepository;
    private $productRepository;
    private $orderRepository;
    private $flashSaleRepository;
    //private $specProductPriceRepository;

    public function __construct(
        OrderRepository $orderRepo, 
        FlashSaleRepository $flashSaleRepo,
        AddressRepository $addressRepo, 
        ProductRepository $productRepo
        //SpecProductPriceRepository $specProductPriceRepo
    )
    {
        $this->addressRepository = $addressRepo;
        $this->productRepository = $productRepo;
        $this->orderRepository = $orderRepo; 
        //$this->specProductPriceRepository = $specProductPriceRepo;
        $this->flashSaleRepository = $flashSaleRepo;
    }

    private function dateValidate($time_start, $time_end){
        $st = Carbon::parse($time_start);
        $ed = Carbon::parse($time_end);
        $now = Carbon::now();
        if ($now->gte($st) && $now->lte($ed)) {
            return true;
        }else{
            return false;
        }
    }

    //购物车
    public function cart(Request $request){
        //秒杀和拼团就直接跳转到结算页面
        if ($request->has('product_promp') && $request->input('product_promp') != 0) {
            return redirect('/check?product_promp='.$request->input('product_promp').'&promp_id='.$request->input('promp_id', 0));
        }
        $items = app('commonRepo')->processShoppingCartItems(ShoppingCart::all());
        $count = ShoppingCart::count();
        $total = ShoppingCart::total();
        $user = auth('web')->user();
        //return $items;
        return view(frontView('cart'), compact('user', 'items', 'count', 'total'));
    }

    public function check(Request $request)
    {
        //手动设置了收货地址
        $address = null;
        if ($request->session()->has('curAddress')) {
            $address = $request->session()->get('curAddress');
        }else{
            $address = $this->addressRepository->getDefaultAddress();
        }
        //处理购物车中商品信息，便于前端展示
        $items = app('commonRepo')->processShoppingCartItems(ShoppingCart::all());

        if ($items->count() == 0) {
            return redirect('/category');
        }
        //商品总价
        $total = ShoppingCart::total();
        //商品运费
        $freight = app('commonRepo')->freight($address, ShoppingCart::all());

        $user = auth('web')->user();
        //用户会员等级优惠
        $user_level = null;
        $preference = 0;
        if (funcOpen('FUNC_MEMBER_LEVEL')) {
            $user_level = UserLevel::where('id',$user->user_level)->first();
            $preference = app('commonRepo')->UserLevelPreference($user, $total);
        }
        
        $prom_type = 0;
        $prom_id = 0;
        $orderPreference_money = 0;
        $orderPreference_name = 0;
        //订单优惠
        if (funcOpen('FUNC_ORDER_PROMP')) {
            $orderPreference = app('commonRepo')->orderPreference($total);
            if ($orderPreference['money']) {
                $prom_type = 4;
                $prom_id = $orderPreference['prom_id'];
                $orderPreference_money = $orderPreference['money'];
                $orderPreference_name = $orderPreference['name'];
            }
        }

        return view(frontView('check'))
            ->with('user', $user)
            ->with('user_level', $user_level)
            ->with('address', $address)
            ->with('items', $items)
            ->with('needPay', $total + $freight - $preference - $orderPreference_money)
            ->with('total', $total)
            ->with('freight', $freight)
            ->with('prom_type', $prom_type)
            ->with('prom_id', $prom_id)
            ->with('order_promp', $orderPreference_name)
            ->with('order_promp_money', $orderPreference_money)
            ->with('preference', $preference);
    }

    public function checkNow(Request $request)
    {
        if (!$request->has('specPriceItemId') || !$request->has('count') || !$request->has('product_id') || !$request->has('prom_type') || !$request->has('prom_id') || !$request->has('join_team') || !$request->has('start_or_Join')) {
            return redirect()->back();
        }

        $request->session()->put('checknow_url', $request->fullUrl());

        //手动设置了收货地址
        $address = null;
        if ($request->session()->has('curAddress')) {
            $address = $request->session()->get('curAddress');
        }else{
            $address = $this->addressRepository->getDefaultAddress();
        }

        //促销订单（秒杀和拼团）
        $prom_type = 0;
        if ($request->has('prom_type') && $request->input('prom_type') != 0) {
            $prom_type = $request->input('prom_type');
        }
        $prom_id = 0;
        if ($request->has('prom_id') && $request->input('prom_id') != 0) {
            $prom_id = $request->input('prom_id');
        }

        // if ($request->input('specPriceItemId') > 0) {
        //     //带规格
        //     $specPrice = SpecProductPrice::where('id', $request->input('specPriceItemId'))->first();
        //     //dd($specPrice);
        //     if (empty($specPrice)) {
        //         return redirect()->back();
        //         //return ['code' => 1, 'message' => '商品信息不存在'];
        //     }

        //     $product_price = $this->specProductPriceRepository->getSalesPrice($specPrice);

        //     $total = $product_price * $request->input('count');

        //     $items = [[
        //         'type' => 1,
        //         'qty' => $request->input('count'),
        //         'product' => $this->productRepository->findWithoutFail($request->input('product_id')),
        //         'realPrice' => $product_price,
        //         'spec' => $specPrice,
        //     ]];

        //     return view(frontView('checknow'))
        //         ->with('address', $address)
        //         ->with('items', $items)
        //         ->with('total', $total)
        //         ->with('freight', 0)
        //         ->with('prom_type', $prom_type)
        //         ->with('prom_id', $prom_id)
        //         ->with('join_team', $request->input('join_team'))
        //         ->with('start_or_Join', $request->input('start_or_Join'));
        // }else{
            //不带规格
            $product = $this->productRepository->findWithoutFail($request->input('product_id'));
            if (empty($product)) {
                return redirect()->back();
                //return ['code' => 1, 'message' => '商品信息不存在'];
            }
            $realPrice = $this->productRepository->getSalesPrice($product);
            $total = $realPrice * $request->input('count');
            $items = [[
                'type' => 0,
                'qty' => $request->input('count'),
                'product' => $product,
                'realPrice' => $realPrice,
                'spec' => null,
            ]];

            return view(frontView('checknow'))
                ->with('address', $address)
                ->with('items', $items)
                ->with('total', $total)
                ->with('freight', 0)
                ->with('prom_type', $prom_type)
                ->with('prom_id', $prom_id)
                ->with('join_team', $request->input('join_team'))
                ->with('start_or_Join', $request->input('start_or_Join'));
        //}
    }

    public function postCheck(Request $request)
    {
        try {
            //当前用户
            $user = auth('web')->user();

            //订单商品
            $items = ShoppingCart::all();

            //订单信息
            $inputs = $request->all();

            // return  ['code'=>2,'items'=>$items];
            $order = $this->orderRepository->createOrder($user, $items, $inputs);

            //清空购物车
            ShoppingCart::clean();
            //return  ['code'=>2,'items'=>$items];
            return ['code'=>0, 'message' => $order->id];
            //return ['code'=>2, 'message' => $order->id,'inputs'=>$inputs,'items'=>$items];
        } catch (Exception $e) {

        }
    }

    public function postCheckNow(Request $request, TeamFoundRepository $teamFoundRepo, TeamFollowRepository $teamFollowRepo)
    {
        try {

            if (!$request->has('specPriceItemId') || !$request->has('count') || !$request->has('product_id') || !$request->has('prom_type') || !$request->has('prom_id') || !$request->has('join_team') || !$request->has('start_or_Join')) {
                //提示错误信息
                return ['code' => 1, 'message' => '参数错误'];
            }

            $user = auth('web')->user();
            $inputs = $request->all();
            $inputs['user_id'] = $user->id;
            $inputs['snumber'] = ''; //订单号
            $inputs['price'] = 0; //价格
            $inputs['origin_price'] = 0; //原价
            $inputs['preferential'] = 0; //优惠
            $inputs['freight'] = 0; // 运费

            $order = Order::create($inputs);
            $totalprice = 0;  //总价格
            $totalCost = 0; //总成本
            $origin_price = 0; //原价

            //if ($request->input('specPriceItemId') < 1) {
                //不带规格
                $product = $this->productRepository->findWithoutFail($request->input('product_id'));
                if (empty($product)) {
                    $this->orderRepository->delete($order->id);
                    return ['code'=>1, 'message' => '对不起，商品'.$product->name.'已下架'];
                }
                if ($product->inventory != -1 && $product->inventory < $request->input('count')) {
                    $this->orderRepository->delete($order->id);
                    return ['code'=>1, 'message' => '商品'.$product->name.'库存不足，最大可买数量: '.$product->inventory];
                }
                $product_price = $this->productRepository->getSalesPrice($product);
                Item::create([
                    'name' => $product->name,
                    'pic' => $product->image,
                    'price' => $product_price,
                    'cost' => $product->cost,
                    'count' => $request->input('count'),
                    'unit' => '',
                    'order_id' => $order->id,
                    'product_id' => $product->id
                ]);
                // 计算订单总金额
                $totalprice += $product_price * $request->input('count');
                $totalCost += $product->cost * $request->input('count');
                $origin_price += $product->price * $request->input('count');
                
            // } else {
            //     $product = $this->productRepository->findWithoutFail($request->input('product_id'));
            //     if (empty($product)) {
            //         $this->orderRepository->delete($order->id);
            //         return ['code'=>1, 'message' => '对不起，商品'.$product->name.'已下架'];
            //     }
            //     $spec = $this->specProductPriceRepository->findWithoutFail($request->input('specPriceItemId'));
            //     if (empty($spec)) {
            //         $this->orderRepository->delete($order->id);
            //         return ['code'=>1, 'message' => '对不起，商品'.$product->name.'('.$spec->key_name.') 已下架'];
            //     }
            //     if ($spec->inventory != -1 && $spec->inventory < $request->input('count')) {
            //         $this->orderRepository->delete($order->id);
            //         return ['code'=>1, 'message' => '商品'.$product->name.'('.$spec->key_name.') 库存不足，最大可买数量: '.$spec->inventory];
            //     }
            //     //更新商品销售数量，和减少库存
            //     $product_price = $this->specProductPriceRepository->getSalesPrice($spec);
            //     Item::create([
            //         'name' => $product->name,
            //         'pic' => $spec->image,
            //         'price' => $product_price,
            //         'cost' => $product->cost,
            //         'count' => $request->input('count'),
            //         'unit' => $spec->key_name,
            //         'order_id' => $order->id,
            //         'product_id' => $product->id,
            //         'spec_key' => $spec->key,
            //         'spec_keyname' => $spec->key_name,
            //     ]);
            //     // 计算订单总金额
            //     $totalprice += $product_price * $request->input('count');
            //     $totalCost += $product->cost * $request->input('count');
            //     $origin_price += $spec->price * $request->input('count');
            // }

            // 更新订单编号和总金额
            $this->orderRepository->update([
                'price' => $totalprice,
                'origin_price' => $origin_price,
                'cost' => $totalCost,
                'snumber' => 6000000 + $order->id
                ], $order->id);
            //创建未支付团
            if ($request->input('prom_type') == 5) {
                $result = null;
                if ($request->input('start_or_Join') == 0) {
                    //开团
                    $result = $teamFoundRepo->createTeamFound($order->id, false);
                } else {
                    //参团
                    $result = $teamFollowRepo->createTeamFollow($order->id, $request->input('join_team'), false);
                }
                if ($result['code']) {
                    $this->orderRepository->delete($order->id);
                    return ['code'=>1, 'message' => $result['message']];
                }
            }
            //减库存
            if (getSettingValueByKey('inventory_consume') == '下单成功') {
                $this->orderRepository->deduceInventory($order->id);
            }
            if ($request->input('prom_type') == 1) {
                //秒杀
                $flashSale = $this->flashSaleRepository->findWithoutFail($request->input('prom_id'));
                if (!empty($flashSale)) {
                    $flashSale->update([
                        'product_num' => $flashSale->product_num - $request->input('count'),
                        'buy_num' => $flashSale->buy_num + $request->input('count'),
                        'order_num' => $flashSale->order_num + 1,
                    ]);
                }
            }
            return ['code'=>0, 'message' => $order->id];
        } catch (Exception $e) {

        }
    }

    //加入购物车
    public function add(Request $request)
    {
        $inputs = $request->all();
        return $this->addToCart($inputs);
    }

    private function addToCart($inputs){
        if (!array_key_exists('product_id', $inputs) || $inputs['product_id'] < 1 || !array_key_exists('count', $inputs) || $inputs['count'] < 1) {
            return ['code' => 1, 'message' => '请求参数不正确'];
        }

        $product = $this->productRepository->findWithoutFail($inputs['product_id']);
        if (empty($product)) {
            return ['code' => 1, 'message' => '商品信息不存在'];
        }

        if (array_key_exists('specPriceItemId', $inputs) && $inputs['specPriceItemId'] > 0) {
            //按规格购买
            $specPrice = SpecProductPrice::where('id', $inputs['specPriceItemId'])->first();
            if (empty($specPrice)) {
                return ['code' => 1, 'message' => '商品信息不存在'];
            }
            //存在则更新
            $items = ShoppingCart::search([ 'id' => $inputs['product_id'].'_'.$inputs['specPriceItemId'] ]);
            if ($items->count()) {
                $item = $items->first();
                $newQty = app('commonRepo')->maxCanBuy($product, $inputs['count'] + $item->qty, $specPrice->id);
                ShoppingCart::update($item->__raw_id, ['qty' => $newQty]  );
            } else {
                $newQty = app('commonRepo')->maxCanBuy($product, $inputs['count'], $specPrice->id);
                ShoppingCart::add(
                    $inputs['product_id'].'_'.$inputs['specPriceItemId'],
                    $specPrice->key_name,
                    $newQty,
                    $this->specProductPriceRepository->getSalesPrice($specPrice, false)
                );
            }
            return ['code' => 0, 'message' => ['count' => ShoppingCart::count(), 'total' => ShoppingCart::total(), 'qty' => $newQty]];
        } else {
            //没有规格
            $newQty = 0;
            $items = ShoppingCart::search([ 'id' => $inputs['product_id'].'_0' ]);
            // if (empty($product)) {
            //     return ['code' => 1, 'message' => '商品信息不存在'];
            // }
            if ($items->count()) {
                $item = $items->first();
                $newQty = app('commonRepo')->maxCanBuy($product, $inputs['count'] + $item->qty);
                ShoppingCart::update($item->__raw_id, ['qty' => $newQty]);
            } else {
                $newQty = app('commonRepo')->maxCanBuy($product, $inputs['count']);
                ShoppingCart::add(
                    $inputs['product_id'].'_0',
                    $product->name,
                    $newQty,
                    $this->productRepository->getSalesPrice($product, false)
                );
            }
            return ['code' => 0, 'message' => ['count' => ShoppingCart::count(), 'total' => ShoppingCart::total(), 'qty' => $newQty]];
        }
    }

    public function update(Request $request)
    {
        $inputs = $request->all();
        if (!array_key_exists('cart_id', $inputs) || $inputs['cart_id'] < 1 || !array_key_exists('count', $inputs) || $inputs['count'] < 1) {
            return ['code' => 1, 'message' => '请求参数不正确'];
        }

        //存在则更新
        $newQty = 0;
        $items = ShoppingCart::search(['id' => $inputs['cart_id']]);
        $qty = $inputs['count'];
        if ($items->count()) {
            $item = $items->first();
            $ids = explode('_', $item->id);
            $product  = $this->productRepository->findWithoutFail($ids[0]);
            if (empty($product)) {
                return ['code' => 0, 'message' => '商品不存在'];
            }
            $specPrice = null;
            // if ($ids[1] > 0) {
            //     $specPrice = $this->specProductPriceRepository->findWithoutFail($ids[1]);
            // }
            
            if (empty($specPrice)) {
                $newQty = app('commonRepo')->maxCanBuy($product, $qty);
            } else {
                $newQty = app('commonRepo')->maxCanBuy($product, $qty, $specPrice->id);
            }

            ShoppingCart::update($item->__raw_id, ['qty' => $newQty]);
        }

        return ['code' => 0, 'message' => ['count' => ShoppingCart::count(), 'total' => ShoppingCart::total(), 'qty' => $newQty]];
    }

    public function delete(Request $request)
    {
        $inputs = $request->all();
        if (!array_key_exists('cart_id', $inputs) || $inputs['cart_id'] < 1) {
            return ['code' => 1, 'message' => '请求参数不正确'];
        }
        $items = ShoppingCart::search(['id' => $inputs['cart_id']]);
        foreach ($items as $item) {
            ShoppingCart::remove($item->__raw_id);
        }
        return ['code' => 0, 'message' => ['count' => ShoppingCart::count(), 'total' => ShoppingCart::total()]];
    }

    public function buyAgain(Request $request, $id)
    {
        $order = $this->orderRepository->findWithoutFail($id);
        if (empty($order)) {
            return redirect()->back();
        }

        $items = $order->items;
        foreach ($items as $item) {

            $product = $this->productRepository->findWithoutFail($item->product_id);

            if (empty($product)) {
                continue;
            }
            $specProductPrice = SpecProductPrice::where('product_id', $item->product_id)->where('key', $item->spec_key)->first();

            $this->addToCart([
                'product_id' => $item->product_id,
                'count' => $item->count,
                'specPriceItemId' => empty($specProductPrice) ? 0 :$specProductPrice->id,
            ]);
        }

        return redirect('/cart');
    }

    public function getCartNum()
    {
        return ['code' => 0, 'message' => ShoppingCart::count()];
    }
    
}
