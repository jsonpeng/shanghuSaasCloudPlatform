<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller{

	private $obj;
	private $word;
	
	public function __construct(){
	 	$this->obj = app('commonRepo')->orderRepo();
	 	$this->word = '订单';
	 }

	public function index(Request $request){

		$user = auth()->user();

		$orders = account($this->obj,$user->account,true,$request->input('shop_id'))->get();

		return zcjy_callback_data($orders);

	}

	public function show(){

	}

	public function store(Request $request){
		$user = auth()->user();

		$input = $request->all();

		$input['account'] = $user->account;

		$order = $this->obj->create($input);

		return zcjy_callback_data('创建'.$this->word.'成功');
	}


	public function update(Request $request,$id){

		$order = $this->obj->findWithoutFail($id);

		if(empty($order)){
			return zcjy_callback_data('没有该'.$this->word.'',1);
		}

		$order->update($request->all());

		return zcjy_callback_data('更新'.$this->word.'成功');
	}


	public function destroy($id){

		$order = $this->obj->findWithoutFail($id);

		if(empty($order)){
			return zcjy_callback_data('没有该'.$this->word.'',1);
		}

		$order->delete();

		return zcjy_callback_data('删除'.$this->word.'成功');
	}

}

