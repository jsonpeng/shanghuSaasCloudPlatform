<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductPromp
 * @package App\Models
 * @version January 19, 2018, 3:05 am UTC
 *
 * @property string name
 * @property integer type
 * @property float value
 * @property string time_begin
 * @property string time_end
 * @property string image
 * @property longtext intro
 */
class ProductPromp extends Model
{
    use SoftDeletes;

    public $table = 'product_promps';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'type',
        'value',
        'time_begin',
        'time_end',
        'image',
        'intro',
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
        'type' => 'integer',
        'value' => 'float',
        'time_begin' => 'string',
        'time_end' => 'string',
        'image' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'type' => 'required',
        'value' => 'required',
        'time_begin' => 'required',
        'time_end' => 'required',
        'image' => 'required'
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
            case 2:
                $name = '固定金额出售';
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
