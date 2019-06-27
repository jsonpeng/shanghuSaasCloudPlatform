<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductImage
 * @package App\Models
 * @version July 25, 2017, 8:07 pm CST
 */
class ProductImage extends Model
{
    use SoftDeletes;

    public $table = 'product_images';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'url',
        'product_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'url' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    //图片关联的产品
    public function product(){
        return $this->belongsTo('App\Models\Product');
    }

    
}
