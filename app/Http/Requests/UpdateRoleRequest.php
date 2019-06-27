<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Role;

class UpdateRoleRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Role::$rules;
        //解决unique update出现的问题
        $role_id = (int)$this->role_id;
        $old_role = Role::where('id', $role_id)->first();      
        
        //如果unique字段未更改，则进行处理
        if($old_role->name == $this->name){
            $rules['name'] = $rules['name'].',name,'.$role_id;
        } 
        return $rules;
    }
}
