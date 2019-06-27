<?php

namespace App\Repositories;

use App\Models\ChargePackage;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class ChargePackageRepository
 * @package App\Repositories
 * @version May 2, 2018, 4:48 pm CST
 *
 * @method ChargePackage findWithoutFail($id, $columns = ['*'])
 * @method ChargePackage find($id, $columns = ['*'])
 * @method ChargePackage first($columns = ['*'])
*/
class ChargePackageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'type',
        'money',
        'days',
        'bonus'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return ChargePackage::class;
    }

    public function getPackageByName($name){
        return ChargePackage::where('name',$name)->first();
    }

    //获取给商户当前的套餐列表
    public function getAdminPackages($admin){
          $admin_package = $admin->package()->first();

          $packages = ChargePackage::orderBy('level','asc')
          ->with('words')
          ->get();

          $count_days = count_time_days($admin_package->package_endtime);
          foreach ($packages as $key => $package) {

                $package['rel_price'] = $package->prices()->first()->price;
                
                if($admin_package->level > $package->level){
                        $package['status'] = '已拥有';
                }
                elseif($admin_package->level == $package->level){
                        $package['status'] = '立即续费';
                        $package['type'] = '续费';
                }
                else{
                    if($admin_package->level == 0){
                        $package['status'] = '立即购买';
                        $package['type'] = '购买';
                    }
                    else{
                        $package['status'] = '立即升级';
                        $package['type'] = '升级';
                      /*
                        #过期升级按一年收费
                        if($count_days <= 0){
                              $package['rel_price'] = $package->money;
                        }

                        #剩余套餐时间超过365天 和 刚买升级直接减去之前套餐价格
                        if($count_days >= 365){
                              $package['rel_price'] = $package->money - $admin_package->price;
                        }

                        if($count_days < 365){
                              #其他按照使用天数来减
                              $package['rel_price'] = round($package->money - $admin_package->price*($count_days/365));
                        }
                        */
                    }
                }
              $package['exclusive_list'] = getList($package->exclusive); 
          }
          return $packages;
    }

}
