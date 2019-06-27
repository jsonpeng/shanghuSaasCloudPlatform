<?php

namespace App\Repositories;

use App\Models\CreditServiceUser;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CreditServiceUserRepository
 * @package App\Repositories
 * @version May 31, 2018, 4:40 pm CST
 *
 * @method CreditServiceUser findWithoutFail($id, $columns = ['*'])
 * @method CreditServiceUser find($id, $columns = ['*'])
 * @method CreditServiceUser first($columns = ['*'])
*/
class CreditServiceUserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'credit_service_id',
        'snumber',
        'user_id',
        'status',
        'pick_time',
        'pick_shop_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CreditServiceUser::class;
    }
}
