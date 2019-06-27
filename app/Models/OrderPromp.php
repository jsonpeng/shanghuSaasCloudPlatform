<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OrderPromp
 * @package App\Models
 * @version January 19, 2018, 3:58 pm CST
 *
 * @property string name
 * @property tinyint type
 * @property float base
 * @property float value
 * @property string time_begin
 * @property string time_end
 * @property longtext intro
 */
class OrderPromp extends Model
{
    use SoftDeletes;

    public $table = 'order_promps';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'type',
        'base',
        'value',
        'time_begin',
        'time_end',
        'intro',
        'shop_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'base' => 'float',
        'value' => 'float',
        'time_begin' => 'string',
        'time_end' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'type' => 'required',
        'base' => 'required',
        'value' => 'required',
        'time_begin' => 'required',
        'time_end' => 'required'
    ];

    public function getTypeNameAttribute()
    {
        $name = '';
        switch ($this->type) {
            case 0:
                $name = '打折优惠';
                break;
            case 1:
                $name = '减价优惠';
                break;
            default:
                $name = '';
                break;
        }
        return $name;
    }


    public function getStatusAttribute()
    {
        $cur = \Carbon\Carbon::now();
        $time_begin = \Carbon\Carbon::parse($this->time_begin);
        $time_end = \Carbon\Carbon::parse($this->time_end)->addDay();
        if ($cur->between($time_begin, $time_end)) {
            return '进行中';
        }
        if ($cur->lt($time_begin)) {
            return '未开始';
        }
        if ($cur->gt($time_end)) {
            return '已结束';
        }
    }
    
}
