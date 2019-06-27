<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\User;
use App\Models\Admin;

class UpdateManagerRequest extends Request
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
    // public function rules()
    // {

    //     $rules = User::$rules;
    //     unset($rules['password']);
    //     //解决unique update出现的问题
    //     $manager_id = (int)$this->manager_id;
    //     $old_user = User::where('id', $manager_id)->first();      
    //     //dd($manager_id);
    //     //如果unique字段未更改，则进行处理
    //     if($old_user->name == $this->name){
    //         $rules['name'] = $rules['name'].',name,'.$manager_id;
    //     } 
    //     if($old_user->email == $this->email){
    //         $rules['email'] = $rules['email'].',email,'.$manager_id;
    //     } 

    //     return $rules;
    // }
    // 
     public function rules()
    {
        return Admin::$rules_update;
    }
}
