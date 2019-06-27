<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Hash;

class CommonController extends Controller{
	/**
     * 小程序管理登录
     *
     * @SWG\Get(path="/api/manage/login",
     *   tags={"小程序[后台管理]接口(https://qijianshen.xyz)"},
     *   summary="小程序管理登录",
     *   description="小程序管理登录,仅限管理员登录,不需要token响应头信息",
     *   operationId="loginMiniAdminManage",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="type",
     *     type="string",
     *     description="登录方式 password => 手机号+密码 , code => 手机号+验证码",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="mobile",
     *     type="string",
     *     description="手机号",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="password",
     *     type="string",
     *     description="密码",
     *     required=true,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回管理标识",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期",
     *     )
     * )
     */
	public function loginMiniManage(Request $request){
			//登录方式 password => 手机号+密码 , code => 手机号+验证码
			$type = $request->input('type');

			if(empty($type)){
				return zcjy_callback_data('未知错误',1);
			}

			$mobile = $request->input('mobile');

			if(empty($mobile)){
				return zcjy_callback_data('请输入手机号',1);
			}

			$admin = Admin::where('mobile',$mobile)->first();

			if(empty($admin)){
				return zcjy_callback_data('该手机号未注册过管理员',1);
			}

			if($type == 'password'){

				$pwd = $request->input('password');

				if(empty($pwd)){
					return zcjy_callback_data('请输入密码',1);
				}

				if(!Hash::check($pwd,$admin->password)){
					return zcjy_callback_data('密码输入错误',1);
				}

			}
			elseif($type == 'code'){
				#检查验证码
				$input_code = $request->input('code');

				if(empty($input_code)){
					return zcjy_callback_data('请输入验证码',1);
				}

				$code = session($admin->id.'_manage_login');

				if($input_code != $code){
					return zcjy_callback_data('验证码输入错误',1);
				}

			}

			#登录管理员
			auth('admin')->login($admin);

			#返回对应管理员的account
			$account = admin()->account;

			return zcjy_callback_data($account);

	}

	public function test(Request $request){
		$admin = admin($request->get('key'));
		return zcjy_callback_data($admin);
	}



}

