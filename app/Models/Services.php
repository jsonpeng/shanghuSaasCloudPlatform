<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Services
 * @package App\Models
 * @version May 4, 2018, 5:29 pm CST
 *
 * @property string name
 * @property string intro
 * @property tinyInteger time_type
 * @property integer expire_days
 * @property date time_begin
 * @property date time_end
 * @property float commission
 */
class Services extends Model
{
    use SoftDeletes;

    public $table = 'services';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'intro',
        'time_type',
        'expire_days',
        'time_begin',
        'time_end',
        'commission',
        'image',
        'account',
        'shop_id',
        'all_use'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'intro' => 'string',
        'expire_days' => 'integer',
        'time_begin' => 'date',
        'time_end' => 'date',
        'commission' => 'float',
        'account'  => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'commission'=> 'required'
    ];

    public function getTypeAttribute(){
        return empty($this->time_type) ? '固定有效日期' : '固定多少天后('.$this->expire_days.')' ;
    }

    //适用于的店铺
    public function shops(){
        return $this->belongsToMany('App\Models\StoreShop' , 'services_shops' , 'service_id' , 'shop_id');
    }

    /**
     * 服务技师
     */
    public function technicians(){
        return $this->belongsToMany('App\Models\Technician','services_technicians','service_id','technicians_id');
    }

    //适用店铺前端显示
    public function getShopsHtmlAttribute(){
        $shops = $this->shops()->get();
        $shop_html = '';
        if(count($shops)){
            foreach ($shops as $k => $v) {
                $shop_html .= '<a target="_blank" href='.route('storeShops.edit',$v->id).'>'.$v->name.'</a>&nbsp;&nbsp;';
            }
        }
        return $shop_html;
    }

    /**
     * 购买过改服务的用户列表
     * @return [type] [description]
     */
    public function users(){

        return $this->belongsToMany('App\User', 'services_users','service_id','user_id');
    
    }
    
}   
