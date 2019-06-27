<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SingelPage
 * @package App\Models
 * @version February 27, 2018, 3:10 pm CST
 *
 * @property string name
 * @property string slug
 * @property string content
 */
class SingelPage extends Model
{
    use SoftDeletes;

    public $table = 'singel_pages';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'slug',
        'content',
        'view'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'slug' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    
}
