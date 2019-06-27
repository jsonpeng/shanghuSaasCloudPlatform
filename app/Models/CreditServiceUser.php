<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CreditServiceUser
 * @package App\Models
 * @version May 31, 2018, 4:40 pm CST
 *
 * @property integer credit_service_id
 * @property integer service_id
 * @property string snumber
 * @property integer user_id
 * @property string status
 * @property string pick_time
 * @property integer pick_shop_id
 */
class CreditServiceUser extends Model
{
    use SoftDeletes;

    public $table = 'credit_service_users';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'snumber',
        'credit_service_id',
        'user_id',
        'status',
        'pick_time',
        'pick_shop_id',
        'account'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'credit_service_id' => 'integer',
        'snumber' => 'string',
        'user_id' => 'integer',
        'status' => 'string',
        'pick_time' => 'string',
        'pick_shop_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    //积分产品
    public function creditservice(){
        return $this->belongsTo('App\Models\CreditsService','credit_service_id','id');
    }

    //积分兑换用户
    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
    
}
