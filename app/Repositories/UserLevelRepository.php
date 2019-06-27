<?php

namespace App\Repositories;

use App\Models\UserLevel;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class UserLevelRepository
 * @package App\Repositories
 * @version January 6, 2018, 2:33 am UTC
 *
 * @method UserLevel findWithoutFail($id, $columns = ['*'])
 * @method UserLevel find($id, $columns = ['*'])
 * @method UserLevel first($columns = ['*'])
*/
class UserLevelRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'amount',
        'discount',
        'discribe'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return UserLevel::class;
    }

    public function accountLevel($account){
        $levels = UserLevel::where('account',$account)->get();
        if(!count($levels)){
            createUserLevel();
            return $this->accountLevel($account);
        }
        return $levels;
    }

    /**
     * [下一等级]
     * @param  [type] $level_id [当前等级level的id]
     * @param  [type] $account  [对应账户下的]
     * @return [type]           [description]
     */
    public function nextLevel($level_id,$account,$shop_id){
        $level = $this->findWithoutFail($level_id);
        $next_level = null;
        if(!empty($level)){

            $next_level_id = UserLevel::where('growth','>',$level->growth)
            ->where('account',$account)
            ->where('shop_id',$shop_id)
            ->min('id');

            $next_level = $this->findWithoutFail($next_level_id);
        }
        return $next_level;
    }

    /**
     * [全部会员特权]
     * @param  [type] $level_id [description]
     * @param  [type] $account  [description]
     * @return [type]           [description]
     */
    public function allUserLevel($level_id,$account,$shop_id){
        $level = $this->findWithoutFail($level_id);
        $all_level = [];
        if(!empty($level)){
            $all_level = UserLevel::where('growth','<=',$level->growth)
            ->where('account',$account)
            ->where('shop_id',$shop_id)
            ->get();
        }
        return $all_level;
    }

    /**
     * [根据成长值得到最接近的会员等级]
     * @param  [type] $grouth [description]
     * @return [type]         [description]
     */
    public function theClosestGrowthUserLevel($grouth,$user){
        $level = UserLevel::where('account',$user->account)
                ->where('growth','<=',$grouth)
                ->max('id');
        #如果没有匹配的 或者成长值是0 就给原来的会员等级
        if(empty($level) || empty($grouth)){
            $level = $user->user_level;
        }
        return $level;
    }
}
