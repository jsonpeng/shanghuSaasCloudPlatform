<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * Class Order
 * @package App\Models
 * @version April 28, 2017, 2:32 am UTC
 */
class Order extends Model
{
    use SoftDeletes;

    public $table = 'orders';
    
    protected $dates = ['deleted_at', 'confirm_time'];

    public $fillable = [
        'snumber',
        'price',
        'origin_price',
        'preferential',
        'freight',
        'coupon_money',
        'user_level_money',
        'user_money_pay',
        'credits_money',
        'credits',
        'cost',
        'price_adjust',
        'order_delivery',
        'order_pay',
        'order_status',
        'pay_type',
        'remark',
        'customer_name',
        'customer_phone',
        'customer_address',
        'delivery_province',
        'delivery_city',
        'delivery_district',
        'delivery_street',
        'delivery_company',
        'delivery_return',
        'delivery_no',
        'pay_platform',
        'pay_no',
        'out_trade_no',
        'user_id',
        'prom_id',
        'prom_type',
        'invoice',
        'invoice_type',
        'invoice_title',
        'tax_no',
        'sendtime',
        'confirm_time',
        'paytime',
        'backup01',
        'account',
        'shop_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'snumber' => 'string',
        'price' => 'float',
        'origin_price' => 'float',
        'preferential' => 'float',
        'freight' => 'float',
        'order_delivery' => 'string',
        'order_pay' => 'string',
        'remark' => 'string',
        'customer_name' => 'string',
        'customer_phone' => 'string',
        'customer_address' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    //订单状态
    public function getStatusAttribute(){
        if($this->order_status == '无效'){
            return '无效订单';
        }
        else if($this->order_status == '已取消'){
            return '已取消';
        }
        else{
            if ($this->order_pay == '未支付'){
                return '待付款';
            }
            else{
                if($this->order_delivery == '未发货'){
                  return '待发货';
                }

                if($this->order_delivery == '已发货'){
                  return '待收货';
                }

                if($this->order_delivery == '已收货'){
                    return '已完成';
                }
            }      
        }
    }

    // 订单所属用户
    public function customer(){
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    //订单送货地址
    public function address(){
        return $this->belongsTo('App\Models\Address');
    }

    //订单商品
    public function items(){
        return $this->hasMany('App\Models\Item');
    }

    //取消订单
    public function cancels(){
        return $this->hasMany('App\Models\OrderCancel');
    }

    //订单状态
    public function actions(){
        return $this->hasMany('App\Models\OrderAction');
    }

    //开团信息
    public function teamFound(){
        return $this->hasOne('App\Models\TeamFound');
    }

    //参团信息
    public function teamFollow(){
        return $this->hasMany('App\Models\TeamFollow');
    }

    //订单使用的优惠券
    public function coupons(){
        return $this->belongsToMany('App\Models\CouponUser', 'coupon_order', 'order2_id', 'coupon_id');
    }

    //订单是否还可以修改
    public function getCanEditAttribute(){
        if ($this->pay_type != '现金支付' && $this->order_pay == '已支付') {
            return false;
        }
        if ($this->order_delivery != '未发货') {
            return false;
        }
        return true;
    }

    //订单是否可以发货
    public function getCanSentAttribute(){
        if ($this->order_delivery == '已发货' || $this->order_status == '未确认' || $this->order_delivery == '已收货') {
            return false;
        }
        if ($this->pay_type != '现金支付' && $this->order_pay == '未支付') {
            return false;
        }
        return true;
    }

    //订单是否还可以申请售后
    public function getAfterSaleAttribute(){
        if ($this->order_delivery != '已收货'){
            return false;
        }
        if ($this->order_delivery == '已收货' && $this->confirm_time->addDays(getSettingValueByKeyCache('after_sale_time'))->lt(Carbon::now())) {
            return false;
        }
        return true;
    }
    
}
