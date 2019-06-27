<?php

namespace App\Repositories;

use App\Models\Item;
use InfyOm\Generator\Common\BaseRepository;

class ItemRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'pic',
        'price',
        'count',
        'unit',
        'order_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Item::class;
    }
}
