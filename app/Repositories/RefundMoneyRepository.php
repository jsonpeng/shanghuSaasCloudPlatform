<?php

namespace App\Repositories;

use App\Models\RefundMoney;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RefundMoneyRepository
 * @package App\Repositories
 * @version February 12, 2018, 10:55 am CST
 *
 * @method RefundMoney findWithoutFail($id, $columns = ['*'])
 * @method RefundMoney find($id, $columns = ['*'])
 * @method RefundMoney first($columns = ['*'])
*/
class RefundMoneyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'snumber',
        'transaction_id',
        'total_fee',
        'refund_fee',
        'desc',
        'status',
        'last_query',
        'remark'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return RefundMoney::class;
    }
}
