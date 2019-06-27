<?php

namespace App\Models;

use Eloquent as Model;
use App\Models\Category;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

/**
 * Class Product
 * @package App\Models
 * @version April 28, 2017, 2:28 am UTC
 */
class Product extends Model
{
    use SoftDeletes;

    public $table = 'products';
    

    protected $dates = ['deleted_at'];

    // protected $dateFormat = 'Y-m-d H:i';


    public $fillable = [
        'name',
        'sn',
        'image',
        'price',
        'market_price',
        // 'cost',
        'inventory',
        'max_buy',
        // 'weight',
        'freight',
        
        'keywords',
        'remark',
        'intro',

        'delivery',
        'free_shipping',
        'service_promise',
        'recommend',
        'recommend_title',
        'recommend_intro',
        'shelf',
        
        'sort',
        'is_new',
        'is_hot',
        'views',
        'collectoins',
        'sales_count',

        'prom_type',
        'prom_id',
        'commission',

        'spu',
        'sku',
        'shipping_area_ids',

        'brand_id',
        'type_id',
        'category_id',
        'country_id',
        'account',
        'shop_id'

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'image' => 'string',
        'price' => 'float',
        'unit' => 'string',
        'onsale' => 'string',
        'sales_price' => 'float',
        'sales_start' => 'date',
        'sales_end' => 'date',
        'inventory' => 'integer',
        'warn_inventory' => 'integer',
        'max_buy' => 'integer',
        'intro' => 'string',
        'remark' => 'string',
        'delivery' => 'string',
        'service_promise' => 'string',
        'paras' => 'string',
        'recommend' => 'string',
        'recommend_title' => 'string',
        'recommend_intro' => 'string',
        'shelf' => 'string',
        'freight' => 'float',
        'category_id' => 'integer',
        'brand_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'price' => 'required',
        'image' => 'max:256'
    ];
    /**
     * 是否促销
     * @return [type] [description]
     */
    public function getIsOnsaleAttribute(){
        /*
        $dimensions = $this->dimensions()->get();
        $currentTime = Carbon::now();
        foreach ($dimensions as $dimension) {
            if ($dimension->onsale && $currentTime->gt(Carbon::parse($dimension->sales_start)) && $currentTime->lt(Carbon::parse($dimension->sales_end)) ) {
                return '是';
            }
        }
        */
        return '否';
    }
    /**
     * 价格范围
     * @return [type] [description]
     */
    public function getPriceRangeAttribute(){
        /*
        $dimensions = $this->dimensions()->get();
        $min = 1000000000;
        $max = 0;
        $currentTime = Carbon::now();
        foreach ($dimensions as $dimension) {
            //促销并在促销期内
            if ($dimension->onsale && $currentTime->gt(Carbon::parse($dimension->sales_start)) && $currentTime->lt(Carbon::parse($dimension->sales_end)) ) {
                $min = $dimension->sales_price < $min ? $dimension->sales_price : $min;
                $max = $dimension->sales_price > $max ? $dimension->sales_price : $max;
            }else{
                $min = $dimension->price < $min ? $dimension->price : $min;
                $max = $dimension->price > $max ? $dimension->price : $max;
            }
        }
        if ($min == $max) {
            return $min;
        } else {
             return $min.' - '.$max;
        }
        */
       return 'test';
    }
    

    /**
     * 是否上架
     * @return [type] [description]
     */
    public function getIsShelfAttribute(){
        if ($this->shelf == '0') {
            return '否';
        }else{
            return '是';
        }
    }
    /**
     * 是否推荐
     * @return [type] [description]
     */
    public function getIsRecommendAttribute(){
        if ($this->recommend == '0') {
            return '否';
        }else{
            return '是';
        }
    }

    /**
    *分类名称
    */
    public function getCategoryAttribute(){
        /*
        $cats = $this->cats()->get();
        if($cats->isEmpty()){
            return '无';
        }else{
            $display_name = '';
            $cats->each(function ($item, $key) use (&$display_name) {
                $display_name .= ' ';
                $display_name .= $item->name;
            });
            return $display_name;
        }
        */
       return 'test';
    }


    /**
    *所属品牌
    */
    public function brands(){
        return $this->belongsToMany('App\Models\Brand', 'brand_product', 'product_id', 'brand_id');
    }

    //所属分类
    public function getCatAttribute(){
        if($this->category_id!=0){
        $cat=Category::find($this->category_id);
            if(!empty($cat)){
                return $cat->name;
            }else{
                return '无';
            }
        }else{
            return '无';
        }
    }

    public function getNewAttribute()
    {
        if ($this->is_new) {
            return '是';
        } else {
            return '否';
        }
        
    }

    public function getHotAttribute()
    {
        if ($this->is_hot) {
            return '是';
        } else {
            return '否';
        }
        
    }

    //产品关联服务
    public function services(){
        return $this->belongsToMany('App\Models\Services','products_services','product_id','service_id')->withPivot('num');
    }

    //产品展示图片
    public function images()
    {
        return $this->hasMany('App\Models\ProductImage');
    }

    //产品关联文字描述
    public function words()
    {
        return $this->belongsToMany('App\Models\Word','product_word','product_id','word_id');
    }

    //收藏该商品的用户
    public function users(){
        return $this->belongsToMany('App\User', 'product_user', 'product_id', 'user_id');
    }

    //商品店铺
    public function shop(){
        if($this->shop_id != 0){
            return $this->belongsTo('App\Models\StoreShop','shop_id','id');
        }
        else{
            return '全店通用';
        }
    }

}
