<?php

namespace App\Repositories;

use App\Models\Technician;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TechnicianRepository
 * @package App\Repositories
 * @version May 8, 2018, 10:52 am CST
 *
 * @method Technician findWithoutFail($id, $columns = ['*'])
 * @method Technician find($id, $columns = ['*'])
 * @method Technician first($columns = ['*'])
*/
class TechnicianRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'image',
        'intro',
        'work_day'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Technician::class;
    }
}
