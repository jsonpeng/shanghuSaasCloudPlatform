<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class DistributionLog
 * @package App\Models
 * @version January 17, 2018, 1:48 am UTC
 *
 * @property integer order_user_id
 * @property integer user_id
 * @property integer order_id
 * @property float commission
 * @property float order_money
 * @property integer user_dis_level
 * @property string status
 */
class DistributionLog extends Model
{
    use SoftDeletes;

    public $table = 'distribution_logs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'order_user_id',
        'user_id',
        'order_id',
        'commission',
        'order_money',
        'user_dis_level',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'order_user_id' => 'integer',
        'user_id' => 'integer',
        'order_id' => 'integer',
        'commission' => 'float',
        'order_money' => 'float',
        'user_dis_level' => 'integer',
        'status' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
