<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PostImage
 * @package App\Models
 */
class PostImage extends Model
{
    use SoftDeletes;

    public $table = 'posts_images';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'url',
        'post_id'
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

    //图片关联的文章
    public function post(){
        return $this->belongsTo('App\Models\Post');
    }

    
}
