<?php

namespace App\Repositories;

use App\Models\CouponRule;
use InfyOm\Generator\Common\BaseRepository;

class CouponRuleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type',
        'base',
        'given'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CouponRule::class;
    }
    
}
