<?php

namespace App\Repositories;

use App\Models\TeamFollow;
use InfyOm\Generator\Common\BaseRepository;
use Carbon\Carbon;

/**
 * Class TeamFollowRepository
 * @package App\Repositories
 * @version January 21, 2018, 10:52 pm CST
 *
 * @method TeamFollow findWithoutFail($id, $columns = ['*'])
 * @method TeamFollow find($id, $columns = ['*'])
 * @method TeamFollow first($columns = ['*'])
*/
class TeamFollowRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'nickname',
        'head_pic',
        'order_id',
        'found_id',
        'found_user_id',
        'team_id',
        'status',
        'is_winner'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return TeamFollow::class;
    }


    public function createTeamFollow($order_id, $team_found_id, $paystatus = false)
    {
        $order = \App\Models\Order::where('id', $order_id)->first();
        if (empty($order)) {
            return ['code' => 1, 'message' => '订单不存在'];
        }
        $teamFound = \App\Models\TeamFound::where('id', $team_found_id)->first();
        if (empty($teamFound)) {
            return ['code' => 1, 'message' => '开团信息不存在'];
        }
        //自己开团不能自己参加
        if ($teamFound->user_id == $order->user_id) {
            return ['code' => 1, 'message' => '自己开团不能自己参加'];
        }
        $team = \App\Models\TeamSale::where('id', $order->prom_id)->first();
        if (empty($team)) {
            return ['code' => 1, 'message' => '团购已经结束'];
        }
        $user = \App\User::where('id', $order->user_id)->first();
        if (empty($user)) {
            return ['code' => 1, 'message' => '用户信息不存在'];
        }
        //是否在有效时间内
        if ( Carbon::parse($teamFound->time_end)->gt(Carbon::now())) {
            return ['code' => 1, 'message' => '拼团时间已截止, 请重新开团'];
        }
        //是否已经满员了
        if ( $teamFound->need_mem <= $teamFound->join_num ) {
            return ['code' => 1, 'message' => '该团成员已满, 试试其他的团，或这自己开个团吧'];
        }

        $curTime = Carbon::now();
        $teamFellow = TeamFollow::create([
            'nickname' => $user->nickname,
            'head_pic' => $user->head_image,
            'status' => $paystatus ? 1 : 0,
            'is_winner' => 0,
            'user_id' => $user->id,
            'order_id' => $order->id,
            'found_user_id' => $teamFound->user_id,
            'found_id' => $team_found_id,
            'team_id' => $team->id,
        ]);
        return ['code' => 0, 'message' => $teamFellow];
    }
}


