<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Item
 * @package App\Models
 * @version June 20, 2017, 4:58 am UTC
 */
class Item extends Model
{
    use SoftDeletes;

    public $table = 'items';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'pic',
        'price',
        'cost',
        'count',
        'unit',
        'order_id',
        'product_id',
        'spec_key',
        'spec_keyname',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'pic' => 'string',
        'price' => 'float',
        'cost' => 'float',
        'count' => 'float',
        'unit' => 'string',
        'order_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function order(){
        return $this->belongsTo('App\Models\Order');
    }

    public function product(){
        return $this->belongsTo('App\Models\Product');
    }
}
