<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Notice
 * @package App\Models
 * @version April 12, 2018, 10:40 am CST
 *
 * @property string name
 * @property longtext content
 */
class Notice extends Model
{
    use SoftDeletes;

    public $table = 'notices';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'content',
        'account',
        'shop_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'content' => 'required'
    ];

    
}
