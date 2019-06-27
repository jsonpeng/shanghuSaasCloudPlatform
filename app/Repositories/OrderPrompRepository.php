<?php

namespace App\Repositories;

use App\Models\OrderPromp;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class OrderPrompRepository
 * @package App\Repositories
 * @version January 19, 2018, 3:58 pm CST
 *
 * @method OrderPromp findWithoutFail($id, $columns = ['*'])
 * @method OrderPromp find($id, $columns = ['*'])
 * @method OrderPromp first($columns = ['*'])
*/
class OrderPrompRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'type',
        'base',
        'value',
        'time_begin',
        'time_end',
        'intro'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return OrderPromp::class;
    }

    public function getSuitablePromp($totalPrice)
    {
        return OrderPromp::where('base', '<=', $totalPrice)->orderBy('base', 'desc')->first();
    }
}
