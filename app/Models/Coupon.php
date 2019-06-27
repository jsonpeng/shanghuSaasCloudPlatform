<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

/**
 * Class Coupon
 * @package App\Models
 * @version June 22, 2017, 3:49 am UTC
 */
class Coupon extends Model
{
    use SoftDeletes;

    public $table = 'coupons';
    

    protected $dates = ['deleted_at', 'time_begin', 'time_end'];


    public $fillable = [
        'name',
        'time_begin',
        'time_end',
        'type',
        'base',
        'given',
        'discount',
        'together',
        'time_type',
        'expire_days',
        'range',
        'category_id',
        'max_count',
        'account',
        'shop_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'time_begin'=> 'date',
        'time_end' => 'date',
        'type' => 'string',
        'base' => 'float',
        'given' => 'float',
        'discount' => 'float',
        'together' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'type' => 'required',
        'base' => 'required'
    ];

    // 优惠券关联的发放规则
    /*
    public function rules(){
        return $this->belongsToMany('App\Models\CouponRule', 'coupon_rule', 'coupon_id', 'rule_id');
    }
    */

    public function products(){
        return $this->belongsToMany('App\Models\Product', 'coupon_product', 'coupon_id', 'product_id');
    }

    public function specs(){
        return $this->belongsToMany('App\Models\SpecProductPrice', 'coupon_product', 'coupon_id', 'spec_price_id');
    }

    
    public function getExpiredAttribute(){
        return Carbon::now()->gt(Carbon::parse($this->time_end)->addDay());
    }
}
