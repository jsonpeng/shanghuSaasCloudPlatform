<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Category
 * @package App\Models
 * @version October 17, 2017, 4:39 pm CST
 *
 * @property string name
 * @property string slug
 * @property integer sort
 * @property integer parent_id
 * @property string image
 */
class Articlecats extends Model
{
    use SoftDeletes;

    public $table = 'articlecats';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'slug',
        'sort',
        // 'parent_id',
        'image',
        'account',
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
        'sort' => 'integer',
        // 'parent_id' => 'integer',
        'image' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required'
    ];

    public function getParentAttribute()
    {
        if ($this->parent_id == 0) {
            return '';
        } else {
            $cat = Articlecats::find($this->parent_id);
            if (is_null($cat)) {
                return '';
            } else {
                return $cat->name;
            }
        }
    }

    //分类下的文章
    public function posts(){
        return $this->belongsToMany('App\Models\Post', 'articlecats_post', 'category_id', 'post_id');
    }
}
