<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Carbon\Carbon;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     */
    protected $fillable = [
        'name',
        'email',
        //'email_validated',
        'nickname',
        'password',
        //'password-pay',
        'sex',
        'birthday',
        'head_image',
        'mobile',
        'qq',
        'openid',
        'unionid',
        'code',
        'share_qcode',
        'user_money',
        'credits',
        //'underling_number',
        
        //'user_money',
        //'frozen_money',
        'distribut_money',
        'consume_total',

        'last_login',
        'last_ip',
        'oauth',

        'province',
        'city',
        'district',

        //'lock',
        'is_distribute',

        'leader1',
        'leader2',
        'leader3',
        'level1',
        'level2',
        'level3',

        //会员等级
        'user_level',
        'status',
        'account',
        //成长值
        'growth',
        'type'
        //'credits'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function addresses()
    {
        return $this->hasMany('App\Models\Address', 'user_id', 'id');
    }

    //会员订单
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    //商品收藏
    public function collections(){
        return $this->belongsToMany('App\Models\Product', 'product_user', 'user_id', 'product_id');
    }

    //用户的优惠券
    public function coupons()
    {
        return $this->hasMany('App\Models\CouponUser');
    }

    //用户的积分记录
    public function creditLogs()
    {
        return $this->hasMany('App\Models\CreditLog');
    }

    //用户的余额记录
    public function moneyLogs()
    {
        return $this->hasMany('App\Models\MoneyLog');
    }

    

    //积分兑换记录
    // public function points()
    // {
    //     return $this->hasMany('App\Models\PointOrder');
    // }

    //用户等级
    public function level(){
        return $this->belongsTo('App\Models\UserLevel', 'user_level', 'id');
    }

    //银行卡
    public function bankcard(){
        return $this->hasMany('App\Models\BankCard');
    }

    //提现记录
    public function withdrawl(){
        return $this->hasMany('App\Models\WithDrawl');
    }

    //当天的提现次数
    public function  getwithdrawlNumByDayAttribute(){
        return $this->withdrawl()->whereBetween('created_at', array(Carbon::today(), Carbon::tomorrow()))->count();

    }
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * [发布的文章列表]
     * @return [type] [description]
     */
    public function posts(){

        return $this->hasMany('App\Models\Post','id','user_id');
        
    }

    /**
     * 用户的服务列表
     * @return [type] [description]
     */
    public function services(){

        return $this->belongsToMany('App\Models\Services', 'services_users', 'user_id', 'service_id')->withPivot('num','time_begin','time_end','status');
    
    }

    /**
     * 用户的预约列表
     */
    public function subscribes(){

        return $this->hasMany('App\Models\Subscribe');

    }

    /**
     * 积分产品兑换记录
     * @return [type] [description]
     */
    public function creditsShopLogs(){

        return $this->hasMany('App\Models\CreditServiceUser');
        
    }


    
    
}
