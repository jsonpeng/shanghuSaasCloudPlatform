<?php

namespace App\Repositories;

use App\Models\CreditsService;
use InfyOm\Generator\Common\BaseRepository;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

/**
 * Class CreditsServiceRepository
 * @package App\Repositories
 * @version May 31, 2018, 9:18 am CST
 *
 * @method CreditsService findWithoutFail($id, $columns = ['*'])
 * @method CreditsService find($id, $columns = ['*'])
 * @method CreditsService first($columns = ['*'])
*/
class CreditsServiceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image',
        'content',
        'type',
        'service_id',
        'need_num',
        'count_time'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CreditsService::class;
    }


    /**
     * [根据account信息获取对应积分产品列表]
     * @param  [type] $shop_id [description]
     * @param  [type] $skip    [description]
     * @param  [type] $take    [description]
     * @return [type]          [description]
     */
    public function creditsShopListByAccount($shop_id,$skip=0,$take=18){
        return Cache::remember('zcjy_credits_shop_list'.$shop_id.$skip.$take, Config::get('web.cachetime'), function() use ($shop_id,$skip,$take) {
            try {
                $CreditsServices = CreditsService::where('shop_id',$shop_id)->skip($skip)->take($take)->get();
                #附加服务信息
                foreach ($CreditsServices as $key => $val) {
                    $val['service'] = null;
                    if(!empty($val->service_id)){
                        $val['service'] = $val->service()->first();
                    }
                }
                return $CreditsServices;
            } catch (Exception $e) {
                return null;
            }
        });
    }

    /**
     * [根据id获取积分产品详情]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function creditsShopDetail($id){
        return Cache::remember('zcjy_credits_shop_detail'.$id, Config::get('web.cachetime'), function() use ($id) {
            try {
                return $this->findWithoutFail($id);
            } catch (Exception $e) {
                return null;
            }
        });
    }
}
