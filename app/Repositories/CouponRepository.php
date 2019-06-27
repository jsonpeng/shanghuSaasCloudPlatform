<?php

namespace App\Repositories;

use App\Models\Coupon;
use App\Models\CouponRule;
use Carbon\Carbon;
use InfyOm\Generator\Common\BaseRepository;

class CouponRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'time_begin',
        'time_end',
        'type',
        'base',
        'given',
        'discount',
        'together',
        'department'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Coupon::class;
    }

    /*
     * 清空优惠券下面的商品
     */
    public function resetProductByCouponId($coupon_id){
        $coupon=Coupon::find($coupon_id);
        return $coupon->products()->sync([]);
    }

    /* 
     * 获取优惠的商品列表并且附带规格信息
     */
    public function getCouponProductListByCouponId($coupon_id){
        $coupon=Coupon::find($coupon_id);
        if(!empty($coupon)) {
            return $coupon->products()->get();
        }
        else{
            return [];
        }
    }

    /*
     * 仅仅获取规格信息列表
     */
    public function  getCouponSpecsListByCouponId($coupon_id){
        $coupon=Coupon::find($coupon_id);
        if(!empty($coupon)) {
            return $coupon->specs()->get();
        }else{
            return [];
        }
    }

    /**
     * 获取用户当前可用的优惠券信息
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function couponCanUse($user,$shop_id)
    {
        $today = \Carbon\Carbon::today();
        return $user->coupons()
        ->where('shop_id',$shop_id)
        ->where('status', 0)
        ->where('time_begin', '<=', $today)
        ->where('time_end', '>=', $today)
        ->get();
    }

    /*
     * 根据状态获取优惠券信息
     * 优惠券状态$status_id -1所有 0未使用 1冻结 2已使用 3过期 4作废
     * 默认获取未使用的
     */
    public function couponGetByStatus($user, $status_id = 0, $skip = 0, $take = 18){

        $today = \Carbon\Carbon::today();
        $coupons = [];
        switch ($status_id) {
            case -1:
                $coupons = $user->coupons()->with('coupon')->skip($skip)->take($take)->get();
                break;
            case 0:
                $coupons = $user->coupons()->with('coupon')->where('status', 0)->where('time_begin', '<=', $today)->where('time_end', '>=', $today)->skip($skip)->take($take)->get();
                break;
            case 2:
                $coupons = $user->coupons()->with('coupon')->where('status', 2)->skip($skip)->take($take)->get();
                break;
            case 1:
            case 3:
            case 4:
                $coupons = $user->coupons()->with('coupon')->whereIn('status', [1, 3, 4])->skip($skip)->take($take)->get();
                break;
            default:
                $coupons = $user->coupons()->with('coupon')->skip($skip)->take($take)->get();
                break;
        }
        return $coupons;
    }

    /**
     * 获取某种赠送规则下的优惠券
     * @param  [type]  $rule_type [优惠券赠送规则 0 新用户注册 1 购物满送 2 推荐新用户注册 3 推荐新用户下单 4 免费领取]
     * @param  integer $min_money [优惠券使用门槛]
     * @return [type]             [App\Models\Coupon Collcetion]
     */
    public function getCouponOfRule($rule_type, $min_money = 0)
    {
        $rules = $this->getRulesOfType($rule_type);
        $coupons = collect([]);
        foreach ($rules as $rule) {
            if ($rule->base > $min_money) {
                continue;
            }
            $coupons = $coupons->concat($rule->coupons);

        }
        return $coupons;
    }

    /**
     * 获取还在生效中的赠送规则
     * @param  [type] $rule_type [description]
     * @return [type]            [description]
     */
    public function getRulesOfType($rule_type)
    {
        $now = Carbon::now();
        return CouponRule::where('type', $rule_type)
        ->where(function ($query) {
            $query->where('max_count', 0)
            ->orWhereColumn('count', '<', 'max_count');
        })
        ->where('time_begin', '<=', $now)
        ->where('time_end', '>=', $now)
        ->get();
    }

}
