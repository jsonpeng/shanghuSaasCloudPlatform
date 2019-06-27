<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TeamSale
 * @package App\Models
 * @version January 21, 2018, 6:53 pm CST
 *
 * @property string name
 * @property integer type
 * @property integer expire_hour
 * @property float price
 * @property integer member
 * @property string product_name
 * @property string product_id
 * @property _id spec
 * @property float bonus
 * @property integer lottery_count
 * @property integer buy_limit
 * @property integer sales_sum
 * @property integer sort
 * @property string share_title
 * @property string share_des
 * @property string share_img
 */
class TeamSale extends Model
{
    use SoftDeletes;

    public $table = 'team_sales';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'time_begin',
        'time_end',
        'price',
        'member',
        'product_name',
        'product_id',
        'bonus',
        //'lottery_count',
        'buy_limit',
        'sales_sum',
        'sales_sum_base',
        'sort',
        'share_title',
        'share_des',
        'share_img',
        'shelf',
        'origin_price',
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
        'type' => 'integer',
        'expire_hour' => 'integer',
        'price' => 'float',
        'member' => 'integer',
        'product_name' => 'string',
        'product_id' => 'string',
        'spec_id'=>'integer',
        'bonus' => 'float',
        'lottery_count' => 'integer',
        'buy_limit' => 'integer',
        'sales_sum' => 'integer',
        'sort' => 'integer',
        'share_title' => 'string',
        'share_des' => 'string',
        'share_img' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        // 'type' => 'required',
        // 'expire_hour' => 'required',
        'price' => 'required',
        'member' => 'required',
        'buy_limit' => 'required'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    // public function spec()
    // {
    //     return $this->belongsTo('App\Models\SpecProductPrice');
    // }

    public function getSaleTypeAttribute()
    {
        switch ($this->type) {
            case 0:
                return '分享团';
                break;
            case 1:
                return '佣金团';
                break;
            case 1:
                return '抽奖团';
                break;
            default:
                return '分享团';
                break;
        }
    }
}
