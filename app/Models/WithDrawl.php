<?php

namespace App\Models;

use Eloquent as Model;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class WithDrawl
 * @package App\Models
 * @version February 28, 2018, 3:00 pm CST
 *
 * @property string no
 * @property integer user_id
 * @property string type
 * @property float price
 * @property string status
 * @property string arrive_time
 * @property integer bank_id
 * @property float account_tem
 * @property string card_name
 * @property string card_no
 */
class WithDrawl extends Model
{
    use SoftDeletes;

    public $table = 'with_drawls';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'no',
        'user_id',
        'type',
        'price',
        'status',
        'arrive_time',
        'bank_id',
        'account_tem',
        'card_name',
        'card_no'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'no' => 'string',
        'user_id' => 'integer',
        'type' => 'string',
        'price' => 'float',
        'status' => 'string',
        'arrive_time' => 'string',
        'bank_id' => 'integer',
        'account_tem' => 'float',
        'card_name' => 'string',
        'card_no' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function bankinfo(){
        return $this->belongsTo('App\Models\BankCard','bank_id','id');
    }

    public function getUserNameAttribute(){
        $user=User::find($this->user_id);
        if(!empty($user)){
            return $user->name;
        }else{
            return null;
        }
    }
}
