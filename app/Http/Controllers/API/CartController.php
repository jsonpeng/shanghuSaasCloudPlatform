<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\UserLevel;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function cartPreference(Request $request)
    {

    	$inputs = $request->all();
        $items = json_decode($inputs['items'], true);
        //处理购物车中商品信息，便于前端展示
        $items = app('commonRepo')->processShoppingCartItems($items);

        if ( sizeof($items) == 0 ) {
            return ['status_code'=>1, 'data' => '没有商品信息'];
        }

        //商品运费
        $freight = 0;
        if (array_key_exists('address_id', $inputs)) {
        	$address = app('commonRepo')->addressRepo()->findWithoutFail($inputs['address_id']);
        	if (!empty($address)) {
        		$freight = app('commonRepo')->freight($address, $items);
        	}
        }

        //商品总价
        $total = 0;
        foreach ($items as $item) {
            if (is_array($item)) {
                $item_qty = $item['qty'];
                $item_price = $item['price'];
                $total += $item_price * $item_qty;
            } else {
                $item_qty = $item->qty;
                $item_price = $item->price;
                $total += $item_price * $item_qty;
            }
        }

        $user = auth()->user();
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

        return ['status_code'=>0, 'data' => [
        	'user_level' => $user_level,
        	'total' => $total,
        	'freight' => $freight,
        	'prom_type' => $prom_type,
        	'prom_id' => $prom_id,
        	'order_promp' => $orderPreference_name,
        	'order_promp_money' => $orderPreference_money,
        	'preference' => $preference
        ]];
    }

    public function freight(Request $request)
    {
    	$inputs = $request->all();
        $items = json_decode($inputs['items'], true);
        //处理购物车中商品信息，便于前端展示
        $items = app('commonRepo')->processShoppingCartItems($items);

        if ( sizeof($items) == 0 ) {
            return ['status_code'=>1, 'data' => '没有商品信息'];
        }

        //商品运费
        $freight = 0;
        if (array_key_exists('address_id', $inputs)) {
        	$address = app('commonRepo')->addressRepo()->findWithoutFail($inputs['address_id']);
        	if (!empty($address)) {
        		$freight = app('commonRepo')->freight($address, $items);
        	}else{
        		return ['status_code'=>1, 'data' => '地址信息不存在'];
        	}
        }else{
        	return ['status_code'=>1, 'data' => '参数不正确'];
        }

        return ['status_code'=>0, 'data' => $freight];
    }
}
