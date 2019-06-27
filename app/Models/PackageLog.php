<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PackageLog
 * @package App\Models
 * @version June 21, 2018, 10:29 am CST
 *
 * @property string package_name
 * @property float price
 * @property integer admin_id
 * @property string type
 */
class PackageLog extends Model
{
    use SoftDeletes;

    public $table = 'package_logs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'package_name',
        'price',
        'admin_id',
        'type',
        'bonus_one',
        'bonus_two',
        'distribution_one',
        'distribution_two',
        'status',
        'years',
        'pay_price'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'package_name' => 'string',
        'price' => 'float',
        'admin_id' => 'integer',
        'type' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function admin(){
        return $this->belongsTo('App\Models\Admin');
    }

    
}
