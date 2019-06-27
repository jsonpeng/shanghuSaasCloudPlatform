<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TeamFollow
 * @package App\Models
 * @version January 21, 2018, 10:52 pm CST
 *
 * @property integer user_id
 * @property string nickname
 * @property string head_pic
 * @property integer order_id
 * @property integer found_id
 * @property integer found_user_id
 * @property integer team_id
 * @property integer status
 * @property integer is_winner
 */
class TeamFollow extends Model
{
    use SoftDeletes;

    public $table = 'team_follows';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'nickname',
        'head_pic',
        'order_id',
        'found_id',
        'found_user_id',
        'team_id',
        'status',
        'is_winner'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'nickname' => 'string',
        'head_pic' => 'string',
        'order_id' => 'integer',
        'found_id' => 'integer',
        'found_user_id' => 'integer',
        'team_id' => 'integer',
        'status' => 'integer',
        'is_winner' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
