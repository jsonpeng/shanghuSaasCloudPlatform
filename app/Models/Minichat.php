<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Minichat
 * @package App\Models
 * @version June 5, 2018, 5:36 pm CST
 *
 * @property string app_name
 * @property string app_id
 * @property string access_token
 * @property timestamp expires
 * @property string refresh_token
 * @property integer admin_id
 */
class Minichat extends Model
{
    use SoftDeletes;

    public $table = 'minichats';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'app_id',
        'access_token',
        'expires',
        'refresh_token',
        'admin_id',
        'nick_name',
        'head_img',
        'service_type_info',
        'verify_type_info',
        'user_name',
        'principal_name',
        'qrcode_url',
        'signature',
        'business_info_store',
        'business_info_scan',
        'business_info_pay',
        'business_info_card',
        'business_info_shake'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'app_name' => 'string',
        'app_id' => 'string',
        'access_token' => 'string',
        'refresh_token' => 'string',
        'admin_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'app_id' => 'required'
    ];

    
}
