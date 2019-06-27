<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductImage
 * @package App\Models
 * @version July 25, 2017, 8:07 pm CST
 */
class Word extends Model
{
    use SoftDeletes;

    public $table = 'word';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'intro'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name'=>'string',
        'intro'=>'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    //文字条目关联的套餐
    public function packages(){
        return $this->belongsToMany('App\Models\ChargePackage','package_word','word_id','package_id');
    }

    
}
