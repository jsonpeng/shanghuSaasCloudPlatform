<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class DiscountOrder
 * @package App\Models
 * @version June 7, 2018, 10:23 am CST
 *
 * @property float price
 * @property integer user_id
 * @property float orgin_price
 * @property float no_discount_price
 * @property float use_user_money
 * @property float user_level_money
 * @property integer coupon_id
 * @property float coupon_price
 */
class DiscountOrder extends Model
{
    use SoftDeletes;

    public $table = 'discount_orders';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'price',
        'user_id',
        'orgin_price',
        'no_discount_price',
        'use_user_money',
        'user_level_money',
        'coupon_id',
        'coupon_price',
        'account',
        'shop_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'float',
        'user_id' => 'integer',
        'orgin_price' => 'float',
        'no_discount_price' => 'float',
        'use_user_money' => 'float',
        'user_level_money' => 'float',
        'coupon_id' => 'integer',
        'coupon_price' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
