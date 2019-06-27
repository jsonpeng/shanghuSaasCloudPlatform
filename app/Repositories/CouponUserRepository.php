<?php

namespace App\Repositories;

use App\Models\CouponUser;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CouponUserRepository
 * @package App\Repositories
 * @version January 18, 2018, 10:06 am UTC
 *
 * @method CouponUser findWithoutFail($id, $columns = ['*'])
 * @method CouponUser find($id, $columns = ['*'])
 * @method CouponUser first($columns = ['*'])
*/
class CouponUserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'coupon_id',
        'coupon_type',
        'order_id',
        'from_way',
        'use_time',
        'code',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CouponUser::class;
    }
}
