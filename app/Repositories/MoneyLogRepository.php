<?php

namespace App\Repositories;

use App\Models\MoneyLog;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MoneyLogRepository
 * @package App\Repositories
 * @version February 6, 2018, 5:57 pm CST
 *
 * @method MoneyLog findWithoutFail($id, $columns = ['*'])
 * @method MoneyLog find($id, $columns = ['*'])
 * @method MoneyLog first($columns = ['*'])
*/
class MoneyLogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
        return MoneyLog::class;
    }

    
}
