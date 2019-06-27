<?php

namespace App\Repositories;

use App\Models\CreditLog;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CreditLogRepository
 * @package App\Repositories
 * @version February 6, 2018, 5:53 pm CST
 *
 * @method CreditLog findWithoutFail($id, $columns = ['*'])
 * @method CreditLog find($id, $columns = ['*'])
 * @method CreditLog first($columns = ['*'])
*/
class CreditLogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'time',
        'amount',
        'change',
        'detail',
        'user_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CreditLog::class;
    }

    public function creditLogs($user, $skip = 0, $take = 18)
    {
        return $user->creditLogs()->orderBy('created_at', 'desc')->skip($skip)->take($take)->get();
    }
}
