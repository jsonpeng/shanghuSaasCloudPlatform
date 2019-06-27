<?php

namespace App\Repositories;

use App\Models\DiscountOrder;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DiscountOrderRepository
 * @package App\Repositories
 * @version June 7, 2018, 10:23 am CST
 *
 * @method DiscountOrder findWithoutFail($id, $columns = ['*'])
 * @method DiscountOrder find($id, $columns = ['*'])
 * @method DiscountOrder first($columns = ['*'])
*/
class DiscountOrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'price',
        'user_id',
        'orgin_price',
        'no_discount_price',
        'use_user_money',
        'user_level_money',
        'coupon_id',
        'coupon_price'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return DiscountOrder::class;
    }
}
