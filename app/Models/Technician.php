<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Technician
 * @package App\Models
 * @version May 8, 2018, 10:52 am CST
 *
 * @property string name
 * @property string image
 * @property string intro
 * @property integer work_day
 */
class Technician extends Model
{
    use SoftDeletes;

    public $table = 'technicians';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'image',
        'intro',
        'workday',
        'job',
        'sentiment',
        'give_like',
        'forward',
        'mobile',
        'weixin',
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
        'intro' => 'string',
        'workday' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'workday' => 'required'
    ];


    /**
     * 工作日
     */
    public function getWorkDaysAttribute(){
        //return $this->workday;
        $work_days = explode(',',$this->workday);
        $work_day_str = '';
        foreach ($work_days as $k => $v) {
             $work_day_str .= technicianWorkDay()[$v].'&nbsp;&nbsp;';
        }
        return $work_day_str;
    }

    /**
     * 关联服务
     */
    public function services(){
        return $this->belongsToMany('App\Models\Services','services_technicians','technicians_id','service_id');
    }

    /**
     * 服务列表
     */
    public function getServicesAttribute(){
        $services_html= '';
        $services = $this->services()->get();
        if(count($services)){
            foreach ($services as $k => $v) {
                $services_html .= $v->name.' ';
            }
        }
        return $services_html;
    }

    
}
