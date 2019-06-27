<?php

namespace App\Repositories;

use App\Models\ChargePackagesPrice;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ChargePackagesPriceRepository
 * @package App\Repositories
 * @version June 22, 2018, 2:57 pm CST
 *
 * @method ChargePackagesPrice findWithoutFail($id, $columns = ['*'])
 * @method ChargePackagesPrice find($id, $columns = ['*'])
 * @method ChargePackagesPrice first($columns = ['*'])
*/
class ChargePackagesPriceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'package_id',
        'years',
        'price'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ChargePackagesPrice::class;
    }

    public function emptyById($id){
        return ChargePackagesPrice::where('package_id',$id)->delete();
    }

}
