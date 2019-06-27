<?php

namespace App\Repositories;

use App\Models\BankSets;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class BankSetsRepository
 * @package App\Repositories
 * @version February 2, 2018, 4:44 pm CST
 *
 * @method BankSets findWithoutFail($id, $columns = ['*'])
 * @method BankSets find($id, $columns = ['*'])
 * @method BankSets first($columns = ['*'])
*/
class BankSetsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'img'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return BankSets::class;
    }

    public function orderByDesc(){

    }
}
