<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AdminPackage
 * @package App\Models
 * @version June 8, 2018, 9:06 am CST
 *
 * @property integer admin_id
 * @property string package_endtime
 * @property string package_name
 */
class AdminPackage extends Model
{
    use SoftDeletes;

    public $table = 'admin_packages';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'admin_id',
        'package_endtime',
        'package_name',
        'level',
        'canuse_shop_num',
        'price'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'admin_id' => 'integer',
        'package_endtime' => 'string',
        'package_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
