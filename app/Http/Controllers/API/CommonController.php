<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Log;

class CommonController extends Controller
{
    /**
     * 基本功能列表
     * @param  [int]  $type [description]
     * @return [type] [description]
     */
    public function getFuncList(Request $request)
    {
        $user = auth()->user();
        $func = app('commonRepo')->settingRepo()->getFuncList($user->account);
        foreach ($func as $key => $value) {
                        if(strpos($key,'FUNC_')!==false){
                            $value=funcOpen($key);
                        } 
        }
        return zcjy_callback_data($func);
    }

    /**
     * 当前主题
     */
    public function themeNow(Request $request){
         return ['status_code' => 0, 'data' =>theme()];
    }


    /**
     * 一次获取所有配置
     */
    public function getAllFunc(Request $request){
         return ['status_code' => 0, 'data' =>app('commonRepo')->settingRepo()->getAllFunc()];
    }


    /**
     * 系统指定的功能
     */
      public function getSystemSettingFunc(Request $request)
    {
        return app('commonRepo')->settingRepo()->getSystemSettingFunc();
    }

    /**
     * 小程序公告消息列表
     *
     * @SWG\Get(path="/api/getNotices",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序公告消息列表",
     *   description="小程序公告消息列表,不需要需要token信息",
     *   operationId="getCatsFoundUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     ),
     *   @SWG\Parameter(
     *     in="query",
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
     public function getNotices(Request $request){
         $shop_id = $request->input('shop_id');
         return ['status_code' => 0, 'data' =>app('commonRepo')->noticeRepo()->notices($shop_id)];
     }

  
    /**
     * 小程序获取所有店铺
     *
     * @SWG\Get(path="/api/shops_all",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序获取所有店铺",
     *   description="小程序获取所有店铺,需要token信息",
     *   operationId="allShopsUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
     *   @SWG\Parameter(
     *     in="query",
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
     public function allShops(Request $request){
         #请求account
         $account = $request->account;

         #表单提交信息
         $input = $request->all();

         #所有店铺
         $shops = app('commonRepo')->shopRepo()->allAccountShop($account);

         #带上距离
         $shops = app('commonRepo')->shopRepo()->getShopsDistance($shops,$input);

         #接口请求用户
         $user = auth()->user();

         #提示商户管理员
         $address = getAddressLocation($input['jindu'],$input['weidu']);
         sendNotice(admin($account)->id,'用户'.a_link($user->nickname,'/zcjy/users/'.$user->id).'在'.a_link($address,'/zcjy/settings/map?address='.$address).'登录查看店铺');

         return ['status_code' => 0, 'data' =>$shops];

     }

    
    /**
     * 小程序获取技师列表
     *
     * @SWG\Get(path="/api/get_technicicans",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序获取技师列表",
     *   description="小程序获取技师列表,不需要需要token信息",
     *   operationId="getCatsFoundUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     ),
     *   @SWG\Parameter(
     *     in="query",
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
    public function getTechnicians(Request $request){
        $skip = 0;
        $take = 18;

        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }

        $jishis = account(app('commonRepo')->technicianRepo(),$request->account,true,$request->input('shop_id'))
            ->skip($skip)
            ->take($take)
            ->get();

        return zcjy_callback_data($jishis);
    }


    /**
     * 小程序根据技师id获取服务
     *
     * @SWG\Get(path="/api/get_services_by_technicican",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序根据技师id获取服务",
     *   description="小程序根据技师id获取服务,不需要需要token信息",
     *   operationId="getServiceByTechnicicanIdApiUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     ),
     *   @SWG\Parameter(
     *     in="query",
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
    public function getServiceByTechnicicanIdApi(Request $request){
        $technicican = app('commonRepo')->technicianRepo()->findWithoutFail($request->input('id'));
        if(!empty($technicican)){
            $skip = 0;
            $take = 18;
            if ($request->has('skip')) {
                $skip = $request->input('skip');
            }
            if ($request->has('take')) {
                $take = $request->input('take');
            }
            $services = $technicican->services()
            ->skip($skip)
            ->take($take)
            ->get();
            #处理服务时间
            foreach ($services as $key => $val) {
                    if(!$val->time_type){
                        $services[$key]['time_begin_format'] = Carbon::parse($val->time_begin)->format('Y-m-d');
                        $services[$key]['time_end_format'] = Carbon::parse($val->time_end)->format('Y-m-d');
                    }
            }
             return zcjy_callback_data($services);
        }
        else{
             return zcjy_callback_data('没有找到该技师',1);
        }
    }

    //根据店铺id获取对应的服务
    public function getServiceByShopIdApi(Request $request){
        $shop_id = $request->input('shop_id');
        return app('commonRepo')->shopRepo()->getServiceByShopId($shop_id,false);
    }


    //根据服务id获取对应的技师
    public function getTechniciansByServicesIdApi(Request $request){
        $service_id = $request->input('service_id');
        return app('commonRepo')->serviceRepo()->getTechniciansByServicesId($service_id,false);
    }

    /**
     * 小程序新建预约
     *
     * @SWG\Get(path="/api/new_subscribe",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序新建预约",
     *   description="小程序新建预约,需要token信息",
     *   operationId="newSubscribeUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
     *   @SWG\Parameter(
     *     in="query",
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
    public function newSubscribe(Request $request){
        $user = auth()->user();

        $input = $request->all();

        #带上用户id信息
        $input['user_id'] = $user->id;

        #带上account信息
        $input['account'] = $user->account;

        #预约人信息
        $input['subman'] = $user->nickname;

        #新建预约
        $subscribe = app('commonRepo')->subscribeRepo()->create($input);

        #通知商户有新预约
        sendNotice(admin($user->account)->id,'用户'.a_link($user->nickname,'/zcjy/users/'.$user->id).'在您的店铺下有新的'.tag('预约').a_link('[点击查看详情]','/zcjy/subscribes/'.$subscribe->id.'/edit').',请注意查看');

        #通知用户 预约成功及状态
        sendNotice($user->id,'您的预约已成功,当前状态[未分配],请在个人中心查看',false);
    
        #返回接口数据
        return zcjy_callback_data('预约成功'); 
    }

    /**
     * 小程序预约时间选择日历
     *
     * @SWG\Get(path="/api/sub_timer",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序预约时间选择日历",
     *   description="小程序预约时间选择日历,需要token信息",
     *   operationId="subTimerSelectedUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
     *   @SWG\Parameter(
     *     in="query",
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
    public function  subTimerSelected(Request $request){
        #日历顶部时间
        $now = Carbon::now()->format('Y-m-d');
        $tomorrow = Carbon::now()->addDays(1)->format('Y-m-d');
        $after_tomorrow = Carbon::now()->addDays(2)->format('Y-m-d');
        $after_tomorrow_add1 = Carbon::now()->addDays(3)->format('Y-m-d');
        $after_tomorrow_add2 = Carbon::now()->addDays(4)->format('Y-m-d');
        $after_tomorrow_add3 = Carbon::now()->addDays(5)->format('Y-m-d');

        #接口用户
        $user = auth()->user();

        $begin_time = getSettingValueByKey('shop_time_begin',true,$user->account,$request->input('shop_id'));

        $end_time = getSettingValueByKey('shop_time_end',true,$user->account,$request->input('shop_id'));

        #取出店铺的指定时间
        $shop_time_begin =empty($begin_time) ? '00:00' : $begin_time;

        $shop_time_end =empty($end_time) ? '24:00' : $end_time;

        #取出店铺营业时间的列表
        $detail_time_arr = $this->dealTimerBeginAndEnd($shop_time_begin,$shop_time_end);

        #算出具体分时列表中和当前的时间间距
        $detail_time_compare_arr = [];

        foreach($detail_time_arr as $time){
            array_push($detail_time_compare_arr,Carbon::parse($now.$time)->gt(Carbon::now()));
        }

        #实际的时间列表并且带上是否大于当前的时间
        $current_time_arr = [];

        foreach($detail_time_arr as $key=> $current){
            array_push($current_time_arr,[
                'time'=>$current, 
                'gtNow'=>$detail_time_compare_arr[$key]
            ]);
        }

        return zcjy_callback_data(
            [
                //日历顶部时间
                'now'=>$now,
                'tomorrow'=>$tomorrow,
                'after_tomorrow'=>$after_tomorrow,
                'after_tomorrow_add1'=>$after_tomorrow_add1,
                'after_tomorrow_add2'=>$after_tomorrow_add2,
                'after_tomorrow_add3'=>$after_tomorrow_add3,
                #店铺起始时间
                'shop_time_begin'=>$shop_time_begin,
                #店铺结束时间
                'shop_time_end'=>$shop_time_end,
                #日历顶部右侧的时间以12.12为格式
                'format_time_arr'=>[
                        'after_tomorrow_add1'=>Carbon::now()->addDays(3)->format('m.d'),
                        'after_tomorrow_add2'=>Carbon::now()->addDays(4)->format('m.d'),
                        'after_tomorrow_add3'=>Carbon::now()->addDays(5)->format('m.d'),
                ],
                'detail_time_arr'=>$detail_time_arr,
                'detail_time_compare_arr'=>$detail_time_compare_arr,
                #实际的时间时分列表并且带上是否大于当前的时间
                'current_time_arr'=>$current_time_arr 
            ]
        );
    }

    //通过时间起止得出营业时间列表
    private function dealTimerBeginAndEnd($begin,$end){
         $begin_hour = (int)((explode(':' ,  $begin))[0]);
         $end_hour =  (int)((explode(':' ,  $end))[0]);

         $hour_arr = [$begin_hour];

         #先处理时间
         for ($i=$end_hour -  $begin_hour; $i>=0; $i--) { 
            if($begin_hour<$end_hour){
                $begin_hour++;
                array_push($hour_arr,$begin_hour);
            }
         }

         #然后序列化为时分 
         for($k = count($hour_arr)-1;$k>=0;$k--){
             $hour_arr[$k] = $hour_arr[$k].':00';
         }

         #加上中间的30分
         // foreach ($hour_arr as $key => $value) {
         //     $key = (int)$key;
         //     $hour = explode(':' ,  $value)[0].':30';
         //     array_splice($hour_arr,$key,0,$hour); 
         // }
         return $hour_arr;
    }


    /**
     * 小程序获取积分商城产品列表
     *
     * @SWG\Get(path="/api/credits_shop_list",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序获取积分商城产品列表",
     *   description="小程序获取积分商城产品列表,需要token信息",
     *   operationId="creditsShopListUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
     *   @SWG\Parameter(
     *     in="query",
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
    public function creditsShopList(Request $request){
        $skip = 0;
        $take = 18;

        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }

        $shops = app('commonRepo')->creditsServiceRepo()->creditsShopListByAccount($request->input('shop_id'),$skip,$take);
        
        return zcjy_callback_data($shops);
    }

    /**
     * 小程序积分商城商品详情
     *
     * @SWG\Get(path="/api/credits_shop_detail",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序积分商城商品详情",
     *   description="小程序积分商城商品详情,需要token信息",
     *   operationId="creditsShopDetailUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
     *   @SWG\Parameter(
     *     in="query",
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
    public function creditsShopDetail(Request $request){
        $shop = app('commonRepo')->creditsServiceRepo()->creditsShopDetail($request->input('id'));
        if(empty($shop)){
            return zcjy_callback_data('没有该产品',1);
        }
        return zcjy_callback_data($shop);
    }

    /**
     * 小程序用户发起兑换积分商品
     *
     * @SWG\Get(path="/api/publish_credits_ex",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序用户发起兑换积分商品",
     *   description="小程序用户发起兑换积分商品,需要token信息",
     *   operationId="publishExchangeCreditsShopUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
     *   @SWG\Parameter(
     *     in="query",
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
    public function publishExchangeCreditsShop(Request $request){
        $user = auth()->user();
        $input = $request->all();
        #用户的积分
        $user_credit = intval($user->credits);
        if(array_key_exists('credit_service_id',$input)){
            #积分产品
            $credit_service = app('commonRepo')->creditsServiceRepo()->findWithoutFail($input['credit_service_id']);
            if(!empty($credit_service)){
                #积分产品的积分
                $credit_service_num = intval($credit_service->need_num);
                #用户兑换后的积分
                $user_update_credit = $user_credit - $credit_service_num;
                #判断积分是否够换产品
                if($user_update_credit < 0){
                    return zcjy_callback_data('您的积分不足以换该产品',1);
                }
                #积分产品的类型
                $type = $credit_service->type;
                #如果是服务 就要赠送服务
                if($type == '服务'){
                    $input['status'] = '待使用';
                    #对应的服务
                    $service = $credit_service->service()->first();
                    #给用户分发服务
                    app('commonRepo')->givenUserServices($user,$service);
                }
                else{
                    #如果是礼品 就要给予自提
                    $input['status'] = '待提货';
                }
                $input['snumber'] = ' ';
                $input['user_id'] = $user->id;
                $input['account'] = $user->account;
                #保存记录信息
                $order = app('commonRepo')->creditServiceUserRepo()->create($input);
                $order->update([
                    'snumber'=>9000000 + $order->id
                ]);

                #扣除用户的积分
                $user->update(['credits'=>$user_update_credit]);

                #添加积分记录
                app('commonRepo')->addCreditLog($user_credit , -$credit_service_num , '积分兑换积分产品' , 3 , $user->id);

                #添加积分商品消耗
                $credit_service->update(['count_time'=>$credit_service->count_time + 1]);

                #通知用户
                sendNotice($user->id,'您此次兑换了['.$credit_service->name.']的积分产品,消耗您'.$credit_service->need_num.'积分,当前积分为'.$user_update_credit,false);

                return zcjy_callback_data('兑换成功');
            }
            else{
            return zcjy_callback_data('该产品不存在',1);
            }
            #积分产品
        }
        else{
            return zcjy_callback_data('参数不正确',1);
        }

    }


    /**
     * 小程序获取充值金额列表
     *
     * @SWG\Get(path="/api/topup_list",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序获取充值金额列表",
     *   description="小程序获取充值金额列表,需要token信息",
     *   operationId="topupListUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
     *   @SWG\Parameter(
     *     in="query",
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
    public function topupList(Request $request){
       $account = $request->account;
       $topups = account(app('commonRepo')->topupGiftsRepo(),$account,true,$request->input('shop_id'))->get();
       #带上优惠券信息
       foreach ($topups as $key => $val) {
                $val['coupon'] = null;
            if(!empty($val->coupon_id)){
                $val['coupon'] = $val->coupon()->first();
            }
       }
       return zcjy_callback_data($topups);
    }

    
    /**
     * 小程序获取充值时输入金额返回对应充值福利
     *
     * @SWG\Get(path="/api/topup_input",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序获取充值时输入金额返回对应充值福利",
     *   description="小程序获取充值时输入金额返回对应充值福利,需要token信息",
     *   operationId="topupListUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
     *   @SWG\Parameter(
     *     in="query",
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
    public function topupInputPriceReturn(Request $request){
        $topup = app('commonRepo')->topupGiftsRepo()->minPriceReturn($request->input('shop_id'),$request->input('price'));
        #带上优惠券信息
        if(!empty($topup) && !empty($topup->coupon_id)){
             $topup['coupon'] = $topup->coupon()->first();
        }
        return zcjy_callback_data($topup);
    }

   
    /**
     * 小程序用户发起充值
     *
     * @SWG\Get(path="/api/topup_publish",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序用户发起充值",
     *   description="小程序用户发起充值,需要token信息",
     *   operationId="publishTopupUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
     *   @SWG\Parameter(
     *     in="query",
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
    public function publishTopup(Request $request){
        if(empty($request->input('price'))){
            return zcjy_callback_data('请输入充值金额',1);
        }

        $input = $this->attachUserIdAndAccountInput($request->all());

        $top_log = app('commonRepo')->topupLogRepo()->create($input);

        $user = auth()->user();
        #用户原来余额
        $user_money = $user->user_money;
        #加基本余额后
        $user_money_add_basic = $user_money + $top_log->price;
        /**
         * 充值成功给予用户加余额和其他特权
         */
        #加基本余额
        $user->update(['user_money'=> $user_money_add_basic]);
       
        #加优惠特权
        if(!empty($top_log->topup_id)){
            $topup = $top_log->topup()->first();
            #加上优惠特权后的余额
            $user_money_add_basic = $user_money_add_basic+$topup->give_balance;
            #送额外余额和积分
            $user->update(['user_money'=>$user_money_add_basic,'credits'=>$user->credits+$topup->give_credits]);
            #送优惠券
            if(!empty($topup->coupon_id)){
                $coupon = app('commonRepo')->couponRepo()->findWithoutFail($topup->coupon_id);
                if(!empty($coupon)){
                    app('commonRepo')->issueCoupon($user,$coupon,1,'充值赠送');
                }
            }
        }

        #给通知提示
        sendNotice($user->id,'您的充值已成功,当前余额'.$user_money_add_basic.',请在个人中心查看',false);

        return zcjy_callback_data('充值成功');
    }

    //为input提交值带上account信息和user_id
    private function attachUserIdAndAccountInput($input){
        $user = auth()->user();
        $input['account'] = $user->account;
        $input['user_id'] = $user->id;
        return $input;
    }
   
    /**
     * 小程序用户发起优惠买单
     *
     * @SWG\Get(path="/api/publish_discount_order",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序用户发起优惠买单",
     *   description="小程序用户发起优惠买单,需要token信息",
     *   operationId="publishDiscountOrderUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true
     *     ),
     *   @SWG\Parameter(
     *     in="query",
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
    public function publishDiscountOrder(Request $request){
        $input = $this->attachUserIdAndAccountInput($request->all());

        $discount_order = app('commonRepo')->discountOrderRepo()->create($input);

        return zcjy_callback_data('优惠买单成功');
    }

    /**
     * 小程序图片上传
     *
     * @SWG\Post(path="/api/manage/upload_images",
     *   tags={"小程序[后台管理]接口(https://qijianshen.xyz)"},
     *   summary="小程序图片上传",
     *   description="小程序图片上传接口,管理员可请求,需要token响应头信息",
     *   operationId="uploadImageAdmin",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="formData",
     *     name="file",
     *     type="file",
     *     description="上传文件对象",
           ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data图片的详情信息链接及上传时间",
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
    public function uploadImage(){
        $file =  Input::file('file');
        $user = auth()->user();
        return app('commonRepo')->uploadImages($file,'api',$user);
    }

        
    /**
     * 小程序统计接口
     *
     * @SWG\Get(path="/api/manage/statistics",
     *   tags={"小程序[后台管理]接口(https://qijianshen.xyz)"},
     *   summary="小程序统计",
     *   description="小程序统计接口,管理员业务员都可请求,需要token响应头信息",
     *   operationId="statisticsAdmin",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     required=true,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="time_type",
     *     type="string",
     *     description="统计方式 不传或者null => 按天统计 , week => 按星期统计 , month => 按月统计 , custom => 自定义时间段",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="shop_id",
     *     type="string",
     *     description="店铺id 不传=>统计所有店的 否则是单个店子的id标识",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="start_time",
     *     type="string",
     *     format="dateTime",
     *     description="开始时间 在time_type=custom的时候有效",
     *     required=false,
     *   ),
     *   @SWG\Parameter(
     *     in="query",
     *     name="end_time",
     *     type="string",
     *     format="dateTime",
     *     description="结束时间 在time_type=custom的时候有效",
     *     required=false,
     *   ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回统计数据列表其中sales是销量统计users是新增用户数",
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
    public function statistics(Request $request){
        $input = $request->all();
        $start_time = Carbon::today();
        $end_time = Carbon::tomorrow();

        #判断统计方式
        if(array_key_exists('time_type', $input)){

                if($input['time_type'] == 'week'){
                     $start_time = Carbon::today()->startOfWeek();
                }

                if($input['time_type'] == 'month'){
                     $start_time = Carbon::today()->startOfMonth();
                }

                if($input['time_type'] == 'custom'){
                     $start_time = Carbon::parse($input['start_time']);
                     $end_time  =  Carbon::parse($input['end_time']);
                }

        }

        if(!array_key_exists('shop_id',$input)){
            $input['shop_id'] = null;
        }

        #销量统计
        $sales = app('commonRepo')->statRepo()->rangeSaleStats($start_time,$end_time,$input['shop_id']);

        #新增用户
        $users = app('commonRepo')->statRepo()->rangeUserStats($start_time,$end_time);

        return zcjy_callback_data(['sales'=>$sales,'users'=>$users]);
    }


    
}
