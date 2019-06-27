<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller{


	public function index(Request $request){
		$user = auth()->user();

		$services = account(app('commonRepo')->serviceRepo(),$user->account,true,$request->input('shop_id'))->get();

		return zcjy_callback_data($services);
	}

	public function show(){

	}

	public function store(Request $request){
		$user = auth()->user();

		$input = $request->all();

		$input['account'] = $user->account;
		$input['shop_id'] = $input['shop_id'];
		
		$service = app('commonRepo')->serviceRepo()->create($input);

		return zcjy_callback_data('创建服务成功');
	}


	public function update(Request $request,$id){

		$service = app('commonRepo')->serviceRepo()->findWithoutFail($id);

		if(empty($service)){
			return zcjy_callback_data('没有该服务',1);
		}

		$service->update($request->all());

		return zcjy_callback_data('更新服务成功');
	}


	public function destroy($id){

		$service = app('commonRepo')->serviceRepo()->findWithoutFail($id);

		if(empty($service)){
			return zcjy_callback_data('没有该服务',1);
		}

		$service->delete();

		return zcjy_callback_data('删除服务成功');
	}

}

