<?php

namespace App\Repositories;

use App\Models\ProductPromp;
use InfyOm\Generator\Common\BaseRepository;
use Carbon\Carbon;

/**
 * Class ProductPrompRepository
 * @package App\Repositories
 * @version January 19, 2018, 3:05 am UTC
 *
 * @method ProductPromp findWithoutFail($id, $columns = ['*'])
 * @method ProductPromp find($id, $columns = ['*'])
 * @method ProductPromp first($columns = ['*'])
*/
class ProductPrompRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'type',
        'value',
        'time_begin',
        'time_end',
        'image',
        'intro'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ProductPromp::class;
    }

    //正在进行中的活动
    public function curPromps()
    {
        $cur = Carbon::now();
        return ProductPromp::where('time_begin', '<', $cur)->where('time_end', '>', $cur)->get();
    }
}
