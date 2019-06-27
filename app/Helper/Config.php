<?php
use Illuminate\Support\Facades\Config;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLevel;
use App\User;
use Illuminate\Support\Facades\Cache;

/**
 * [接口请求回转数据格式]
 * @param  type    $data     [成功/失败提示]
 * @param  integer $code     [0成功 1失败]
 * @param  string  $api      [默认不传是api格式 传web是web格式]
 * @return [type]            [description]
 */
function zcjy_callback_data($data=null,$code=0,$api='api'){
    return $api === 'api'
        ? api_result_data_tem($data,$code)
        : web_result_data_tem($data,$code);
}


/**
 * [api接口请求回转数据]
 * @param  [type]  $message  [成功/失败提示]
 * @param  integer $code     [0成功 1失败]
 * @return [type]            [description]
 */
function api_result_data_tem($data=null,$status_code=0){
     return ['status_code'=>$status_code,'data'=>$data];
}


/**
 * [web程序请求回转数据]
 * @param  [type]  $message  [成功/失败提示]
 * @param  integer $code     [0成功 1失败]
 * @return [type]            [description]
 */
function web_result_data_tem($message=null,$code=0){
    return ['code'=>$code,'message'=>$message];
}

/**
 * [通过shop_id获取shop对象]
 * @param  [type] $shop_id [description]
 * @return [type]          [description]
 */
function shop($shop_id){
    return optional(app('commonRepo')->shopRepo()->findWithoutFail($shop_id));
}

/**
 * [当前账户的所有店铺]
 * @return [type] [description]
 */
function now_shops(){
    return app('commonRepo')->shopRepo()->allAccountShop(admin()->account);
}   

/**
 * [当前登录的shopid]
 * @return [type] [description]
 */
function now_shop_id(){
    return session(admin()->id.'shop_id');
}
/**
 * 默认商户注册使用有效期(天)
 */
function shop_account_times(){
    return empty(getSettingValueByKey('reg_shop_account_timer','zcjy')) ? 14 : getSettingValueByKey('reg_shop_account_timer','zcjy');
}

//使用http还是https
function http(){
    return Config::get('domain.http') ? 'http://' : 'https://';
}

//域名
function domain($type="proxy"){
    return Config::get("domain.".$type."_domain");
}


/**
 * [把文字加粗并且变色]
 * @param  [type] $string [文字]
 * @param  string $color  [颜色 默认红色]
 * @return [type]         [description]
 */
function tag($string,$color='red'){
    return '&nbsp;&nbsp;<strong style=color:'.$color.'>'.$string.'</strong>&nbsp;&nbsp;';
}

/**
 * [把文字变成链接 并且带上颜色]
 * @param  [type]  $string [文字]
 * @param  [type]  $link   [链接]
 * @param  string  $color  [颜色 默认橙色]
 * @param  boolean $nbsp   [是否加左右间隔]
 * @return [type]          [description]
 */
function a_link($string,$link,$color='orange',$nbsp=true){
     return $nbsp ? '&nbsp;&nbsp;<a target=_blank href='.$link.' style=color:'.$color.'>'.$string.'</a>&nbsp;&nbsp;' : '<a target=_blank href='.$link.' style=color:'.$color.'>'.$string.'</a>';
}

/**
 *管理员组 根据type
 */
function admin_group($type){
    return Admin::where('type',$type)->get();
}

//当前商户下的用户
function user_group(){
    return User::where('account',admin()->account)->get();
}

//当前管理员/根据account/id索引admin账户信息
function admin($account=null,$attr=null){
    $admin=null;
    if(empty($account)){
         $admin = auth('admin')->user();
    }
    else{
         $admin = is_numeric($account) ? Admin::find($account): Admin::where('account',$account)->first();
    }

    if(!empty($attr)){
        $admin = Admin::where($attr,$account)->first();
    }

    #加上保险措施
    return empty($admin) ? optional($admin) : $admin;
}

//上一级管理员
function admin_parent($admin,$type=null){
    $admin = admin($admin->parent_id);
    return empty($type) ?  $admin :  $admin->type == $type ? $admin : null;
}

//检查登录跳转地址
function checkLoginPath(){
    #url前缀
    $prefix = http().domain();
    #如果没有登录就跳转回登录页
    if(!auth('admin')->check()){
        return redirect($prefix.'/zcjy/login');
    }
    $admin=admin();
    #对应角色跳对应页面
    #管理员
    if($admin->type == '管理员'){
        return redirect($prefix.'/zcjy/managers');
   
    }#代理商
    elseif($admin->type == '代理商'){
        return redirect($prefix.'/zcjy/shopManagers');
    }#商户
    else{

        if(admin()->shop_type){
            return redirect($prefix.'/zcjy/storeShops');
        }
        else{
            return redirect($prefix.'/zcjy/selectShopRedirect/'.admin()->shops()->first()->id);
        }
        
    }   
}

/**
 * 技师排班工作时间
 * @return [type] [description]
 */
function technicianWorkDay(){
    return [
    	'0'=>'星期天',
    	'1'=>'星期一',
    	'2'=>'星期二',
    	'3'=>'星期三',
    	'4'=>'星期四',
    	'5'=>'星期五',
    	'6'=>'星期六'
    ];
}

/**
 * 为input提交信息中附加account字段
 * @param  [array] $input [description]
 * @return [array]        [description]
 */
function attachAccoutInput($input){
    $input['account'] = admin()->account;
    $input['shop_id'] = now_shop_id();
    return $input;
}

/**
 * 预插入会员等级
 */
function createUserLevel(){
    #普通会员
    $user_level = UserLevel::create([
        'name' => '普通会员',
        'growth' => '0',
        'discount' => '100',
        'account' => admin()->account,
        'shop_id' => now_shop_id()
    ]);
    return  $user_level;
}

/**
 * 对应账户的对应模型的信息
 * @param  [Model object]  $obj  [description]
 * @param  boolean   $paginate   [description]
 * @param  boolean   $sort       [description]
 * @return [type]                [description]
 */
function accountInfo($obj,$paginate = true , $sort = 'desc'){
         if(!empty($obj)){
             $sort = $sort != 'desc' ? 'asc' : 'desc';
              return $paginate 
                ? $obj
                ->where('account',admin()->account)
                ->where('shop_id',now_shop_id())
                ->orderBy('created_at',$sort)
                ->paginate(defaultPage())
                : $obj
                ->where('account',admin()->account)
                ->where('shop_id',now_shop_id())
                ->orderBy('created_at',$sort)
                ->get();
     }
}

/**
 * [模型account索引]
 * @param  [type]  $obj       [description]
 * @param  [type]  $account   [description]
 * @param  boolean $need_shop [description]
 * @param  [type]  $shop_id   [description]
 * @return [type]             [description]
 */
function account($obj,$account=null,$need_shop=false,$shop_id=null){
        if(!empty($obj)){

            if(empty($account)){
                $account = admin()->account;
            }
            //需要shopid
            if($need_shop){
                if(empty($shop_id)){
                    $shop_id = now_shop_id();
                }
              return !empty(optional($obj)->model())
                ? 
                ($obj->model())::where('account',$account)
                ->where('shop_id',$shop_id)
                : 
                $obj::where('account',$account)
                ->where('shop_id',$shop_id);
            }//不需要shopid
            else{
            return !empty(optional($obj)->model())
                ? ($obj->model())::where('account',$account)
                : $obj::where('account',$account);
            }
                
         }
         else{
            return [];
         }
}

/**
 * [模型默认分页]
 * @param  [type] $obj  [description]
 * @param  [type] $page [description]
 * @return [type]       [description]
 */
function paginate($obj,$page=null){
    return empty($page) ? $obj->paginate(defaultPage()) : $obj->paginate($page);
}

/**
 * [初始化查询索引状态]
 * @param  [Repository / Model] $obj [description]
 * @return [type]                    [description]
 */
function defaultSearchState($obj){
         if(!empty($obj)){
            return !empty(optional($obj)->model())
                ?($obj->model())::where('id','>',0)
                :$obj::where('id','>',0);
         }else{
            return [];
         }
}




