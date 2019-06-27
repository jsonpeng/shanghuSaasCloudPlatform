<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BankSets
 * @package App\Models
 * @version February 2, 2018, 4:44 pm CST
 *
 * @property string name
 * @property string img
 */
class BankSets extends Model
{
    use SoftDeletes;

    public $table = 'bank_sets';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'img'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'img' => 'string'
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
