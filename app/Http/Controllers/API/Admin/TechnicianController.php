<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TechnicianController extends Controller{

	private $obj;
	private $word;
	public function __construct(){
	 	$this->obj = app('commonRepo')->technicianRepo();
	 	$this->word = '技师';
	}

	public function index(Request $request){
		
		$user = auth()->user();

		$technicians = account($this->obj,$user->account,true,$request->input('shop_id'))->get();
		#加上时间和服务
		foreach ($technicians as $key => $val) {

			$val['services'] = str_replace('&nbsp;&nbsp;',' ',$val->Services);
			$workdays = explode(',', $val->workday);
			$workdays_arr = [];
			foreach ($workdays as $key => $workday) {
				$workdays_arr[] = technicianWorkDay()[$workday];
			}
			$val['workdays'] = $workdays_arr;

		}
		return zcjy_callback_data($technicians);

	}

	public function show(){

	}

	public function store(Request $request){
		$user = auth()->user();

		$input = $request->all();

		$input['account'] = $user->account;
		
		$technician = $this->obj->create($input);

		return zcjy_callback_data('创建'.$this->word.'成功');
	}


	public function update(Request $request,$id){

		$technician = $this->obj->findWithoutFail($id);

		if(empty($technician)){
			return zcjy_callback_data('没有该'.$this->word.'',1);
		}

		$technician->update($request->all());

		return zcjy_callback_data('更新'.$this->word.'成功');
	}


	public function destroy($id){

		$technician = $this->obj->findWithoutFail($id);

		if(empty($technician)){
			return zcjy_callback_data('没有该'.$this->word.'',1);
		}

		$technician->delete();

		return zcjy_callback_data('删除'.$this->word.'成功');
	}

}

