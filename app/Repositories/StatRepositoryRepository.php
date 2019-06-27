<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

use App\Entities\StatRepository;
use App\Validators\StatRepositoryValidator;

use App\Models\Item;
use App\Models\Order;
use App\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * Class StatRepositoryRepositoryEloquent
 * @package namespace App\Repositories;
 */
class StatRepositoryRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return StatRepository::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * 销量统计
     * @return [type] [description]
     */
    
    public function rangeItemStats($time_begin, $time_end)
    {
        return Item::whereBetween('created_at', array($time_begin, $time_end))->select('name', 'unit', DB::raw('SUM(count) as total_sales'), DB::raw('SUM(price) as total_prices'))->groupBy('name', 'unit')->get();
    }


    /**
     * 所有店铺/单个店子的 营业额成本统计
     */
    public function rangeSaleStats($time_begin, $time_end,$shop_id=null)
    {
        //订单
        if(empty($shop_id)){
        $order_sale = Order::whereBetween('created_at', array($time_begin, $time_end))
            ->select(DB::raw('SUM(price) as total_sales'), DB::raw('SUM(cost) as total_costs'), DB::raw('COUNT(id) as total_orders'))
            ->first();
        Log::info($order_sale);
        //充值
        $topup_sale = app('commonRepo')->topupLogRepo()->model()::whereBetween('created_at', array($time_begin, $time_end))
            ->select(DB::raw('SUM(price) as total_topup_sales'), DB::raw('COUNT(id) as total_topups_times'))
            ->first();
        Log::info($topup_sale);
        //优惠买单
        $discount_order_sale = app('commonRepo')->topupLogRepo()->model()::whereBetween('created_at', array($time_begin, $time_end))
            ->select(DB::raw('SUM(price) as total_discount_order_sales'), DB::raw('COUNT(id) as total_discount_order_times'))
            ->first();
        Log::info($discount_order_sale);
        }
        else{
        $order_sale = Order::whereBetween('created_at', array($time_begin, $time_end))
            ->where('shop_id',$shop_id)
            ->select(DB::raw('SUM(price) as total_sales'), DB::raw('SUM(cost) as total_costs'), DB::raw('COUNT(id) as total_orders'))
            ->first();
        //充值
        $topup_sale = app('commonRepo')->topupLogRepo()->model()::whereBetween('created_at', array($time_begin, $time_end))
        ->where('shop_id',$shop_id)
            ->select(DB::raw('SUM(price) as total_topup_sales'), DB::raw('COUNT(id) as total_topups_times'))
            ->first();
        //优惠买单
        $discount_order_sale = app('commonRepo')->topupLogRepo()->model()::whereBetween('created_at', array($time_begin, $time_end))
            ->where('shop_id',$shop_id)
            ->select(DB::raw('SUM(price) as total_discount_order_sales'), DB::raw('COUNT(id) as total_discount_order_times'))
            ->first();
        }
        //总共的
        return (object)[
            //营业额
            'total_sales' => $order_sale->total_sales + $topup_sale->total_topup_sales + $discount_order_sale->total_discount_order_sales,
            //成本
            'total_costs' => $order_sale->total_costs,
            //订单数
            'total_orders' => $order_sale->total_orders,
            //充值金额
            'total_topup_sales' => $topup_sale->total_topup_sales,
            //充值次数
            'total_topups_times' => $topup_sale->total_topups_times,
            //优惠买单金额
            'total_discount_order_sales'=>$discount_order_sale->total_discount_order_sales,
            //优惠买单次数
            'total_discount_order_times'=>$discount_order_sale->total_discount_order_times
        ];
    }

    // public function todaySaleStats()
    // {
    //     return Order::whereBetween('created_at', array(Carbon::today(), Carbon::tomorrow()))
    //         ->select(DB::raw('SUM(price) as total_sales'), DB::raw('SUM(cost) as total_costs'), DB::raw('COUNT(id) as total_orders'))
    //         ->first();
    // }

    // public function thisWeekSaleStats()
    // {
    //     return Order::where('created_at', '>', Carbon::today()->startOfWeek())->select(DB::raw('SUM(price) as total_sales'), DB::raw('SUM(cost) as total_costs'), DB::raw('COUNT(id) as total_orders'))->first();
    // }

    // public function thisMonthSaleStats()
    // {
    //     return Order::where('created_at', '>', Carbon::today()->startOfMonth())->select(DB::raw('SUM(price) as total_sales'), DB::raw('SUM(cost) as total_costs'), DB::raw('COUNT(id) as total_orders'))->first();
    // }


    /**
     * 新增用户数
     */
    
    public function rangeUserStats($time_begin, $time_end)
    {
        return User::whereBetween('created_at', array($time_begin, $time_end))->select(DB::raw('Count(id) as total'))->first();
    }
    // public function todayUserStats()
    // {
    //     return User::whereBetween('created_at', array(Carbon::today(), Carbon::tomorrow()))->select(DB::raw('Count(id) as total'))->first();
    // }

    // public function thisWeekUserStats()
    // {
    //     return User::where('created_at', '>', Carbon::today()->startOfWeek())->select(DB::raw('Count(id) as total'))->first();
    // } 

    // public function thisMonthUserStats()
    // {
    //     return User::where('created_at', '>', Carbon::today()->startOfMonth())->select(DB::raw('Count(id) as total'))->first();
    // }

    /**
     * 时间段统计
     */
    public function ItemStats($timerange)
    {
        $dateArr = explode(" - ", $timerange);
        $startDate = Carbon::createFromFormat('Y-m-d', $dateArr[0])->setTime(0, 0, 0);
        $endDate = Carbon::createFromFormat('Y-m-d', $dateArr[1])->addDay()->setTime(0, 0, 0);
        return Item::whereBetween('created_at', array( $startDate, $endDate))->select('name', 'unit', DB::raw('SUM(count) as total_sales'), DB::raw('Date(created_at)'))->groupBy('name', 'unit', DB::raw('Date(created_at)'))->orderBy('created_at')->get();

    }
    public function OrderStats($timerange)
    {
        $dateArr = explode(" - ", $timerange);
        $startDate = Carbon::createFromFormat('Y-m-d', $dateArr[0])->setTime(0, 0, 0);
        $endDate = Carbon::createFromFormat('Y-m-d', $dateArr[1])->addDay()->setTime(0, 0, 0);
        return Order::with('canteen')
                    ->whereBetween('created_at', array( $startDate, $endDate))
                    ->get();
    }
    public function UserStats($timerange)
    {
        $dateArr = explode(" - ", $timerange);
        $startDate = Carbon::createFromFormat('Y-m-d', $dateArr[0])->setTime(0, 0, 0);
        $endDate = Carbon::createFromFormat('Y-m-d', $dateArr[1])->addDay()->setTime(0, 0, 0);
        return User::whereBetween('created_at', array( $startDate, $endDate))->groupBy(DB::raw('Date(created_at)'))->select(DB::raw('COUNT(ID) as total_users'), DB::raw('Date(created_at)'))->get();
    }
}
