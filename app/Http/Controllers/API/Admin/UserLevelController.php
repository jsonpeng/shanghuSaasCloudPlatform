<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserLevelController extends Controller{

	private $obj;
	private $word;
	public function __construct(){
	 	$this->obj = app('commonRepo')->userLevelRepo();
	 	$this->word = '会员卡';
	 }

	public function index(Request $request){

		$user = auth()->user();

		$levels = account($this->obj,$user->account,true,$request->input('shop_id'))->get();

		return zcjy_callback_data($levels);

	}

	public function show(){

	}

	public function store(Request $request){
		$user = auth()->user();

		$input = $request->all();

		$input['account'] = $user->account;
		$input['shop_id'] = $input['shop_id'];
		
		$level = $this->obj->create($input);

		return zcjy_callback_data('创建'.$this->word.'成功');
	}


	public function update(Request $request,$id){

		$level = $this->obj->findWithoutFail($id);

		if(empty($level)){
			return zcjy_callback_data('没有该'.$this->word.'',1);
		}

		$level->update($request->all());

		return zcjy_callback_data('更新'.$this->word.'成功');
	}


	public function destroy($id){

		$level = $this->obj->findWithoutFail($id);

		if(empty($level)){
			return zcjy_callback_data('没有该'.$this->word.'',1);
		}

		$level->delete();

		return zcjy_callback_data('删除'.$this->word.'成功');
	}

}

