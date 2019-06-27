<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests;
use Illuminate\Support\Facades\Config;
use App\Models\Cities;
use App\Models\Setting;
use App\Models\Product;
use App\User;

use App\Repositories\BannerRepository;

/**
 * 获取商品信息
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function getProductById($id){
    return Product::find($id);
}

/**
 * 通过商品的id设置显示对应的服务列表
 * @param  [type] $product_id [description]
 * @return [type]             [description]
 */
function setProductServiceHtml($product_name){
    $product = Product::where('name',$product_name)->first();
    $service_html =null;
    if(!empty($product)){
        $services = $product->services()->get();
        if(count($services)){
            foreach ($services as $k => $service) {
               $service_html .= '&nbsp;&nbsp;<a href='.route('services.edit', [$service->id]).' target=_blank>'.$service->name.'</a>';
            }
        }
    }
    return $service_html;
}

/**
 * 获取用户信息
 */
function getUserById($id){
    return User::find($id);
}

/**
 * 获取文章的收藏状态
 * @param  [type] $product_id [description]
 * @return [type]             [description]
 */
function getCollectionStatus($product_id){
    $user = auth('web')->user();
    return $user->collections()->whereRaw('products.id = '.$product_id)->count();
}

//通过银行名字获取图片
function getBankImgByName($bank_name){

    $bankinfo = BankSets::where('name',$bank_name)->first();
    if(empty($bankinfo)){
        return null;
    }else{
        return $bankinfo->img;
    }
}

//优化分类选择
function varifiedCatName($cat_repo_obj){
    if(empty($cat_repo_obj)){
        return '请选择分类';
    }else{
        return $cat_repo_obj->name;
    }
}

//通过admin对象验证路由权限
function varifyAllRouteByAdminObj($admin,$uri){
    $roles=$admin->roles()->get();
    $status=false;
    if(!empty($roles)) {
        foreach ($roles as $item) {
            $perms = $item->perms()->where('name','like','%'.'*'.'%')->get();
            //dd($perms);
            if(!empty($perms)){
                foreach($perms as $perm){
                    //|| strpos($uri,substr($perm->name,0,strlen($perm->name)-5))!==false
                    if(strpos($uri,substr($perm->name,0,strlen($perm->name)-2))!==false){
                        $status=true;
                    }
                }
            }
        }
        return $status;
    }else{
        return false;
    }
}

//通过路由名验证当前登录管理员是否有权限
function varifyAdminPermByRouteName($route_name){
    $admin=Auth::guard('admin')->user();
    $status_perm=true;
    if (!$admin->can($route_name)) {
           // if(!varifyAllRouteByAdminObj($admin,$route_name)) {
                $status_perm=false;
           // }
    }
    return $status_perm;
}

//自动根据tid匹配功能分组或者返回功能个数
function autoMatchRoleGroupNameByTid($tid,$get_length=true){
    $group_func=Config::get('rolesgroupfunc');
    $match_attr=[];
    $length=1;
    foreach ($group_func as $item){
        if($item['tid']==$tid){
            array_push($match_attr,$item['word']);
            $length=$item['length'];
        }
    }
    if($get_length) {
        return $length;
    }else{
        return count($match_attr)?$match_attr[0]:'未命名';
    }
}


//根据pid获取上级地区的路由
function varifyPidToBackByPid($pid){
    $parent_cities=Cities::find($pid);
    if($parent_cities->level==1){
        return route('cities.index');
    }else{
        $back_cities=Cities::find($pid)->ParentCitiesObj;
        if(!empty($back_cities)) {
            return route('cities.child.index', [$back_cities->id]);
        }
    }
}

//自动匹配计算方式
function varifyFreightTypeByTypeId($type_id){
    if($type_id==0){
        return '件数';
    }elseif ($type_id==1){
        return '重量';
    }elseif ($type_id==2){
        return '体积';
    }
}

//根据地区id返回对应运费模板信息
function getFreightInfoByCitiesId($cities_id){
    $city=Cities::find($cities_id);
    if(!empty($city)) {
        $freigt_tem = $city->freightTems()->get();
        if (!empty($freigt_tem)) {
            $freigt_tem_arr = [];
            $i = 0;
            foreach ($freigt_tem as $item) {
                $freight_type = $item->pivot->freight_type;
                $freight_first_count = $item->pivot->freight_first_count;
                $the_freight = $item->pivot->the_freight;
                $freight_continue_count = $item->pivot->freight_continue_count;
                $freight_continue_price = $item->pivot->freight_continue_price;
                $freigt_tem_arr[$i] = ['name'=>$item->name,'use_default'=>$item->SystemDefault,'freight_type' => $freight_type, 'freight_first_count' => $freight_first_count, 'the_freight' => $the_freight, 'freight_continue_count' => $freight_continue_count, 'freight_continue_price' => $freight_continue_price];
                $i++;
            }
            return $freigt_tem_arr;
        } else {
            return null;
        }
    }else{
        return null;
    }
}

//根据菜单类型返回索引参数
function varifyOrderType($order_type_word){
    $str='?menu_type=';
    if($order_type_word=='秒杀订单'){
        $str .='1';
    }elseif($order_type_word=='拼团订单'){
        $str .='5';
    }elseif($order_type_word=='发货单'){
        $str .='6';
    }
    return $str;

}

//根据优惠券的状态参数返回详细文本
function varifyCouponStatus($status){
    if($status==0){
        return '立即使用';
    }elseif ($status==1){
        return '已冻结';
    }elseif ($status==2){
        return '已使用';
    }elseif ($status==3){
        return '已过期';
    }elseif ($status==4){
        return '已作废';
    }
}


/**
 * 根据ID获取城市信息
 * @param  [type] $cities_id [description]
 * @return [type]            [description]
 */
function getCitiesNameById($cities_id)
{
    $city=Cities::find($cities_id);
    if(!empty($city)) {
        return $city->name;
    }else{
        return null;
    }
}


function getUsersWhetherHaveCoupons($coupons_id){
    $user = auth('web')->user();
    return $user->coupons()->whereRaw('coupon_users.id = '.$coupons_id)->where('from_way', '手动领取')->count();
}

/**
 * 邮件设置
 * @param  [type] $mail_name [description]
 * @return [type]            [description]
 */
function autoVarifyMailName($mail_name){
    if($mail_name=='email_host'){
        return 'MAIL_HOST';
    }elseif ($mail_name=='email_port'){
        return 'MAIL_PORT';
    }elseif($mail_name=='email_username'){
        return 'MAIL_USERNAME';
    }elseif ($mail_name=='email_password'){
        return 'MAIL_PASSWORD';
    }elseif ($mail_name=='email_encrypt'){
        return 'MAIL_ENCRYPTION';
    }elseif ($mail_name=='order_notify_email'){
        return 'MAIL_ENCRYPTION';
    }
}

//库存报警
function varifyInventory($inventory){
    $inventory_warn=empty(getSettingValueByKey('inventory_warn'))?0:getSettingValueByKey('inventory_warn');
    if($inventory==-1){
        return '无限';
    }
    if($inventory<=$inventory_warn){
        return "<small class='label label-danger'>警</small>".$inventory;
    }else{
        return $inventory;
    }
}

/**
 * 营销活动状态
 * @param  [type] $prom_type [description]
 * @return [type]            [description]
 */
function varifyCuXiao($prom_type){
    if($prom_type==0 || empty($prom_type)){
        return '无';
    }elseif ($prom_type==1){
        return '秒杀抢购中';
    }elseif ($prom_type==2){
        return '团购中';
    }
    elseif ($prom_type==3){
        return '促销中';
    }
    elseif ($prom_type==4){
        return '订单促销中';
    }
    elseif ($prom_type==5){
        return '拼团中';

    }
}

/**
 * 验证是否展开
 * @return [int] [是否展开tools 0不展开 1展开]
 */
function varifyTools($input,$order=false){
    $tools=0;
    if(count($input)){
        $tools=1;
        if(array_key_exists('page', $input) && count($input)==1) {
            $tools = 0;
        }
        if($order){
            if(array_key_exists('menu_type', $input) && count($input)==1) {
                $tools = 0;
            }
        }
    }
    return $tools;
}

/**
 * 倒序分页显示
 * @parameter [object]
 * @return [array] [desc]
 */
function descAndPaginateToShow($obj){
    if(!empty($obj)){
      return  $obj->orderBy('created_at','desc')->paginate(defaultPage());
    }else{
        return [];
    }
}

/**
 * 默认分页数量
 * @parameter []
 * @return [int] [每页显示数量]
 */
function defaultPage(){
    return empty(getSettingValueByKey('records_per_page')) ? 15 : getSettingValueByKey('records_per_page');
}


/**
 * 根据ID获取用户信息
 * @param  [type] $id [description]
 * @return [type]     [description]
 */
function user($id)
{
    return Cache::remember('user_'.$id, Config::get('web.cachetime'), function() use ($id) {
        return User::where('id', $id)->first();
    });
}


/**
 * 根据banner别名获取BANNER
 * @param  [type] $slug [description]
 * @return [type]       [description]
 */
function banners($slug)
{
    $bannerRepo = app('commonRepo')->bannerRepo();
    $banners = $bannerRepo->getBannerCached($slug);
    return $banners;
}

/**
 * 国家馆
 * @return [type] [description]
 */
function countries()
{
    $countryRepo = app('commonRepo')->countryRepo();
    return $countryRepo->countriesCached();
}

/** 
 * 一级分类
 */
function cat_level01()
{
    $categoryRepo = app('commonRepo')->categoryRepo();
    return $categoryRepo->getRootCategoriesCached();
}

/**
 * 二级分类
 * @param  [type] $parent_id [description]
 * @return [type]            [description]
 */
function cat_level02($parent_id)
{
    $categoryRepo = app('commonRepo')->categoryRepo();
    return $categoryRepo->getChildCategories($parent_id);
}

/**
 * 拼团商品
 */
function teamSale($skip, $take)
{
    return app('commonRepo')->teamSaleRepo()->getTeamSales($skip, $take);
}
/**
 * 秒杀商品
 */
function flashSale($skip, $take){
    return app('commonRepo')->flashSaleRepo()->salesBetweenTime($skip, $take);
}
/**
 * 商品
 */
function products($skip, $take)
{
    return app('commonRepo')->productRepo()->products($skip, $take);
}
/**
 * 新品
 */
function newProducts($skip, $take)
{
    return app('commonRepo')->productRepo()->newProducts($skip, $take);
}
/**
 * 促销商品
 * @param  [type] $skip [description]
 * @param  [type] $take [description]
 * @return [type]       [description]
 */
function prompProducts($skip, $take)
{
    return app('commonRepo')->productRepo()->productsOfCurPromp($skip, $take);
}
/**
 * 通知消息
 * @return [type] [description]
 */
function notices()
{
    return app('commonRepo')->noticeRepo()->notices();
}

function notice($id)
{
    return app('commonRepo')->noticeRepo()->notice($id);
}