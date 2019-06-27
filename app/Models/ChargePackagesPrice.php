<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ChargePackagesPrice
 * @package App\Models
 * @version June 22, 2018, 2:57 pm CST
 *
 * @property integer package_id
 * @property float years
 * @property float price
 */
class ChargePackagesPrice extends Model
{
    use SoftDeletes;

    public $table = 'charge_packages_prices';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'package_id',
        'years',
        'price',
        'origin_price',
        'bonus_one',
        'bonus_two'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'package_id' => 'integer',
        'years' => 'float',
        'price' => 'float'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
