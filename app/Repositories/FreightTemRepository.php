<?php

namespace App\Repositories;

use App\Models\FreightTem;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class FreightTemRepository
 * @package App\Repositories
 * @version February 9, 2018, 5:10 pm CST
 *
 * @method FreightTem findWithoutFail($id, $columns = ['*'])
 * @method FreightTem find($id, $columns = ['*'])
 * @method FreightTem first($columns = ['*'])
*/
class FreightTemRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'count_type',
        'use_default'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return FreightTem::class;
    }

    public function getFirstTem(){
        return FreightTem::where('id','>','0')->first();
    }
}
