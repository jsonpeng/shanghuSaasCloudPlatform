<?php

namespace App\Repositories;

use App\Models\AdminPackage;
use InfyOm\Generator\Common\BaseRepository;
use Carbon\Carbon;

/**
 * Class AdminPackageRepository
 * @package App\Repositories
 * @version June 8, 2018, 9:06 am CST
 *
 * @method AdminPackage findWithoutFail($id, $columns = ['*'])
 * @method AdminPackage find($id, $columns = ['*'])
 * @method AdminPackage first($columns = ['*'])
*/
class AdminPackageRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'admin_id',
        'package_endtime',
        'package_name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AdminPackage::class;
    }

    //自动生成一个商户套餐记录
    public function generateAdminPackage($admin_id,$package_name="免费试用",$type=null){
       $package_endtime = Carbon::now()->addDays(shop_account_times());
       
       #等级
       $level = 0;
       #可以使用的店铺数量
       $canuse_shop_num = 1;
       #套餐的价格
       $price = 0;

       if($package_name != "免费试用" && is_numeric($package_name)){
            #套餐记录
            $package_log = app('commonRepo')->packageLogRepo()->findWithoutFail($package_name);
            if(!empty($package_log)){
                #对应的套餐
                $package = app('commonRepo')->chargePackageRepo()->getPackageByName($package_log->package_name);
                if(!empty($package)){
                        $admin = admin($admin_id);
                        $level = $package->level;
                        #直接加天数
                        $package_endtime = Carbon::now()->addYears($package_log->years);
                        $canuse_shop_num = $package->canuse_shop_num;
                        $price = $package_log->price;
                        if($type == '续费'){
                            $admin_endtime = $admin->package()->first()->package_endtime;
                            $package_endtime = Carbon::parse($admin_endtime)->addYears($package_log->years);
                        }
                        $admin->update(['member_end'=>$package_endtime,'member'=>1]);
                        $package_name = $package_log->package_name.'['.$package_log->years.'年]';
                }
          }
       }

       $input = [
                'admin_id'=>$admin_id,
                'package_name'=>$package_name,
                'package_endtime'=>$package_endtime,
                'level' => $level,
                'canuse_shop_num'=>$canuse_shop_num,
                'price' => $price
       ];

       #清空之前的套餐
       AdminPackage::where('admin_id',$admin_id)->delete();

       return AdminPackage::create($input);
    }
    /**
     * [检查用户有没有过期]
     * @param  [type] $admin [description]
     * @return [type]        [description]
     */
    public function varifyOverdue($admin){
        $package = $admin->package()->first();
        //dd($package);
        if(empty($package)){
            return true;
        }
        else{
            return Carbon::parse($package->package_endtime)->lt(Carbon::now());
        }
    }

}
