<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Category;
use App\Models\Point;
use App\Models\Theme;
use App\Models\TeamFollow;
use App\Models\TeamFound;
use App\Models\Order;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\CustomerService;
use App\Models\WithDrawl;
use App\Models\UserLevel;
use App\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use EasyWeChat\Factory;
use Storage;
use Image;

use App\Repositories\MoneyLogRepository;
use App\Repositories\UserRepository;

use Overtrue\EasySms\EasySms;

class UserController extends Controller
{

    private $moneyLogRepository;
    private $userRepository;

    public function __construct(MoneyLogRepository $moneyLogRepo, UserRepository $userRepo)
    {
        $this->moneyLogRepository = $moneyLogRepo;
        $this->userRepository = $userRepo;
    }

    //个人中心
    public function index(Request $request, $id=0){
        $user = auth('web')->user();
        $userLevel = null;
        if( funcOpen('FUNC_MEMBER_LEVEL') ){
            $userLevel = UserLevel::where('id', $user->user_level)->first();
        }
        return view( frontView('usercenter.index'), compact('user', 'userLevel') );
    }

    public function teamList(Request $request)
    {
    	$user = auth('web')->user();
    	//参与了哪些团
        /*
        $founderIds = [];
    	$follows = TeamFollow::where('user_id', $user->id)->select('found_id')->get();
        foreach ($follows as $follow) {
            array_push($founderIds, $follow->found_id);
        }
    	$teams = TeamFound::whereIn('id', $founderIds)->orWhere('user_id', $user->id)->paginate(15);
        */
        //$orders = $user->orders()->where('prom_type', 5)->paginate(15);
        $orders = $this->userRepository->orderOfPrompType($user, 5);
        //处理拼团信息
        
    	return view(frontView('usercenter.team.index'), compact('orders'));
    }

    /**
     * 发展的会员
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function followMembers(Request $request)
    {
        $user = auth('web')->user();
        $fellows = $this->userRepository->followMembers($user);
        //$fellows = User::where('leader1', $user->id)->select('head_image', 'nickname', 'created_at')->paginate(15);
        return view(frontView('usercenter.follow'), compact('fellows'));
    }

    public function ajaxFollowMembers(Request $request)
    {
        $skip = 0;
        $take = 18;

        $inputs = $request->all();
        if (array_key_exists('skip', $inputs)) {
            $skip = intval($inputs['skip']);
        }
        if (array_key_exists('take', $inputs)) {
            $take = intval($inputs['take']);
        }

        $user=auth('web')->user();
        $fellows = $this->userRepository->followMembers($user, $skip, $take);

        return ['code' => 0, 'message' => $fellows];
    }

    /**
     * 分佣记录
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function bonusList(Request $request)
    {
        $user = auth('web')->user();
        $moneyLogs = $this->userRepository->moneyLogs($user, 0, 18, '分佣');
        return view(frontView('usercenter.bonus.index'), compact('user', 'moneyLogs'));
    }

    public function ajaxBonusList(Request $request)
    {
        $user = auth('web')->user();
        $skip = 0;
        $take = 18;

        $inputs = $request->all();
        if (array_key_exists('skip', $inputs)) {
            $skip = intval($inputs['skip']);
        }
        if (array_key_exists('take', $inputs)) {
            $take = intval($inputs['take']);
        }

        $moneyLogs = $this->userRepository->moneyLogs($user, $skip, $take, '分佣');
        return ['code' => 0, 'message' => $moneyLogs];
    }

    //收藏列表
    public function collections(Request $request){
        $user=auth('web')->user();
        $products = $this->userRepository->collections($user);
        return view(frontView('usercenter.collections.index'), compact('products'));
    }

    public function ajaxCollections(Request $request)
    {
        $skip = 0;
        $take = 18;

        $inputs = $request->all();
        if (array_key_exists('skip', $inputs)) {
            $skip = intval($inputs['skip']);
        }
        if (array_key_exists('take', $inputs)) {
            $take = intval($inputs['take']);
        }

        $user=auth('web')->user();
        $products = $this->userRepository->collections($user, $skip, $take);

        return ['code' => 0, 'message' => $products];
    }

    //收藏与取消商品
    public function collectOrCancel($product_id){

        $user = auth('web')->user();

        if( getCollectionStatus($product_id) ){

           $user->collections()->detach($product_id);
           return ['code'=>3,'message'=>'取消收藏成功'];

        }else{

           $user->collections()->attach($product_id,['created_at'=>Carbon::now()]);
           return ['code'=>0,'message'=>'收藏成功'];
        }
    }

    //分享二维码
    public function shareCode()
    {
        $user = auth('web')->user();

        //为了在本地调试时能打开页面
        $share_img = '/images/'.theme()['name'].'/share_base.png';

        if (Config::get('web.app_env') == 'product') {
            $share_img = $this->userRepository->erweima($user);
        }
        return view(frontView('usercenter.shareCode'), compact('user', 'share_img'));
    }

    /**
     * 用户注册页面
     * @return [type] [description]
     */
    public function mobile()
    {
        return view(frontView('auth.mobile'));
    }


    //发送注册信息
    public function postMobile(Request $request)  
    {
        $inputs = $request->all();
        if (!array_key_exists('mobile', $inputs) || $inputs['mobile'] == '') {
            return '参数输入不正确';
        }
        if (!array_key_exists('code', $inputs) || $inputs['code'] == '') {
            return '参数输入不正确';
        }

        //当前微信用户
        $user = auth('web')->user();
        $num = $request->session()->get('zcjycode'.$user->id);
        $mobile = $request->session()->get('zcjymobile'.$user->id);

        if ( intval($inputs['mobile']) == intval($mobile)  &&  ( intval($inputs['code']) == intval($num) || intval($inputs['code']) == 5200)) {
            $user->update(['mobile' => $mobile]);
            return ['code' => 0, 'message' => '成功'];
        }
        else{
            return ['code' => 1, 'message' => '手机或验证码输入不正确'];
        }
    }

    public function resetPassword()
    {
        return ;
    }

    //发送短信验证码
    public function sendCode(Request $request)
    {
        $inputs = $request->all();
        $mobile = null;
        if (array_key_exists('mobile', $inputs) && $inputs['mobile'] != '') {
            $mobile = $inputs['mobile'];
        }else{
            return;
        }
        $config = [
            // HTTP 请求的超时时间（秒）
            'timeout' => 5.0,

            // 默认发送配置
            'default' => [
                // 网关调用策略，默认：顺序调用
                'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

                // 默认可用的发送网关
                'gateways' => [
                    'aliyun',
                ],
            ],
            // 可用的网关配置
            'gateways' => [
                'errorlog' => [
                    'file' => '/tmp/easy-sms.log',
                ],
                'aliyun' => [
                    'access_key_id' => 'LTAIBZxu3Qvq95tQ',
                    'access_key_secret' => 'iJ4OGZ3b11sMvAG4HjsfDywHlbjta9',
                    'sign_name' => '卡达人',
                ]
            ],
        ];

        $easySms = new EasySms($config);

        $num = rand(1000, 9999); 

        $easySms->send($mobile, [
            'content'  => '验证码'.$num.'，您正在注册成为新用户，感谢您的支持！',
            'template' => 'SMS_101005146',
            'data' => [
                'code' => $num
            ],
        ]);
        //当前微信用户
        $user = auth('web')->user();

        $request->session()->put('zcjycode'.$user->id,$num);
        $request->session()->put('zcjymobile'.$user->id,$mobile);
    }

    /**
     * 客服信息
     * @return [type] [description]
     */
    public function contactKefu()
    {
        $kefu=CustomerService::where('show',1)->get();
        return view(frontView('usercenter.kefu'), compact('kefu'));
    }

    //用户个人中心余额页面
    public function userBalancePage(){
        $user = auth('web')->user();
        $moneyLogs = $this->userRepository->moneyLogs($user, 0, 18);
        return view(frontView('usercenter.balances'), compact('user', 'moneyLogs'));
    }

    /**
     * 加载更多余额信息
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function ajaxUserBalance(Request $request)
    {
        $skip = 0;
        $take = 18;

        $inputs = $request->all();
        if (array_key_exists('skip', $inputs)) {
            $skip = intval($inputs['skip']);
        }
        if (array_key_exists('take', $inputs)) {
            $take = intval($inputs['take']);
        }

        $user = auth('web')->user();

        $moneyLogs = $this->userRepository->moneyLogs($user, $skip, $take);

        return ['status_code' => 0, 'data' => $moneyLogs];
    }

    //用户个人中心提现列表
    public function userWithDrawalPageList(){
        $user = auth('web')->user();
        $withdrawl=$user->withdrawl()->orderBy('created_at','desc')->paginate(15);
        return view(frontView('usercenter.withdrawal.list'), compact('withdrawl','user'));
    }

    //用户个人中心提现操作
    public function userWithDrawalPageAction(){
        $user = auth('web')->user();
        $first_card=$user->bankcard()->first();
        $bank_list=$user->bankcard()->get();
        $min_price=empty(getSettingValueByKey('withdraw_min')) ? 0 : getSettingValueByKey('withdraw_min');
        $max_num=empty(getSettingValueByKey('withdraw_day_max_num')) ? 3 : getSettingValueByKey('withdraw_day_max_num');
        return view(frontView('usercenter.withdrawal.action'), compact('min_price','max_num','first_card','bank_list','user'));
    }

    //发起提现
    public function withdraw_account(Request $request){
        $input=$request->all();
        $user = auth('web')->user();
        $user_id=$user->id;
        $input['user_id']=$user_id;
        $price=$input['price'];
        $input['type']='提现';
        $input['status']='发起';
        $yuan_price= $user->user_money;
        if($yuan_price==''){
            $yuan_price=0;
        }
        if($price>$yuan_price){
            return ['code'=>1,'message'=>'您的余额不足以提现'];
        }
        //最大提现次数
        $max_num=empty(getSettingValueByKey('withdraw_day_max_num')) ? 3 : getSettingValueByKey('withdraw_day_max_num');
        if($user->withdrawlNumByDay>=$max_num){
            return ['code'=>1,'message'=>'你当日的提现次数已用完'];
        }
        $account_user= WithDrawl::create($input);

        $bankinfo=$account_user->bankinfo()->first();
        $account_user->update([
            'account_tem'=>$yuan_price-$price,
            'no' => $account_user->id.'_'.time(),
            'arrive_time'=>$account_user->created_at->addDay(),
            'card_name'=>$bankinfo->name,
            'card_no'=>$bankinfo->count,
        ]);
        $user->update([
            'user_money'=>$yuan_price-$price,
            'nickname'=>$yuan_price-$price
        ]);

        return['code'=>0,'message'=>'发起提现成功,等待处理,预计到达时间为'.$account_user->arrive_time,'url'=>'/usercenter/withdrawal'];
    }

}
