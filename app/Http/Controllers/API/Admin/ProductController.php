<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller{

	private $obj;
	private $word;
	public function __construct(){
	 	$this->obj = app('commonRepo')->productRepo();
	 	$this->word = '产品';
	 }

	public function index(Request $request){

		$user = auth()->user();

		$products = account($this->obj,$user->account,true,$request->input('shop_id'))->get();

		return zcjy_callback_data($products);

	}

	public function show(){

	}

	public function store(Request $request){
		$user = auth()->user();

		$input = $request->all();

		$input['account'] = $user->account;
		
		$input['shop_id'] = $input['shop_id'];

		$product = $this->obj->create($input);

		$this->syncServiceAndImg($input,$product);

		return zcjy_callback_data('创建'.$this->word.'成功');
	}

	/**
     * 关联服务图片操作
     * @param  [type] $input    [description]
     * @param  [type] $product [description]
     * @return [type]           [description]
     */
    private function syncServiceAndImg($input,$product){
    	#服务关联
        if ( array_key_exists('services_id', $input) && !empty($input['services_id'])) {
            #先置空
            $product->services()->sync([]);
            $services_id_arr = $input['services_id'];
            for($i=count($services_id_arr)-1;$i>=0;$i--){
                if(strpos($services_id_arr[$i],',')!==false){
                 $services_id_arr_more=explode(',',$services_id_arr[$i]);
                  //dd($services_id_arr_more);
                    for($m=count($services_id_arr_more)-1;$m>=0;$m--){
                        $product->services()->attach($services_id_arr_more[$m], ['num' => $input['services_num'][$m]]);
                    }
                }
                else {
                    $product->services()->attach($services_id_arr[$i], ['num' => $input['services_num'][$i]]);
                }
            }
        }

    	#图片关联
        if ( array_key_exists('product_img', $input) && !empty($input['product_img'])) {
            #先置空
          	app('commonRepo')->productImageRepo()->clearProductImg($product->id);
            $product_img_arr = $input['product_img'];
            for($i=count($product_img_arr)-1;$i>=0;$i--){
                if(strpos($product_img_arr[$i],',')!==false){
                 $product_img_arr_more=explode(',',$product_img_arr[$i]);
                    for($m=count($product_img_arr_more)-1;$m>=0;$m--){
                        app('commonRepo')->productImageRepo()->create(['url'=>$product_img_arr_more[$m],'product_id'=>$product->id]);
                    }
                }
                else {
                   	   app('commonRepo')->productImageRepo()->create(['url'=>$product_img_arr[$i],'product_id'=>$product->id]);
                }
            }
        }
      
    }

	public function update(Request $request,$id){

		$product = $this->obj->findWithoutFail($id);

		if(empty($product)){
			return zcjy_callback_data('没有该'.$this->word.'',1);
		}

		$input = $request->all();

		$product->update($input);

		$this->syncServiceAndImg($input,$product);
		
		return zcjy_callback_data('更新'.$this->word.'成功');
	}


	public function destroy($id){

		$product = $this->obj->findWithoutFail($id);

		if(empty($product)){
			return zcjy_callback_data('没有该'.$this->word.'',1);
		}

		$product->delete();

		return zcjy_callback_data('删除'.$this->word.'成功');
	}

}

