<?php

namespace App\Repositories;

use App\Models\TeamFound;
use InfyOm\Generator\Common\BaseRepository;
use Carbon\Carbon;

/**
 * Class TeamFoundRepository
 * @package App\Repositories
 * @version January 21, 2018, 8:34 pm CST
 *
 * @method TeamFound findWithoutFail($id, $columns = ['*'])
 * @method TeamFound find($id, $columns = ['*'])
 * @method TeamFound first($columns = ['*'])
*/
class TeamFoundRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'time_begin',
        'time_end',
        'user_id',
        'team_id',
        'nickname',
        'head_pic',
        'order_id',
        'join_num',
        'need_mem',
        'price',
        'origin_price',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return TeamFound::class;
    }

    public function createTeamFound($order_id, $paystatus = false)
    {
        $order = \App\Models\Order::where('id', $order_id)->first();
        if (empty($order)) {
            return null;
        }
        $team = \App\Models\TeamSale::where('id', $order->prom_id)->first();
        if (empty($team)) {
            return null;
        }
        $user = \App\User::where('id', $order->user_id)->first();
        if (empty($user)) {
            return null;
        }
        
        $orderItems = $order->items()->get();
        if (empty($orderItems)) {
            return null;
        }
        $productCount = 0;
        foreach ($orderItems as $orderItem) {
            $productCount += $orderItem->count;
        }
        $curTime = Carbon::now();
        return TeamFound::create([
            'time_begin' => $curTime,
            'time_end' => $curTime->copy()->addHours($team->expire_hour),
            'nickname' => $user->nickname,
            'head_pic' => $user->head_image,
            'join_num' => 1,
            'need_mem' => $team->member,
            'price' => $team->price,
            'origin_price' => $order->origin_price/$productCount,
            'status' => $paystatus ? 1 : 0,
            'user_id' => $user->id,
            'team_id' => $team->id,
            'order_id' => $order->id
        ]);
    }
}
