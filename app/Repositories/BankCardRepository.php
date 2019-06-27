<?php

namespace App\Repositories;

use App\Models\BankCard;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BankCardRepository
 * @package App\Repositories
 * @version October 25, 2017, 9:56 am CST
 *
 * @method BankCard findWithoutFail($id, $columns = ['*'])
 * @method BankCard find($id, $columns = ['*'])
 * @method BankCard first($columns = ['*'])
*/
class BankCardRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'bank_name',
        'user_name',
        'mobile',
        'count',
        'user_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BankCard::class;
    }
}
