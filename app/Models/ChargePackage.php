<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ChargePackage
 * @package App\Models
 * @version May 2, 2018, 4:48 pm CST
 *
 * @property string name
 * @property string type
 * @property float money
 * @property integer days
 * @property integer bonus
 */
class ChargePackage extends Model
{
    use SoftDeletes;

    public $table = 'charge_packages';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'level',
        'canuse_shop_num',
        'image',
        'exclusive'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'canuse_shop_num'=>'required',
    ];

    //套餐关联的文字条目
    public function words(){
        return $this->belongsToMany('App\Models\Word','package_word','package_id','word_id');
    }

    //套餐的组合金额
    public function prices(){
        return $this->hasMany('App\Models\ChargePackagesPrice','package_id','id');
    }

    
}
