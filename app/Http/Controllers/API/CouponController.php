<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\UserLevel;

use App\Repositories\CouponRepository;
use App\Repositories\CouponUserRepository;
use App\Repositories\UserRepository;

use EasyWeChat\Factory;
use Config;
use Log;
use Storage;

class CouponController extends Controller
{

	private $couponRepository;
    private $couponUserRepository;
    private $userRepository;
    public function __construct(
        UserRepository $userRepo,
        CouponUserRepository $couponUserRepo, 
        CouponRepository $couponRepo
    )
    {
        $this->couponRepository = $couponRepo;
        $this->couponUserRepository = $couponUserRepo;
        $this->userRepository=$userRepo;
    }
    
    /**
     * 小程序获取用户的优惠券
     *
     * @SWG\Get(path="/api/coupons",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序获取用户的优惠券",
     *   description="小程序获取用户的优惠券,需要token信息",
     *   operationId="couponsList_User",
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
    public function coupons(Request $request, $type = -1)
    {
    	$user = auth()->user();
    	$take = 18;
        $type = -1;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        if ($request->has('type')){
            $type = $request->input('type');
        }
        $coupons = $this->couponRepository->couponGetByStatus($user, $type, $skip, $take);
        return ['status_code' => 0, 'data' => $coupons];
    }

    /**
     * 小程序优惠买单可以使用的优惠券
     *
     * @SWG\Get(path="/api/coupons_canuse",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序优惠买单可以使用的优惠券",
     *   description="小程序优惠买单可以使用的优惠券,需要token信息",
     *   operationId="couponsCanUseUser",
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
    public function couponsCanUse(Request $request)
    {
        $user = auth()->user();
        $shop_id = $request->input('shop_id');
        $coupons = $this->couponRepository->couponCanUse($user,$shop_id);

        $total = $request->input('price');
  
        //过滤不满足使用条件的优惠券
        $coupons = $coupons->filter(function ($coupon, $key) use($total) {
            return app('commonRepo')->CouponPreference($coupon->id, $total)['code'] == 0;
        });

        foreach ($coupons as $key => $coupon) {
            $coupon['coupon'] = $coupon->coupon;
        }


        return ['status_code' => 0, 'data' => $coupons];
    }
    

    public function couponsUse(Request $request, $coupon_id)
    {
        $inputs = $request->all();

        $items = $inputs['items'];
        $items = json_decode($inputs['items'], true);

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
        
        return ['status_code' => 0, 'data' => app('commonRepo')->CouponPreference($coupon_id, $total, $items)];
    }
}