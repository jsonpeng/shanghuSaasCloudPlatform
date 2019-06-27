<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\UserLevel;

use App\Repositories\CouponRepository;
use App\Repositories\CouponUserRepository;
use App\Repositories\UserRepository;

use EasyWeChat\Factory;
use Config;
use Log;
use Storage;
use Carbon\Carbon;


class UserController extends Controller
{

	private $couponRepository;
    private $couponUserRepository;
    private $userRepository;
    public function __construct(
        UserRepository $userRepo,
        CouponUserRepository $couponUserRepo, 
        CouponRepository $couponRepo
    )
    {
        $this->couponRepository = $couponRepo;
        $this->couponUserRepository = $couponUserRepo;
        $this->userRepository=$userRepo;
    }

    /**
     * 小程序登录
     *
     * @SWG\Get(path="/api/mini_program/login",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序登录",
     *   description="小程序登录,不需要token验证",
     *   operationId="loginMiniprogramUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="nickname",
     *     type="string",
     *     description="昵称",
           ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回token请求头信息",
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
    public function loginMiniprogram(Request $requet)
    {
        $input = $requet->all();

        if (!$requet->has('code') || empty($requet->input('code'))) {
            return ['status_code'=>1,'data'=>'参数不正确'];
        }
        $result = [];

        if(Config::get('version.state')!='local'){
            $app = Factory::miniProgram(Config::get('wechat.mini_program.default'));
            $result = $app->auth->session($requet->input('code'));
        }
        
        $unionid = null;
        if (array_key_exists('unionid', $result)) {
            $unionid = $result['unionid'];
        }

        $parent_id = null;
        if (array_key_exists('parent_id', $input)) {
            $parent_id = $input['parent_id'];
        }

        @$user = $this->userRepository->processRecommendRelation($result['openid'], $parent_id, $unionid);

        if(Config::get('version.state')=='local'){
            $user = User::find(1);
        }

        $this->updateUserInfo($user, $input['userInfo']);

        $token = auth()->login($user);

        return zcjy_callback_data(['token' => $token]);
    }

    public function updateUserInfo($user, $userInfo)
    {
        $userInfo = json_decode($userInfo, true);
        $user->update($userInfo);
    }

    /**
     * 用户登出
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function postLogout(Request $request)
    {
    	auth()->logout();
    	return zcjy_callback_data('退出登录');
    }


    /**
     * 小程序用户个人信息
     *
     * @SWG\Get(path="/api/me",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序用户个人信息",
     *   description="小程序用户个人信息,需要token信息",
     *   operationId="userInfoUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回banner图链接列表",
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
    public function userInfo(Request $request)
    {
        #接口请求用户
    	$user = auth()->user();

        #当前即时成长值
        $grouth = app('commonRepo')->userRepo()->userGrowth($user);

    	$userLevel = null;
        $nextUserLevel = null;
        $allUserLevel = null;
        $account = $request->account;

    	//if(funcOpen('FUNC_MEMBER_LEVEL',null,$account)){
            Log::info('开了');
            $userLevel = UserLevel::where('id', $user->user_level)->first();
            #把下一级也带过去
            $nextUserLevel = app('commonRepo')->userLevelRepo()->nextLevel($user->user_level,$account,$request->input('shop_id'));
            #全部的会员特权
            $allUserLevel = app('commonRepo')->userLevelRepo()->allUserLevel($user->user_level,$account,$request->input('shop_id'));
        //}
        
        #返回参数对
        $data = [
            'user' => $user,
            'userLevel' => $userLevel,
            'nextUserLevel'=>$nextUserLevel,
            'allUserLevel'=>$allUserLevel
        ];

        return zcjy_callback_data($data);
    }

    /**
     * 小程序获取用户所有的消息/所有未读的消息
     *
     * @SWG\Get(path="/api/auth_notices",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序获取用户所有的消息/所有未读的消息",
     *   description="小程序获取用户所有的消息/所有未读的消息,需要token信息",
     *   operationId="authNoticesUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
     *   @SWG\Parameter(
     *     in="formData",
     *     name="shop_id",
     *     type="string",
     *     description="店铺id",
     *     required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回banner图链接列表",
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
    public function authNotices(Request $request){
        $user = auth()->user();

        $notices = allNotices($user->id,$request->has('unread'),false);
      
        return zcjy_callback_data($notices);
    }


    /**
     * 小程序批量设置消息为已读取状态
     *
     * @SWG\Get(path="/api/read_notices",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序批量设置消息为已读取状态",
     *   description="小程序批量设置消息为已读取状态,需要token信息",
     *   operationId="readAllNoticesUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
     *   @SWG\Parameter(
     *     in="formData",
     *     name="shop_id",
     *     type="string",
     *     description="店铺id",
     *     required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回banner图链接列表",
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
    public function readAllNotices(Request $request){
         $user = auth()->user();

         #批量设置为已读取状态
         readedNotice($user->id,true,false);

         return zcjy_callback_data('设置成功');
    }


    /**
     * 小程序删除单条通知消息
     *
     * @SWG\Get(path="/api/delete_notice",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序删除单条通知消息",
     *   description="小程序删除单条通知消息,需要token信息",
     *   operationId="deleteNoticeUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
     *   @SWG\Parameter(
     *     in="formData",
     *     name="shop_id",
     *     type="string",
     *     description="店铺id",
     *     required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回banner图链接列表",
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
    public function deleteNotice(Request $request){
        $user = auth()->user();

        deleteNotice($user->id,false,$request->input('notice_id'));

        return zcjy_callback_data('删除成功');
    }


    /**
     * 小程序用户服务列表
     *
     * @SWG\Get(path="/api/auth_services",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序用户服务列表",
     *   description="小程序用户服务列表,需要token信息",
     *   operationId="newSubscribeUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
     *   @SWG\Parameter(
     *     in="formData",
     *     name="shop_id",
     *     type="string",
     *     description="店铺id",
     *     required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回banner图链接列表",
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
    public function authServices(Request $request){
        //获取前清理下过期的服务
        app('commonRepo')->userRepo()->clearExpiredService();
        $user = auth()->user();
        $skip = 0;
        $take = 18;

        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }

        if ($request->has('take')) {
            $take = $request->input('take');
        }

        #使用状态
        $status = '待使用';
        if ($request->has('status')) {
            $status = $request->input('status');
        }

        #用户的服务
        $services = app('commonRepo')->userRepo()->userServices($user->id)->where('status',$status)->orderBy('created_at','desc');

        if($status == '已使用'){
            $services->orderBy('use_time','desc');
        }

       
        
        $services = $services->skip($skip)->take($take)->get();
        //$services = $user->services()->orderBy('created_at','desc')->skip($skip)->take($take)->get();

        #过滤服务状态
        // $services = $services->filter(function($service, $key) use($status){
        //     return $service->pivot->status == $status;
        // });
      

        #附加适用店铺信息
        foreach ($services as $key => $service) {
            $service['service'] =  app('commonRepo')->serviceRepo()->findWithoutFail($service->service_id);
            $service['shops'] = $service['service']->shops()->get();
            if(!$service->time_type){
                    $service['time_begin'] = Carbon::parse($service->time_begin)->format('Y-m-d');
                    $service['time_end'] = Carbon::parse($service->time_end)->format('Y-m-d');
            }
            #带上二维码
            // $qrcodes_param = http().domain().'/varify?service_user_id='.$service->id.'&key='.$service['service']->account;
            // $service['qrcode'] = app('commonRepo')->createQrCodes($qrcodes_param);
            // $service['qrcode_l'] = app('commonRepo')->createQrCodes($qrcodes_param,300);
        }



        return zcjy_callback_data($services);
    }

    
    /**
     * 小程序获取对应服务消耗的二维码
     *
     * @SWG\Get(path="/api/get_service_user_qrcode",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序获取对应服务消耗的二维码",
     *   description="小程序获取对应服务消耗的二维码,需要token信息",
     *   operationId="getServiceUserQrCodeUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
     *   @SWG\Parameter(
     *     in="formData",
     *     name="shop_id",
     *     type="string",
     *     description="店铺id",
     *     required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回banner图链接列表",
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
    public function getServiceUserQrCode(Request $request){
        $user = auth()->user();

        $service_user_id = $request->input('service_user_id');

        if(!empty($service_user_id)){

            $service_user = app('commonRepo')->serviceUserModel()::find($service_user_id);

            if(!empty($service_user)){

                if($service_user->status != '待使用'){

                     return zcjy_callback_data('该服务'.$service_user->status,1);
                     
                }

                $qrcodes_param = http().domain().'/varify?service_user_id='.$service_user_id.'&key='.$user->account;

                #返回二维码地址
                return zcjy_callback_data(app('commonRepo')->createQrCodes($qrcodes_param,300));

            }

        }
        else{
            return zcjy_callback_data('该服务不存在',1);
        }


    }

    /**
     * 小程序用户的预约
     *
     * @SWG\Get(path="/api/auth_subscribe",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序用户的预约",
     *   description="小程序用户的预约,需要token信息",
     *   operationId="authSubscribeUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
     *   @SWG\Parameter(
     *     in="formData",
     *     name="shop_id",
     *     type="string",
     *     description="店铺id",
     *     required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回banner图链接列表",
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
    public function authSubscribe(Request $request){
        $user = auth()->user();
        $skip = 0;
        $take = 18;

        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }

        if ($request->has('take')) {
            $take = $request->input('take');
        }

        #用户的预约
        $subscribes = $user->subscribes()->orderBy('created_at','desc')->skip($skip)->take($take)->get();

        foreach ($subscribes as $key => $value) {
            #添加星期
            $value['weekday'] = technicianWorkDay()[Carbon::parse($value->arrive_time)->dayOfWeek];
            #添加店铺信息
            $value['shop'] = $value->shop()->first();
            #添加服务信息
            $value['service'] = $value->service()->first();
            #添加技师信息
            $value['technician'] = $value->technician()->first();
        }

        return zcjy_callback_data($subscribes);
    }

    /**
     * 小程序用户取消预约
     *
     * @SWG\Get(path="/api/auth_cancle_subscribe",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序用户取消预约",
     *   description="小程序用户取消预约,需要token信息",
     *   operationId="cancleSubscribeUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
     *   @SWG\Parameter(
     *     in="formData",
     *     name="shop_id",
     *     type="string",
     *     description="店铺id",
     *     required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回banner图链接列表",
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
    public function cancleSubscribe(Request $request){
        
        $subscribe = app('commonRepo')->subscribeRepo()->findWithoutFail($request->input('id'));

        if(!empty($subscribe)){
            $arrive_time =  $subscribe->arrive_time;
            $subscribe->update(['status'=>'已取消']);

            $user = auth()->user();

            #通知商户用户取消预约
            sendNotice(admin($user->account)->id,'用户'.a_link($user->nickname,'/zcjy/users/'.$user->id).'在您的店铺下的'.tag('预约').a_link('[点击查看详情]','/zcjy/subscribes/'.$subscribe->id.'/edit').tag('已手动取消').',请注意查看');

            #通知用户 预约成功及状态
            sendNotice($user->id,'您的预约已['.$subscribe->status.'],请在个人中心查看',false);
            Log::info('arrive_time:');
            Log::info($arrive_time);
            $subscribe->update(['arrive_time'=>$arrive_time]);

            #返回接口数据
            return zcjy_callback_data('取消预约成功');
                
       } 
       else{
            return zcjy_callback_data('没有该预约',1);
        }
        
    }


    
    /**
     * 小程序用户积分商品兑换记录
     *
     * @SWG\Get(path="/api/auth_credits_shops",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序用户积分商品兑换记录",
     *   description="小程序用户积分商品兑换记录,需要token信息",
     *   operationId="creditsShopLogUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
     *   @SWG\Parameter(
     *     in="formData",
     *     name="shop_id",
     *     type="string",
     *     description="店铺id",
     *     required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回banner图链接列表",
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
    public function creditsShopLog(Request $request){
        $user = auth()->user();
        $skip = 0;
        $take = 18;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        $shops = $user->creditsShopLogs()
                ->orderBy('created_at','desc')
                ->skip($skip)
                ->take($take)
                ->get();

        #带上积分产品和服务
        foreach ($shops as $key => $val) {
            $val['creditsShop'] = $val->creditservice()->first();
            $val['service'] = null;
            if(!empty($val['creditsShop']->service_id)){
                 $val['service'] = $val['creditsShop']->service()->first();
            }
        }
        return zcjy_callback_data($shops);
    }

    /**
     * 小程序用户积分记录
     *
     * @SWG\Get(path="/api/credits",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序用户积分记录",
     *   description="小程序用户积分记录,需要token信息",
     *   operationId="creditsLog_User",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回banner图链接列表",
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
    public function credits(Request $request)
    {
    	$user = auth()->user();
    	$skip = 0;
        $take = 18;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        $creditLogs = $user->creditLogs()->skip($skip)->take($take)
                ->orderBy('created_at','desc')->get();

        foreach ($creditLogs as $key => $val) {
            #添加星期
            $val['weekday'] = technicianWorkDay()[Carbon::parse($val->created_at)->dayOfWeek];
            #处理时间日期
            $val['date'] = $val->created_at->format('m-d');
        }
        return zcjy_callback_data($creditLogs);
    }

    /**
     * 小程序用户余额记录
     *
     * @SWG\Get(path="/api/funds",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序用户余额记录",
     *   description="小程序用户余额记录,需要token信息",
     *   operationId="fundsLog_User",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回banner图链接列表",
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
    public function funds(Request $request)
    {
    	$user = auth()->user();
    	$take = 18;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
//        $moneyLogs = $user->moneyLogs()->skip($skip)->take($take)->get();
        $moneyLogs = $this->userRepository->moneyLogs($user, $skip, $take);

        foreach ($moneyLogs as $key => $val) {
            #添加星期
            $val['weekday'] = technicianWorkDay()[Carbon::parse($val->created_at)->dayOfWeek];
            #处理时间日期
            $val['date'] = $val->created_at->format('m-d');
        }
        
        return zcjy_callback_data($moneyLogs);
    }

    /**
     * 用户分佣记录
     * @param  Request $request [description]
     * @param  integer $skip    [description]
     * @param  integer $take    [description]
     * @return [type]           [description]
     */
    public function bouns(Request $request)
    {
    	$user = auth()->user();
    	$take = 18;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        $moneyLogs = $this->userRepository->moneyLogs($user, $skip, $take, '分佣');
        return zcjy_callback_data($moneyLogs);
    }

    /**
     * 分销推荐人列表
     * @param  Request $request [description]
     * @param  integer $skip    [description]
     * @param  integer $take    [description]
     * @return [type]           [description]
     */
    public function parterners(Request $request)
    {
    	$user = auth()->user();
    	$take = 18;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        $fellows = $this->userRepository->followMembers($user, $skip, $take);
        return zcjy_callback_data($fellows);
    }
    
    /**
     * 获取用户的优惠券
     * @param  Request $request [description]
     * @param  integer $type    [description]
     * @param  integer $skip    [description]
     * @param  integer $take    [description]
     * @return [type]           [description]
     */
    public function coupons(Request $request, $type = -1)
    {
    	$user = auth()->user();
    	$take = 18;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        $coupons = $this->couponRepository->couponGetByStatus($user, $type, $skip, $take);
        return zcjy_callback_data($coupons);
    }

    /**
     * 小程序推广二维码
     *
     * @SWG\Get(path="/api/mini_program/distribution_code",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序推广二维码",
     *   description="小程序推广二维码,需要token信息",
     *   operationId="distributionCodeUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="nickname",
     *     type="string",
     *     description="昵称",
           ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回推广二维码地址链接",
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
    public function distributionCode(Request $request)
    {
        $user = auth()->user();

        $folderpath = '/qrcodes'; 
        $filename = 'minicode_'.$user->id.'.png';

        $filepath = $folderpath.'/'.$filename;

        if(Storage::exists($filepath)){

            return ['status_code' => 0, 'data' => $filepath];

        } else {
            $app = Factory::miniProgram(Config::get('wechat.mini_program.default'));

            $response = $app->app_code->getUnlimit($user->id, [
                'page' => 'pages/index/index',
                'width' => 430
            ]);

            $filename = $response->saveAs(public_path().$folderpath, $filename);

            return zcjy_callback_data($filepath);
        }
    }
    
}