<?php

namespace App\Repositories;

use App\Models\TeamLottery;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TeamLotteryRepository
 * @package App\Repositories
 * @version January 21, 2018, 10:58 pm CST
 *
 * @method TeamLottery findWithoutFail($id, $columns = ['*'])
 * @method TeamLottery find($id, $columns = ['*'])
 * @method TeamLottery first($columns = ['*'])
*/
class TeamLotteryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'order_id',
        'mobile',
        'team_id',
        'nickname',
        'head_pic'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return TeamLottery::class;
    }
}
