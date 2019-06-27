<?php

namespace App\Models;

use Eloquent as Model;


/**
 * Class ServicesUser
 * @package App\Models
 * @version May 4, 2018, 5:29 pm CST
 *
 */
class ServicesUser extends Model
{
   

    public $table = 'services_users';
    

    public $fillable = [
        'service_id',
        'user_id',
        'num',
        'time_begin',
        'time_end',
        'status',
        'use_time',
        'use_shop'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'service_id' => 'integer',
        'user_id' => 'integer',
        'num' => 'integer',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
     
    ];

   
    /**
     * 服务用户
     * @return [type] [description]
     */
    public function user(){
        return $this->belongsTo('App\User');
    }
    
    /**
     * 服务用户
     * @return [type] [description]
     */
    public function service(){
        return $this->belongsTo('App\Models\Services');
    }
}   
