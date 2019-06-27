<?php

namespace App\Repositories;

use App\Models\Minichat;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MinichatRepository
 * @package App\Repositories
 * @version June 5, 2018, 5:36 pm CST
 *
 * @method Minichat findWithoutFail($id, $columns = ['*'])
 * @method Minichat find($id, $columns = ['*'])
 * @method Minichat first($columns = ['*'])
*/
class MinichatRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'app_name',
        'app_id',
        'access_token',
        'expires',
        'refresh_token',
        'admin_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Minichat::class;
    }
}
