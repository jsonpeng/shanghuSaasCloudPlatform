<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
//use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
//use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as AuthenticatableUser;

use Zizaco\Entrust\Traits\EntrustUserTrait;


class Admin extends AuthenticatableUser implements AuthenticatableContract{

    use Authenticatable, EntrustUserTrait, Notifiable;
    /** 
     * The attributes that are mass assignable. 
     * 
     * @var array 
     */ 
    protected $fillable = [ 
        'nickname', 'mobile', 'password', 'type','parent_id','active','member','member_end','account','shop_type','use_money'
    ]; 

 
    /** 
     * The attributes that should be hidden for arrays. 
     * 
     * @var array 
     */ 
    protected $hidden = [ 
        'password', 'remember_token', 
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'mobile' => 'required|string|min:11|unique:admins',
        'nickname' => 'required|string|max:255|unique:admins',
        'password' => 'required|string|min:6',
        'account' => 'string|unique:admins'
    ];

    public static $rules_update = [
        'mobile' => 'required|string|min:11',
        'nickname' => 'required|string|max:255',
        'password' => 'required|string|min:6',
        'account' => 'string'
    ];

    //拥有的店铺权限
    public function shops(){
       
        return $this->belongsToMany('App\Models\StoreShop','admins_shops','admin_id','shop_id');
        
    }

    public function getShowNameAttribute()
    {
        return $this->nickname ? $this->nickname : '管理员编号:'.$this->id;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function package(){
        return $this->hasOne('App\Models\AdminPackage');
    }
}
