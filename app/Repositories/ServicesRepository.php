<?php

namespace App\Repositories;

use App\Models\Services;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ServicesRepository
 * @package App\Repositories
 * @version May 4, 2018, 5:29 pm CST
 *
 * @method Services findWithoutFail($id, $columns = ['*'])
 * @method Services find($id, $columns = ['*'])
 * @method Services first($columns = ['*'])
*/
class ServicesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'intro',
        'time_type',
        'expire_days',
        'time_begin',
        'time_end',
        'commission'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Services::class;
    }

    /**
     * [根据服务id获取对应的技师]
     * @param  [type]  $service_id [description]
     * @param  boolean $use_web    [description]
     * @return [type]              [description]
     */
    public function getTechniciansByServicesId($service_id,$use_web=true){
        $serivice = $this->findWithoutFail($service_id);
        if(!empty($serivice)){
            $technicians = $serivice->technicians()->get();
            return $use_web 
            ? web_result_data_tem($technicians) 
            : api_result_data_tem($technicians);
        }
        else{
            return $use_web 
            ? web_result_data_tem('没有该服务',1) 
            : api_result_data_tem('没有该服务',1);
        }
    }

    /**
     * 根据服务集合获取对应的店铺
     */
    public function getShopsByServices($services){
          $shops = [];
          foreach ($services as $key => $value) {
                $shops_list = $value->shops()->get();
                foreach ($shops_list as $key => $shop_item) {
                      array_push($shops,$shop_item);
                }
          }
         //过滤重复的元素
        for ($i=count($shops)-1; $i >=0; $i--) { 
            for($j = $i-1;$j >=0;$j--){
                if($shops[$i]['id'] == $shops[$j]['id']){
                    unset($shops[$i]);
                }
            }
        }
         $shops_arr = [];
         foreach ($shops as $key => $value) {
             array_push($shops_arr,$value);
          }
          return  $shops_arr;
    }

 


}
