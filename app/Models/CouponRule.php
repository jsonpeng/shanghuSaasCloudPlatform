<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CouponRule
 * @package App\Models
 * @version June 22, 2017, 3:56 am UTC
 */
class CouponRule extends Model
{
    use SoftDeletes;

    public $table = 'rules';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'type',
        'base',
        'time_begin',
        'time_end',
        'max_count',
        'count',
        'account'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'type' => 'string',
        'base' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    // 关联的优惠券
    public function coupons(){
        return $this->belongsToMany('App\Models\Coupon', 'coupon_rule', 'rule_id', 'coupon_id');
    }

    public function getTypeNameAttribute()
    {
        $name = '';
        switch ($this->type) {
            case 0:
                $name = '新用户注册';
                break;
            case 1:
                $name = '购物满送';
                break;
            case 2:
                $name = '推荐新用户注册';
                break;
            case 3:
                $name = '推荐新用户下单';
                break;
            case 4:
                $name = '免费领取';
                break;
            default:
                $name = '';
                break;
        }
        return $name;
    }
}