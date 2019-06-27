<?php

namespace App\Repositories;

use App\Models\TopupGifts;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class TopupGiftsRepository
 * @package App\Repositories
 * @version June 6, 2018, 11:02 am CST
 *
 * @method TopupGifts findWithoutFail($id, $columns = ['*'])
 * @method TopupGifts find($id, $columns = ['*'])
 * @method TopupGifts first($columns = ['*'])
*/
class TopupGiftsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'price',
        'give_balance',
        'give_credits',
        'coupon_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return TopupGifts::class;
    }

 

    public function minPriceReturn($shop_id,$price){
        $TopupGifts = TopupGifts::where('shop_id',$shop_id)
                    ->where('price','<=',$price)
                    ->orderBy('price','desc')
                    ->first();

        return  $TopupGifts;
    }


}
