<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CouponUser
 * @package App\Models
 * @version January 18, 2018, 10:06 am UTC
 *
 * @property integer user_id
 * @property integer coupon_id
 * @property integer coupon_type
 * @property integer order_id
 * @property string from_way
 * @property string use_time
 * @property string code
 * @property integer status
 */
class CouponUser extends Model
{
    //use SoftDeletes;

    public $table = 'coupon_users';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'coupon_id',
        'coupon_type',
        'order_id',
        'from_way',
        'use_time',
        'time_begin',
        'time_end',
        'code',
        'status',
        'shop_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'coupon_id' => 'integer',
        'coupon_type' => 'integer',
        'order_id' => 'integer',
        'from_way' => 'string',
        'use_time' => 'string',
        'code' => 'string',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
    ];

    //规格关联的产品
    public function coupon(){
        return $this->belongsTo('App\Models\Coupon');
    }
}
