<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FlashSale
 * @package App\Models
 * @version January 21, 2018, 4:46 pm CST
 *
 * @property string name
 * @property integer product_id
 * @property integer spec_id
 * @property float price
 * @property integer product_num
 * @property integer buy_limit
 * @property integer buy_num
 * @property integer order_num
 * @property longtext intro
 * @property string time_begin
 * @property string time_end
 * @property integer is_end
 * @property string product_name
 */
class FlashSale extends Model
{
    use SoftDeletes;

    public $table = 'flash_sales';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        // 'name',
        'product_id',
        'spec_id',
        'price',
        'product_num',
        'buy_limit',
        'buy_num',
        'order_num',
        'intro',
        'time_begin',
        'time_end',
        'is_end',
        'product_name',
        'origin_price',
        'image',
        'account',
        'shop_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'name' => 'string',
        'product_id' => 'integer',
        'spec_id' => 'integer',
        'price' => 'float',
        'product_num' => 'integer',
        'buy_limit' => 'integer',
        'buy_num' => 'integer',
        'order_num' => 'integer',
        'time_begin' => 'string',
        'time_end' => 'string',
        'is_end' => 'integer',
        'product_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        //'name' => 'required',
        'price' => 'required',
        'product_num' => 'required',
        'buy_limit' => 'required',
        'time_begin' => 'required',
        'time_end' => 'required'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    // public function spec()
    // {
    //     return $this->belongsTo('App\Models\SpecProductPrice');
    // }

    public function getStatusAttribute()
    {
        $cur = \Carbon\Carbon::now();
        $time_begin = \Carbon\Carbon::parse($this->time_begin);
        $time_end = \Carbon\Carbon::parse($this->time_end);
        if ($cur->between($time_begin, $time_end)) {
            return '进行中';
        }
        if ($cur->lt($time_begin)) {
            return '未开始';
        }
        if ($cur->gt($time_end)) {
            return '已结束';
        }
    }
}
