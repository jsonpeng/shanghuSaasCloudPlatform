<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TopupLog
 * @package App\Models
 * @version June 6, 2018, 3:01 pm CST
 *
 * @property float price
 * @property integer topup_id
 * @property integer user_id
 */
class TopupLog extends Model
{
    use SoftDeletes;

    public $table = 'topup_logs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'price',
        'topup_id',
        'user_id',
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
        'topup_id' => 'integer',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function topup(){
        return $this->belongsTo('App\Models\TopupGifts','topup_id','id');
    }
    
}
