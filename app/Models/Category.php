<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Category
 * @package App\Models
 * @version April 28, 2017, 2:12 am UTC
 */
class Category extends Model
{
    use SoftDeletes;

    public $table = 'categories';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'slug',
        'sort',
        'image',
        'show',
        'account',
        'status',
        'shop_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'slug' => 'string',
        'intro' => 'string',
        'sort' => 'integer',
        'image' => 'string',
        'recommend' => 'string',
        'recommend_title' => 'string',
        'recommend_des' => 'string',
        'parent_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
    ];

    public function getParentAttribute(){
        if ($this->parent_id == 0) {
            return '';
        }
        try {
            return Category::find($this->parent_id)->name;
        } catch (Exception $e) {
            return '';
        }
        
    }

    public function products(){
        return $this->belongsToMany('App\Models\Product', 'category_product', 'category_id', 'product_id');
    }

    public function products_name(){
        return $this->belongsToMany('App\Models\Product', 'category_product', 'category_id', 'product_id')->select(array('products.id', 'name', 'image'));
    }
}
