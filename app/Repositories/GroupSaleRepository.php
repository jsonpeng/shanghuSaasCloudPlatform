<?php

namespace App\Repositories;

use App\Models\GroupSale;
use InfyOm\Generator\Common\BaseRepository;

use Carbon\Carbon;

/**
 * Class GroupSaleRepository
 * @package App\Repositories
 * @version January 22, 2018, 9:00 am CST
 *
 * @method GroupSale findWithoutFail($id, $columns = ['*'])
 * @method GroupSale find($id, $columns = ['*'])
 * @method GroupSale first($columns = ['*'])
*/
class GroupSaleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'time_begin',
        'time_end',
        'product_id',
        'spec_id',
        'price',
        'product_max',
        'buy_num',
        'order_num',
        'buy_base',
        'intro',
        'origin_price',
        'product_name',
        'recommend',
        'view',
        'is_end'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return GroupSale::class;
    }

    public function getActiveGroupSale()
    {
        $cur = Carbon::now();
        return GroupSale::where('time_begin', '<', $cur)->where('time_end', '>', $cur)->with('product')->with('spec')->get();
    }
}
