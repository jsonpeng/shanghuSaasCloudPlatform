<?php

namespace App\Repositories;

use App\Models\RefundLog;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RefundLogRepository
 * @package App\Repositories
 * @version February 8, 2018, 5:25 pm CST
 *
 * @method RefundLog findWithoutFail($id, $columns = ['*'])
 * @method RefundLog find($id, $columns = ['*'])
 * @method RefundLog first($columns = ['*'])
*/
class RefundLogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'des',
        'time'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return RefundLog::class;
    }
}
