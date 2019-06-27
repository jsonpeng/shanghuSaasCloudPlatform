<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BankCard
 * @package App\Models
 * @version October 25, 2017, 9:56 am CST
 *
 * @property string name
 * @property string bank_name
 * @property string user_name
 * @property string mobile
 * @property string count
 * @property integer user_id
 */
class BankCard extends Model
{
    use SoftDeletes;

    public $table = 'bank_cards';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'type',
        'bank_name',
        'user_name',
        'mobile',
        'count',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'type'=>'string',
        'bank_name' => 'string',
        'user_name' => 'string',
        'mobile' => 'string',
        'count' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'bank_name' => 'required',
        'user_name' => 'required',
        'count' => 'required'
    ];

    public function getsubcardnoAttribute (){
        return substr($this->count,-4);
    }

    public function getcardTypeAttribute(){
        return $this->type==0?'储蓄卡':'信用卡';
    }

    
}
