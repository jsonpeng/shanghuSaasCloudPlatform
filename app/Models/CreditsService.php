<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CreditsService
 * @package App\Models
 * @version May 31, 2018, 9:18 am CST
 *
 * @property string name
 * @property string image
 * @property string content
 * @property string type
 * @property integer service_id
 * @property integer need_num
 * @property integer count_time
 */
class CreditsService extends Model
{
    use SoftDeletes;

    public $table = 'credits_services';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'image',
        'content',
        'type',
        'service_id',
        'need_num',
        'count_time',
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
        'image' => 'string',
        'content' => 'string',
        'type' => 'string',
        'service_id' => 'integer',
        'need_num' => 'integer',
        'count_time' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'type' => 'required',
        'need_num' => 'required'
    ];

    //服务
    public function service(){
        return $this->belongsTo('App\Models\Services','service_id','id');
    }

    
}
