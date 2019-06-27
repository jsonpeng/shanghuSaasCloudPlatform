<?php

namespace App\Repositories;

use App\Models\StoreShop;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class StoreShopRepository
 * @package App\Repositories
 * @version May 4, 2018, 4:34 pm CST
 *
 * @method StoreShop findWithoutFail($id, $columns = ['*'])
 * @method StoreShop find($id, $columns = ['*'])
 * @method StoreShop first($columns = ['*'])
*/
class StoreShopRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'address',
        'jindu',
        'weidu',
        'tel',
        'logo'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return StoreShop::class;
    }

    /**
     * 对应账户的店铺
     * @param  [type] $account [description]
     * @return [type]          [description]
     */
    public function allAccountShop($account,$only_shop_id_arr=false){
        $store_shops = StoreShop::where('account',$account);
        if($only_shop_id_arr){
             $store_shops =  $store_shops->select('id')->get()->toArray();
             $store_shops_arr = [];
             foreach ($store_shops as $key => $val) {
                 array_push($store_shops_arr,$val['id']);
             }

             $store_shops = $store_shops_arr;
        }
        else{
             $store_shops = $store_shops->get();
        }
        return $store_shops;
    }

    
    /**
     * [通过店铺列表中两个经纬度[用户的经纬度及店铺的经纬度]获取距离差并且带上参数]
     * @param  [type] $shops          [description]
     * @param  [array] $user_location [description]
     * @return [type]                 [description]
     */
    public function getShopsDistance($shops,$user_location){
        if(array_key_exists('jindu',$user_location) && !empty($user_location['jindu']) && array_key_exists('weidu',$user_location) && !empty($user_location['weidu'])){
            foreach ($shops as $k => $v) {
                $v['distance'] = getDistance($v->jindu,$v->weidu,$user_location['jindu'],$user_location['weidu']);
            }
           $shops['min_distance']=$shops->min('distance');
        }
        return $shops;
    }
    

  /**
   * [通过shopid获取对应shop下的服务]
   * @param  [type]  $shop_id [description]
   * @param  boolean $use_web [description]
   * @return [type]           [description]
   */
    public function getServiceByShopId($shop_id,$use_web=true){
   
        $services = app('commonRepo')->serviceRepo()->model()::where('shop_id',$shop_id)->get();

        return $use_web 
            ? web_result_data_tem($services) 
            : api_result_data_tem($services);
   
    }
    
}
