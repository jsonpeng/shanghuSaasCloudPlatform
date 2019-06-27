<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CreditLog
 * @package App\Models
 * @version February 6, 2018, 5:53 pm CST
 *
 * @property string time
 * @property integer amount
 * @property integer change
 * @property string detail
 * @property integer user_id
 */
class CreditLog extends Model
{
    use SoftDeletes;

    public $table = 'credit_logs';
    

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
        'amount' => 'integer',
        'change' => 'integer',
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
