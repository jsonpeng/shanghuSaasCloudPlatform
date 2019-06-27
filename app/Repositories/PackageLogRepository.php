<?php

namespace App\Repositories;

use App\Models\PackageLog;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class PackageLogRepository
 * @package App\Repositories
 * @version June 21, 2018, 10:29 am CST
 *
 * @method PackageLog findWithoutFail($id, $columns = ['*'])
 * @method PackageLog find($id, $columns = ['*'])
 * @method PackageLog first($columns = ['*'])
*/
class PackageLogRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'package_name',
        'price',
        'admin_id',
        'type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PackageLog::class;
    }
}
