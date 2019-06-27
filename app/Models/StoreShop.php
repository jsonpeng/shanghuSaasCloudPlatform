<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class StoreShop
 * @package App\Models
 * @version May 4, 2018, 4:34 pm CST
 *
 * @property string name
 * @property string address
 * @property float jindu
 * @property float weidu
 * @property string tel
 * @property string logo
 */
class StoreShop extends Model
{
    use SoftDeletes;

    public $table = 'store_shops';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'address',
        'jindu',
        'weidu',
        'tel',
        'logo',
        'contact_man',
        'weixin',
        'account'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'address' => 'string',
        'jindu' => 'float',
        'weidu' => 'float',
        'tel' => 'string',
        'logo' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'address' => 'required',
        'tel' => 'required'
    ];

    //店铺下的服务
    public function serivices(){
        return $this->hasMany('App\Models\Services');
    }
    
}
