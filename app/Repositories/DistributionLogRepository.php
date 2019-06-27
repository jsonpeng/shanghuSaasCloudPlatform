<?php

namespace App\Repositories;

use App\Models\DistributionLog;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DistributionLogRepository
 * @package App\Repositories
 * @version January 17, 2018, 1:48 am UTC
 *
 * @method DistributionLog findWithoutFail($id, $columns = ['*'])
 * @method DistributionLog find($id, $columns = ['*'])
 * @method DistributionLog first($columns = ['*'])
*/
class DistributionLogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'order_user_id',
        'user_id',
        'order_id',
        'commission',
        'order_money',
        'user_dis_level',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return DistributionLog::class;
    }
}
