<?php

namespace App\Repositories;

use App\Models\WithDrawl;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class WithDrawlRepository
 * @package App\Repositories
 * @version February 28, 2018, 3:00 pm CST
 *
 * @method WithDrawl findWithoutFail($id, $columns = ['*'])
 * @method WithDrawl find($id, $columns = ['*'])
 * @method WithDrawl first($columns = ['*'])
*/
class WithDrawlRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'no',
        'user_id',
        'type',
        'price',
        'status',
        'arrive_time',
        'bank_id',
        'account_tem',
        'card_name',
        'card_no'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return WithDrawl::class;
    }

    public function descToShow()
    {
        return WithDrawl::orderBy('created_at', 'desc')->get();
    }
}
