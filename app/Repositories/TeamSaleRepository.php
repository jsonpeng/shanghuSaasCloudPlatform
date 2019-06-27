<?php

namespace App\Repositories;

use App\Models\TeamSale;
use InfyOm\Generator\Common\BaseRepository;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

/**
 * Class TeamSaleRepository
 * @package App\Repositories
 * @version January 21, 2018, 6:53 pm CST
 *
 * @method TeamSale findWithoutFail($id, $columns = ['*'])
 * @method TeamSale find($id, $columns = ['*'])
 * @method TeamSale first($columns = ['*'])
*/
class TeamSaleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'type',
        'expire_hour',
        'price',
        'member',
        'product_name',
        'product_id',
        'spec_id',
        'bonus',
        'lottery_count',
        'buy_limit',
        'sales_sum',
        'sort',
        'share_title',
        'share_des',
        'share_img',
        'origin_price'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return TeamSale::class;
    }

    /**
     * 获取拼团活动
     * @param  integer $skip [description]
     * @param  integer $take [description]
     * @return [type]        [description]
     */
    public function getTeamSales($skip = 0, $take = 20)
    {
        return Cache::remember('all_team_sales'.'skip_'.$skip.'take_'.$take, Config::get('web.cachetime'), function() use($skip, $take) {
            return TeamSale::orderBy('sort', 'asc')->where('shelf', 1)->skip($skip)->take($take)->get();
        });
    }

    /**
     * 当商品删除或者变更活动信息时，删除原有的活动信息
     * @param  integer $product_id [description]
     * @param  integer $spec_id    [description]
     * @return [type]              [description]
     */
    public function deleteReplaceProductByProductIdOrSpecId($product_id=0, $spec_id=0){
        if($product_id != 0){
            $TeamSale_pro = TeamSale::where('product_id',$product_id)->count();
            if($TeamSale_pro) {
                TeamSale::where('product_id', $product_id)->delete();
            }
        }

        // if($spec_id != 0){
        //     $TeamSale_spec= TeamSale::where('spec_id',$spec_id)->count();
        //     if($TeamSale_spec) {
        //         TeamSale::where('spec_id', $spec_id)->delete();
        //     }
        // }
    }

    public function teamFounders($product_id)
    {
        //该商品开的团
        $teamSales = TeamSale::where('shelf', 1)->where('product_id', $product_id)->select('id')->get();

        $teams = [];
        foreach ($teamSales as $teamSale) {
            array_push($teams, $teamSale->id);
        }
        $curTime = Carbon::now();
        $teamFounders = \App\Models\TeamFound::whereIn('team_id', $teams)
        ->where('time_begin', '<=', $curTime)
        ->where('time_end', '>=', $curTime)
        ->where('status', 1)
        ->whereRaw('join_num < need_mem')
        ->get();

        return $teamFounders;
    }
}
