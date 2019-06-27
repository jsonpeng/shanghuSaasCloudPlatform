<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

//use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Validator;
use JWTAuth;
use JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


use App\Models\CouponRule;
use App\Models\PointRule;

use EasyWeChat\Factory;
use App\User;

//use SmsManager;

class AuthController extends Controller
{

    // //发送短信
    // public function getSms(Request $request){
        
    //     $res = SmsManager::validateSendable();
    //     if (!$res['success']) {
    //         return response()->json($res);
    //     }

    //     $res = SmsManager::validateFields();
    //     if (!$res['success']) {
    //         return response()->json($res);
    //     }

    //     $res = SmsManager::requestVerifySms();
    //     if ($res['success']) {
    //         $data = SmsManager::retrieveState();
    //         $res['token'] = $this->encrypt(sprintf('%s%d', $request['mobile'], $data['code']), $this->key);
    //         return response()->json($res);
    //     }
    //     return ['message'=>'验证码发送失败', 'status_code' => 500];
    // }

    //用户注册
    public function postRegister(Request $request){
        $inputs = $request->all();
        $validator = $this->validator($inputs);

        if ($validator->fails()) {
            $message = $validator->errors()->first();
            return ['message'=>$message, 'status_code' => 405];
        } 
        if ( !array_key_exists('token', $inputs) || $this->decrypt($inputs['token'], $this->key) != sprintf('%s%d', $inputs['mobile'], $inputs['verifyCode']) ) {
            return ['message'=>'验证码信息不正确', 'status_code' => 405];
        }
        $inputs['name'] = $inputs['mobile'];
        $inputs['nickname'] = $inputs['mobile'];
        $customer = $this->create($inputs);
        $customer->update(['code' => 10000 + $customer->id]);

        //登录吧
        $credentials = $request->only('mobile', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return ['message'=>'登录信息不正确', 'status_code' => 401];
            }
        } catch (JWTException $e) {
            return ['message'=>'登录失败，未知原因', 'status_code' => 500];
        }

        return ['message'=>$token, 'status_code' => 0];
    }

    //用户登录
    public function getLogin(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'mobile' => 'required', 'password' => 'required',
        ]);
        if ($validator->fails()) {
            $message = $validator->errors()->first();
            return ['message'=>$message, 'status_code' => 500];
        }

        // grab credentials from the request
        $credentials = $request->only('mobile', 'password');
        try {
            //Config::set('auth.model', 'App\Models\Customer');
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                //$this->recoverAuth();
                //return response()->json(['message'=>'登录信息不正确', 'status_code' => 401], 401);
                return ['message'=>'登录信息不正确', 'status_code' => 401];
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            //$this->recoverAuth();
            //return response()->json(['message'=>'登录失败，未知原因', 'status_code' => 500], 500);
            return ['message'=>'登录失败，未知原因', 'status_code' => 500];
        }

        // all good so return the token
        //$this->recoverAuth();
        return ['message'=>$token, 'status_code' => 0];
        //return response()->json(compact('token'));
    }

    /**
     * 修改密码
     * @param Request $request [description]
     */
    // public function ModifyPassword(Request $request){
    //     $user = JWTAuth::toUser($request['token']);
    //     // 请求字段验证
    //     $credentials = $request->only('old_password', 'new_password');
    //     $validator = Validator::make($credentials, [
    //         'old_password' => 'required', 'new_password' => 'required|min:6|max:20',
    //     ]);
    //     if ($validator->fails()) {
    //         $message = $validator->errors()->first();
    //         return ['message'=>'密码信息输入有误', 'status_code' => 500];
    //     }

    //     // 旧密码验证
    //     if ( Auth::attempt(['mobile' => $user->mobile, 'password' => $request['old_password']]) ) {
    //         $user->update(['password' => bcrypt($request['new_password'])]);
    //         return ['message'=>'密码修改成功', 'status_code' => 0];
    //     }else{
    //         return ['message'=>'旧密码输入错误', 'status_code' => 500];
    //     }
    // }

    /**
     * 微信授权登录
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    // public function weixinAuth(Request $request){
    //     //存储客户端要跳转的链接
    //     $options = Config::get('weixin');
    //     $app = new Application($options);
    //     $response = $app->oauth->scopes(['snsapi_userinfo'])
    //                       ->redirect();
    //     return $response;
    // }

    /**
     * 微信授权登录回调
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    // public function weixinAuthCallback(Request $request){

    //     $options = Config::get('weixin');
    //     $app = new Application($options);
    //     $oauth = $app->oauth;
    //     // 获取 OAuth 授权结果用户信息
    //     $userinfo = $oauth->user();
    //     $user = User::where('weixin', $userinfo->getId())->first();
    //     if (is_null($user)) {
    //         // 是否送积分
    //         $points_given = 0;
    //         $pointRule = PointRule::where('type', '新用户注册')->first();
    //         if ( !is_null($pointRule) ) {
    //             $points_given = $pointRule->points;
    //         }
    //         // 新建用户
    //         $user = User::create([
    //             'weixin' => $userinfo->getId(),
    //             'nickname' => $userinfo->getNickname(),
    //             'type' => '用户',
    //             'head_image' => $userinfo->getAvatar(),
    //             'score' => $points_given
    //             ]);
    //         // 送张优惠券
    //         $rule = CouponRule::where('type', '新用户注册')->first();
    //         if ( !is_null($rule) ) {
    //             // 有新用户注册送券活动
    //             $coupon = $rule->coupons()->first();
    //             if ( !is_null($coupon) ) {
    //                 // 优惠券还有
    //                 // $user->coupons()->attach($coupon->id);
    //                 $this-->createFromCoupon($coupon, $user->id);
    //             }
    //         }

    //         $user->update(['code' => 10000 + $user->id]);
    //         $token = JWTAuth::fromUser($user);

    //         $rurl = sprintf("%s/#/home/%s", env('CLIENT', ''), $token);
    //         //Log::info($rurl);
    //         return redirect($rurl);
    //     }else{
    //         $user->update([
    //             'nickname' => $userinfo->getNickname(),
    //             'head_image' => $userinfo->getAvatar()
    //             ]);
    //         $token = JWTAuth::fromUser($user);

    //         $rurl = sprintf("%s/#/home/%s", env('CLIENT', ''), $token);
    //         return redirect($rurl);
    //     }
    // }

    public function getUserAccount(Request $request) {
        $user = JWTAuth::toUser($request['token']);
        return ['message'=>$user, 'status_code' => 0];
    }

    protected function getCredentials(Request $request)
    {
        return $request->only('mobile', 'password');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return Customer
     */
    // protected function create(array $data)
    // {
    //     return User::create([
    //         'mobile' => $data['mobile'],
    //         'name' => $data['name'],
    //         'nickname' => $data['nickname'],
    //         'password' => bcrypt($data['password']),
    //     ]);
    // }

    /**
     * 验证注册信息
     * @param  array  $data [description]
     * @return [type]       [description]
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'mobile' => 'required|max:11|unique:users',
            'password' => 'required|min:6|max:20'
        ]);
    }
}
