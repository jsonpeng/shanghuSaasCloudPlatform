<?php

namespace App\Repositories;

use App\Models\FlashSale;
use InfyOm\Generator\Common\BaseRepository;
use Carbon\Carbon;

/**
 * Class FlashSaleRepository
 * @package App\Repositories
 * @version January 21, 2018, 4:46 pm CST
 *
 * @method FlashSale findWithoutFail($id, $columns = ['*'])
 * @method FlashSale find($id, $columns = ['*'])
 * @method FlashSale first($columns = ['*'])
*/
class FlashSaleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'product_id',
        'spec_id',
        'price',
        'product_num',
        'buy_limit',
        'buy_num',
        'order_num',
        'intro',
        'time_begin',
        'time_end',
        'is_end',
        'product_name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return FlashSale::class;
    }

    // public function salesBetweenTime($time_begin, $time_end, $skip = 0, $take = 20)
    // {
    //     return FlashSale::where('time_begin', '>=', $time_begin)->where('time_end', '<=', $time_end)->skip($skip)->take($take)->get();
    // }
    
    public function salesBetweenTime($skip = 0, $take = 20, $time_begin = null)
    {
        $time_begin = empty($time_begin) ? Carbon::today() : $time_begin;
        $curTime = Carbon::parse($time_begin);
        $time_begin = processTime($curTime);
        $time_end = $time_begin->addDay(1);
        return FlashSale::where('time_begin', '<=', $time_end)->where('time_end', '>=', $time_begin)->skip($skip)->take($take)->get();
    }

    public function deleteReplaceProductByProductIdOrSpecId($product_id=0,$spec_id=0){
        if($product_id!=0){
            $flashSale_pro= FlashSale::where('product_id',$product_id)->count();
            if($flashSale_pro>0) {
                FlashSale::where('product_id', $product_id)->delete();
            }
        }
        if($spec_id!=0){
            $flashSale_spec= FlashSale::where('spec_id',$spec_id)->count();
            if($flashSale_spec>0) {
                FlashSale::where('spec_id', $spec_id)->delete();
            }
        }
    }

}
