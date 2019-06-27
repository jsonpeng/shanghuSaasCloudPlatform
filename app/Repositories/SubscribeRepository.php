<?php

namespace App\Repositories;

use App\Models\Subscribe;
use App\Models\StoreShop;

use InfyOm\Generator\Common\BaseRepository;
use Carbon\Carbon;

/**
 * Class SubscribeRepository
 * @package App\Repositories
 * @version May 17, 2018, 9:22 am CST
 *
 * @method Subscribe findWithoutFail($id, $columns = ['*'])
 * @method Subscribe find($id, $columns = ['*'])
 * @method Subscribe first($columns = ['*'])
*/
class SubscribeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'subman',
        'mobile',
        'remark',
        'user_id',
        'shop_id',
        'service_id',
        'arrive_time',
        'technician_id',
        'account'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Subscribe::class;
    }

    /**
     * [今日预约列表]
     * @param  [type] $account [description]
     * @param  [type] $shop_id [description]
     * @return [type]          [description]
     */
    public function todaySubscribeList($account,$shop_id=null){
        if(empty($shop_id)){
            $shop_id = now_shop_id();
        }
        return Subscribe::where('account',$account)
        ->where('shop_id',$shop_id)
        ->whereBetween('arrive_time', [Carbon::today(), Carbon::tomorrow()])
        ->get();
    }

    
    /**
     * [统计用户的预约次数和带来的成长值]
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    public function countSubTimesAndGrowth($user){
        $shops =  account(StoreShop::class,$user->account)->get();
        $growth_sub = 0;
        $times_sub = 0;
        //统计用户在各个分店的预约次数
        foreach ($shops as $key => $shop) {
            #这个店的成长值方式
            $count_type = empty(getSettingValueByKey('growth_type',null,$user->account,$shop->id));
            #预约次数 计算方式 默认是一次一点成长值
            $sub_times_unit = empty(getSettingValueByKey('subscribe_get_growth',null,$user->account,$shop->id)) ? 1 : getSettingValueByKey('subscribe_get_growth',null,$user->account,$shop->id);
            #用户在这个店的成长值
            $subs = $count_type  
            ? Subscribe::where('shop_id',$shop->id)->where('user_id',$user->id)
            : Subscribe::where('shop_id',$shop->id)->where('user_id',$user->id)
            ->whereBetween('created_at',[Carbon::now()->subYear(),Carbon::now()]);
            $times_sub += $subs->where('status','已完成')->count();
            $growth_sub += $times_sub * $sub_times_unit;
        }
  
        return ['times'=>$times_sub,'growth'=>$growth_sub];
    }

    /**
     * [清理过期的预约 并且给用户和商户提示]
     * @return [type] [description]
     */
    public function clearExpiredSub(){
        $subs = Subscribe::where('arrive_time','<',Carbon::now())
                ->where('status','待分配')
                ->orWhere('status','待服务')
                ->get();
        foreach ($subs as $key => $sub) {
            #更新对应的预约
            $sub->update([
            'status'=>'已超时'
            ]);
            #给商户和用户推送提示
        }
    }

}
