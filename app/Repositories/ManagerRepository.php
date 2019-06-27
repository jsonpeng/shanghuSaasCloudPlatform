<?php

namespace App\Repositories;

use App\Models\Admin;
use InfyOm\Generator\Common\BaseRepository;

class ManagerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'nickname',
        'type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Admin::class;
    }

    //统计总部管理员 
    public function count(){
        return count(Admin::all());
    }

    
    /**
     * [所有的代理商/管理员/商户]
     * @param  string  $type   [description]
     * @param  boolean $parent [description]
     * @return [type]          [description]
     */
    public function allManager($type='代理商',$parent=false){

        return $parent
        ?Admin::where('type', $type)->where('parent_id',$parent)->orderBy('created_at','desc')->get()
        :Admin::where('type', $type)->orderBy('created_at','desc')->get();
    }
}
