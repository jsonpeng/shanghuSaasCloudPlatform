<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MoneyLog
 * @package App\Models
 * @version February 6, 2018, 5:57 pm CST
 *
 * @property float amount
 * @property float change
 * @property string detail
 * @property integer user_id
 */
class MoneyLog extends Model
{
    use SoftDeletes;

    public $table = 'money_logs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'amount',
        'change',
        'detail',
        'user_id',
        'type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'float',
        'change' => 'float',
        'detail' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
