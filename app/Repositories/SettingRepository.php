<?php

namespace App\Repositories;

use App\Models\Setting;
use InfyOm\Generator\Common\BaseRepository;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class SettingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'logo',
        'freight',
        'mianyou',
        'mianyou_list',
        'agreen',
        'qq',
        'weixin',
        'intro',
        'contact'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Setting::class;
    }




    /**
     * [获取对应的配置信息]
     * @param  [type]  $key  [description]
     * @param  [type]  $zcjy [不传或者null 读当前登录账户的account 传true读zcjy的通配]
     * @param  boolean $api  [传的话覆盖上级 直接是对应account的信息]
     * @return [type]        [description]
     */
    public function valueOfKey($key,$zcjy=null,$api=false,$shop_id=null){
        #account账户
        $account = empty($zcjy) ? admin()->account : 'zcjy';
        
        #api请求account
        if($api){
            $account = $api;
        }

        if(empty($shop_id)){
            $shop_id = now_shop_id();
        }

        $setting = Setting::where('name', $key)
                ->where('account',$account)
                ->where('shop_id',$shop_id)
                ->first();

        if (empty($setting)) {
            $setting = Setting::create(['name' => $key, 'value' => '', 'group' => '', 'des' => '','account'=>$account,'shop_id'=>$shop_id]);
        }
        return $setting->value;
    }


    public function valueOfKeyCached($key){
        return Cache::remember('setting_value_of_key'.$key, Config::get('web.cachetime'), function() use($key){
            return $this->valueOfKey($key);
        });
    }

    public function settingByKey($key,$shop_id=null){
        if(empty($shop_id)){
            $shop_id = now_shop_id();
        }
        $setting = Setting::where('name', $key)
            ->where('account',admin()->account)
            ->where('shop_id',$shop_id)
            ->first();
        if (empty($setting)) {
            $setting = Setting::create(['name' => $key, 'value' => '', 'group' => '', 'des' => '','account'=>admin()->account]);
        }
        return $setting;
    }

    public function settingByKeyCached($key){
        return Cache::remember('setting_value_of_key'.$key, Config::get('web.cachetime'), function() use($key){
            return $this->valueOfKey($key);
        });
    }

    /**
     * 获取功能开关列表
     */
     public function getFuncList($account=null){
           return Cache::remember('setting_function_switch_'.$account, Config::get('web.cachetime'), function() use($account){

                return Setting::where('account',$account)->where('name','like','%FUNC_%')->get();

           });
     }

     /**
      *系统固定的配置数据 
      */
     public function getSystemSettingFunc(){
       return Cache::remember('setting_function_system_switch', Config::get('web.cachetime'), function(){
                        $data=[];
                        $func=Config::get('web');
                        foreach ($func as $key => $value) {
                            if(strpos($key,'FUNC_')!==false){
                                $data[$key]=funcOpen($key);
                            } 
                        }
                       return ['status_code'=>0,'data'=> $data];
            });
       }

     /**
      * 一次获取所有配置
      */
    public function getAllFunc(){
           return Cache::remember('setting_function_all_func_set', Config::get('web.cachetime'), function(){
                return Setting::all();
           });
     }
}
