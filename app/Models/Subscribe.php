<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

/**
 * Class Subscribe
 * @package App\Models
 * @version May 17, 2018, 9:22 am CST
 *
 * @property string subman
 * @property string mobile
 * @property string remark
 * @property integer user_id
 * @property integer shop_id
 * @property integer service_id
 * @property date arrive_time
 * @property integer technician_id
 */
class Subscribe extends Model
{
    use SoftDeletes;

    public $table = 'subscribes';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'subman',
        'mobile',
        'remark',
        'user_id',
        'shop_id',
        'service_id',
        'arrive_time',
        'technician_id',
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
        'subman' => 'string',
        'mobile' => 'string',
        'remark' => 'string',
        'user_id' => 'integer',
        'shop_id' => 'integer',
        'service_id' => 'integer',
        'technician_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'subman' => 'required',
        'mobile' => 'required',
        'shop_id' => 'required',
        'service_id' => 'required',
        'arrive_time' => 'required',
        'technician_id' => 'required'
    ];

    //预约门店
    public function shop(){
        return $this->belongsTo('App\Models\StoreShop','shop_id','id');
    }

    //预约服务
    public function service(){
        return $this->belongsTo('App\Models\Services','service_id','id');
    }

     //预约门店
    public function technician(){
        return $this->belongsTo('App\Models\Technician','technician_id','id');
    }

    //预约时间序列化为 时分
    public function getArriveTimeFormatHsAttribute(){
        return Carbon::parse($this->arrive_time)->format('h:m');
    }
    
}
