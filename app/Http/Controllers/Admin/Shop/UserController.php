<?php

namespace App\Http\Controllers\Admin\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Models\UserLevel;
use App\Repositories\UserRepository;
use App\Repositories\CreditLogRepository;
use Config;
use Log;
use App\Models\Order;

class UserController extends Controller
{
    private $userRepository;
    private $creditLogRepository;

    public function __construct(UserRepository $userRepo, CreditLogRepository $creditLogRepo)
    {
        $this->userRepository = $userRepo;
        $this->creditLogRepository = $creditLogRepo;
    }

    public function index(Request $request)
    {
        $input=$request->all();
        $users=User::where('id','>','0');
        $page_list=false;
        $tools=1;

        if(array_key_exists('nickname',$input) && !empty($input['nickname'])){
            $users=$users->where('nickname','like','%'.$input['nickname'].'%');
        }
        if(array_key_exists('user_level',$input) && !empty($input['user_level'])){
            $users=$users->where('user_level',$input['user_level']);
        }
        if(array_key_exists('price_sort',$input)){
            $users=$users->orderBy('consume_total', $input['price_sort'] == 0 ? 'asc' :'desc'); 
        }
        if(array_key_exists('mobile',$input)&& !empty($input['mobile']) ){
            $users=$users->where('mobile','like','%'.$input['mobile'].'%');
        }
        if(array_key_exists('page_list',$input)&& !empty($input['page_list']) ){
            $page_list=$input['page_list'];
        }
        if($page_list){
            $users = $users->paginate($page_list);
        }else{
            $users=$users->paginate(getSettingValueByKey('records_per_page'));
        }

        $users_level=UserLevel::all();

    	return view('admin.user.index', compact('tools','users','users_level','input'));
    }

    /**
     * 显示用户详情
     * @Author   yangyujiazi
     * @DateTime 2018-03-15
     * @param    [type]      $id [description]
     * @return   [type]          [description]
     */
    public function show(Request $request,$id)
    {
        $input = $request->all();

        $user = User::where('id', $id)->first();
        if (empty($user)) {
            return redirect('/zcjy/users');
        }
        $userLevel = UserLevel::where('id', $user->user_level)->first();

        $share_img = null;
        if (Config::get('web.app_env') == 'product') {
            $share_img = $this->userRepository->erweima($user);
        }
        //订单列表
        //$orders = $this->userRepository->orderOfUser($user);
        $orders = Order::where('user_id', $id)->where('order_pay', '已支付')->orderBy('created_at', 'desc')->paginate(18);
        //服务列表
        $services = $user->services()->orderBy('created_at','desc')->paginate(18);
        //附加适用店铺信息
        foreach ($services as $key => $service) {
            $service['shops'] = $service->shops()->get();
        }
        //未读消息
        $unreadMessages = allNotices($user->id,true,false);
        //余额记录
        $funds = $this->userRepository->moneyLogs($user);
        //积分记录
        $credits = $this->creditLogRepository->creditLogs($user);

        return view('admin.user.show', compact('input','user','userLevel', 'share_img', 'orders', 'services' , 'unreadMessages' , 'funds', 'credits'));
    }

    /**
     * 冻结用户
     * @Author   yangyujiazi
     * @DateTime 2018-03-15
     * @param    [type]      $user_id [description]
     * @return   [type]               [description]
     */
    public function freezeUserById($user_id){
        $user=$this->userRepository->findWithoutFail($user_id);
        if(!empty($user)){
            $user_status=$user->status;
            //如果已经冻结
            if($user_status){
                $user->update(['status'=>0]);
                return ['code'=>1,'message'=>'取消冻结成功'];
            }else{
                $user->update(['status'=>1]);
                return ['code'=>0,'message'=>'冻结成功'];
            }
        }else{
            return ['code'=>2,'message'=>'没有该用户'];
        }
    }

    public function distributeUser($user_id)
    {
        $user=$this->userRepository->findWithoutFail($user_id);
        if(!empty($user)){
            if($user->is_distribute){
                $user->update(['is_distribute'=>0]);
                return ['code'=>1,'message'=>'用户取消分销资格'];
            }else{
                $user->update(['is_distribute'=>1]);
                return ['code'=>0,'message'=>'用户已成为分销商'];
            }
        }else{
            return ['code'=>2,'message'=>'没有该用户'];
        }
    }

   /**
     * 修改用户积分
     * @Author   HipePeng
     * @DateTime 2018-03-19
     * @UpdateTime
     * @param   ($user_id,$credits_change)[用户id,积分变动值]
     * @return  (code,message)            [code=>0成功1失败,操作后的提示消息]
     */
    public function updateUserCredits(Request $request,$user_id){
       $user=$this->userRepository->findWithoutFail($user_id);
       $credits_change=(float)$request->input('credits_change');

       $credits_final=(float)($user->credits)+$credits_change;

       if(!empty($user)){
           if($credits_final<0){
                return ['code'=>1,'message'=>'积分变动后不能为负数'];
            }
            $user->update([
            'credits'=>$credits_final
            ]);
            $detail='管理员操作变动积分:'.$credits_change;
          app('commonRepo')->addCreditLog($credits_final,$credits_change,$detail,4,$user_id);
          return ['code'=>0,'message'=>'操作成功'];
        }else{
          return ['code'=>1,'message'=>'没有该用户'];
        }
    }


   /**
     * 修改用户余额
     * @Author   HipePeng
     * @DateTime 2018-03-19
     * @UpdateTime
     * @param   ($user_id,$money_change)[用户id,余额变动值]
     * @return  (code,message)          [code=>0成功1失败,操作后的提示消息]
     */
    public function updateUserMoney(Request $request,$user_id){
       $user=$this->userRepository->findWithoutFail($user_id);
       $money_change=(float)$request->input('money_change');

       $user_money_final=(float)$user->user_money+$money_change;

       if(!empty($user)){
            if($user->user_money+$money_change<0){
                return ['code'=>1,'message'=>'余额变动后不能为负数'];
            }
            $user->update([
             'user_money'=>$user_money_final
            ]);
            $detail='管理员操作变动余额:'.$money_change;
          app('commonRepo')->addMoneyLog($user_money_final,$money_change,$detail,4,$user_id);
          return ['code'=>0,'message'=>'操作成功'];
       }else{
          return ['code'=>1,'message'=>'没有该用户'];
        }
    }
}
