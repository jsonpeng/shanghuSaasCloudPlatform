<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TopupGifts
 * @package App\Models
 * @version June 6, 2018, 11:02 am CST
 *
 * @property float price
 * @property float give_balance
 * @property integer give_credits
 * @property integer coupon_id
 */
class TopupGifts extends Model
{
    use SoftDeletes;

    public $table = 'topup_gifts';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'price',
        'give_balance',
        'give_credits',
        'coupon_id',
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
        'give_balance' => 'float',
        'give_credits' => 'integer',
        'coupon_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'price' => 'required'
    ];

    public function coupon(){
        return $this->belongsTo('App\Models\Coupon','coupon_id','id');
    }
    
}
