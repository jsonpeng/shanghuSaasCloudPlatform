<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TeamLottery
 * @package App\Models
 * @version January 21, 2018, 10:58 pm CST
 *
 * @property integer user_id
 * @property integer order_id
 * @property string mobile
 * @property string team_id
 * @property string nickname
 * @property string head_pic
 */
class TeamLottery extends Model
{
    use SoftDeletes;

    public $table = 'team_lotteries';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'order_id',
        'mobile',
        'team_id',
        'nickname',
        'head_pic'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'order_id' => 'integer',
        'mobile' => 'string',
        'team_id' => 'string',
        'nickname' => 'string',
        'head_pic' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
