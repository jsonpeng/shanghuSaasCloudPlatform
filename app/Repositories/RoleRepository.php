<?php

namespace App\Repositories;

use App\Role;
use InfyOm\Generator\Common\BaseRepository;

class RoleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'display_name',
        'description'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Role::class;
    }

    
    public function getRoleArray(){
        $tmp_roles = Role::all();
        $roles = array(-1 => '无权限');
        $tmp_roles->each(function ($item, $key) use(&$roles) {
            $roles[$item['id']] = $item['name'];
        });

        return $roles;
    }
}
