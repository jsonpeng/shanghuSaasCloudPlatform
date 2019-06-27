<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\User;

/**
 * Class TeamFound
 * @package App\Models
 * @version January 21, 2018, 8:34 pm CST
 *
 * @property string time_begin
 * @property string time_end
 * @property integer user_id
 * @property integer team_id
 * @property string nickname
 * @property string head_pic
 * @property string order_id
 * @property integer join_num
 * @property integer need_mem
 * @property float price
 * @property float origin_price
 * @property integer status
 */
class TeamFound extends Model
{
    use SoftDeletes;

    public $table = 'team_founds';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'time_begin',
        'time_end',
        'user_id',
        'team_id',
        'nickname',
        'head_pic',
        'order_id',
        'join_num',
        'need_mem',
        'price',
        'origin_price',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'time_begin' => 'string',
        'time_end' => 'string',
        'user_id' => 'integer',
        'team_id' => 'integer',
        'nickname' => 'string',
        'head_pic' => 'string',
        'order_id' => 'string',
        'join_num' => 'integer',
        'need_mem' => 'integer',
        'price' => 'float',
        'origin_price' => 'float',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'time_begin' => 'required',
        'time_end' => 'required'
    ];

    public function getTeamStatusAttribute(){
        if ($this->status == 0) {
            return '待开团';
        }
        if ($this->status == 1) {
            $timeCur = Carbon::now();
            if (Carbon::parse($this->time_end)->lt($timeCur)) {
                //时间已过
                if ($this->need_mem == $this->join_num) {
                    return '拼团成功';
                } else {
                    return '拼团失败';
                }
            } else {
                //时间已过
                if ($this->need_mem == $this->join_num) {
                    return '拼团成功';
                } else {
                    return '拼团中';
                }
            }
            
        }
        if ($this->status == 2) {
            return '拼团成功';
        }
        if ($this->status == 3) {
            return '拼团失败';
        }
        return '拼团中';
    }

    // //团长名称
    // public function getTeamUserAttribute(){
    //     $user=User::find($this->user_id);
    //     if(!empty($user)){
    //         return $user;
    //     }
    // }

    //参团信息
    public function teamFollow(){
        return $this->hasMany('App\Models\TeamFollow');
    }
}
