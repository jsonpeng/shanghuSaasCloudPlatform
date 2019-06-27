<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Pinyin;

class CategoryController extends Controller{

	private $obj;
	private $word;
	public function __construct(){
	 	$this->obj = app('commonRepo')->categoryRepo();
	 	$this->word = '分类';
	 }

	public function index(Request $request){

		$user = auth()->user();

		$categorys = account($this->obj,$user->account,true,$request->input('shop_id'))->get();

		return zcjy_callback_data($categorys);

	}

	public function show(){

	}

	public function store(Request $request){
		$user = auth()->user();

		$input = $request->all();

		$input['account'] = $user->account;
		$input['shop_id'] = $request->input('shop_id');
		$input['parent_path'] = '0';
        $input['level'] = 1;
        //处理别名
        if (!array_key_exists('slug', $input) || empty($input['slug'])) {
            $input['slug'] = Pinyin::permalink($input['name']);
        }

		$category = $this->obj->create($input);

		return zcjy_callback_data('创建'.$this->word.'成功');
	}


	public function update(Request $request,$id){

		$category = $this->obj->findWithoutFail($id);

		if(empty($category)){
			return zcjy_callback_data('没有该'.$this->word.'',1);
		}

		$category->update($request->all());

		return zcjy_callback_data('更新'.$this->word.'成功');
	}


	public function destroy($id){

		$category = $this->obj->findWithoutFail($id);

		if(empty($category)){
			return zcjy_callback_data('没有该'.$this->word.'',1);
		}

		$category->delete();

		return zcjy_callback_data('删除'.$this->word.'成功');
	}

}

