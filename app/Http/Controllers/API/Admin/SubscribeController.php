<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubscribeController extends Controller{

	private $obj;
	private $word;
	public function __construct(){
	 	$this->obj = app('commonRepo')->subscribeRepo();
	 	$this->word = '预约';
	}

	public function index(Request $request){
		$user = auth()->user();

		$subscribes = account($this->obj,$user->account,true,$request->input('shop_id'))->get();
		
		#预约记录加上预约服务和技师 
		foreach ($subscribes as $key => $val) {
			$val['service'] = $val->service()->first();
			$val['technician'] = $val->technician()->first();
		}

		return zcjy_callback_data($subscribes);
	}

	public function show(){

	}

	public function store(Request $request){
		$user = auth()->user();

		$input = $request->all();

		$input['account'] = $user->account;

		$subscribe = $this->obj->create($input);

		return zcjy_callback_data('创建'.$this->word.'成功');
	}


	public function update(Request $request,$id){

		$subscribe = $this->obj->findWithoutFail($id);

		if(empty($subscribe)){
			return zcjy_callback_data('没有该'.$this->word.'',1);
		}

		$subscribe->update($request->all());

		return zcjy_callback_data('更新'.$this->word.'成功');
	}


	public function destroy($id){

		$subscribe = $this->obj->findWithoutFail($id);

		if(empty($subscribe)){
			return zcjy_callback_data('没有该'.$this->word.'',1);
		}

		$subscribe->delete();

		return zcjy_callback_data('删除'.$this->word.'成功');
	}

}

