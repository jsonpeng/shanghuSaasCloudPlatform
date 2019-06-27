<?php

namespace App\Repositories;

use App\Models\TopupLog;
use App\Models\StoreShop;

use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TopupLogRepository
 * @package App\Repositories
 * @version June 6, 2018, 3:01 pm CST
 *
 * @method TopupLog findWithoutFail($id, $columns = ['*'])
 * @method TopupLog find($id, $columns = ['*'])
 * @method TopupLog first($columns = ['*'])
*/
class TopupLogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'price',
        'topup_id',
        'user_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return TopupLog::class;
    }

    /**
     * [统计用户单个店子的金额/次数和成长值]
     * @param  [type] $user [description]
     * @param  [type] $shop [description]
     * @return [type]       [description]
     */
    public function countUserSingleShopPriceAndGrowth($user,$shop_id,$key=null,$type='price',$model='default'){
            $growth_item = 0;
            $price_item = 0;
            if(!empty(StoreShop::find($shop_id))){
                #这个店的成长值方式
                $count_type = empty(getSettingValueByKey('growth_type',null,$user->account,$shop_id));
                #金额 计算方式 是 1元 多少点 默认是一元一点
                $item_price_unit = empty(getSettingValueByKey('recharge_get_growth',null,$user->account,$shop_id)) ? 1 : getSettingValueByKey('recharge_get_growth',null,$user->account,$shop_id);
                $items  = defaultSearchState($this->model());
                $items  =  $count_type 
                        ? $items 
                        : $items 
                        ->whereBetween('created_at',[Carbon::now()->subYear(),Carbon::now()]);
                $user_items_price = $items
                    ->where('shop_id',$shop_id)
                    ->where('user_id',$user->id)
                    ->get()
                    ->sum('price');
                $price_item = $user_items_price;
                #用户在这个店的成长值
                $growth_item =  $user_items_price * $item_price_unit;
            }
            return ['growth'=>$growth_item,'price'=>$price_item];
    }

    /**
     * [计算用户订单的金额和成长值]
     * @param  [type] $user [description]
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function countUserAllPriceAndGrowth($user){
        $shops =  account(StoreShop::class,$user->account)->get();
        $growth_item = 0;
        $price_item = 0;
        if(count($shops)){
            #分店 分批统计订单成长值
            foreach ($shops as $key => $shop) {
                $growth_item += $this->countUserSingleShopPriceAndGrowth($user,$shop->id)['growth'];
                $price_item += $this->countUserSingleShopPriceAndGrowth($user,$shop->id)['price'];
            }
        }
        return ['growth'=>$growth_item,'price'=>$price_item];
    }
}
