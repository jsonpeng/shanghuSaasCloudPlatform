<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests;
use Illuminate\Support\Facades\Config;
use App\Models\Admin;
use QL\QueryList;
use Carbon\Carbon;

function getAdminPackageStatus(){
        $status = '续费';
        #当前商户的套餐
        $package = admin()->package()->first();
        if($package->level == 0 || app('commonRepo')->adminPackageRepo()->varifyOverdue(admin())){
            $status = '购买';
        }
        #当前管理员的店铺
        $shops = account(app('commonRepo')->shopRepo())->get();
        return [
            'package'=>$package,
            #状态名称
            'status_name'=>$status,
            #等级
            'level' =>optional($package)->level,
            #小于0就过期
            'time' => count_time_days($package->package_endtime),
            'shops' => $shops
        ];
}

/**
 * [计算剩余天数小于0就过期]
 * @param  [type] $time [description]
 * @return [type]       [description]
 */
function count_time_days($time){
    return  -(Carbon::parse($time)->startOfDay()->diffInDays(Carbon::now()->startOfDay(),false));
}

/**
 * [获取回车的列表]
 * @param  [type] $list [description]
 * @return [type]       [description]
 */
function getList($list){
      $list= preg_replace("/\n|\r\n/", "_",$list);
      $list_arr = explode('_',$list);
      return $list_arr;
}

/** 
 * [获取两个不同经纬度之间的距离]
 * @param int $lng1 经度1 
 * @param int $lat1 纬度1 
 * @param int $lng2 经度2 
 * @param int $lat2 纬度2 
 * @return string(单位km) 
 */  
function getDistance($lng1=0,$lat1=0,$lng2=0,$lat2=0)  
{  
    //$url = http().domain().'/settings/map?jindu1='.$lat1.'&weidu1='.$lng1.'&jindu2='.$lat2.'&weidu2='.$lng2;
    $url = 'http://api.map.baidu.com/routematrix/v2/riding?output=json&origins='.$lat1.','.$lng1.'&destinations='.$lat2.','.$lng2.'&ak=usHzWa4rzd22DLO58GmUHUGTwgFrKyW5';
    $data = file_get_contents($url);
    $data = json_decode($data,true);
    $data = optional($data);
    $distance = str_replace('公里','',$data['result'][0]['distance']['text']);
    return $distance; 
}

/**
 * [地图逆解析 根据经纬度获取地址详情]
 * @param  [type] $jindu [description]
 * @param  [type] $weidu [description]
 * @return [type]        [description]
 */
function getAddressLocation($jindu,$weidu){
    $address = file_get_contents('http://api.map.baidu.com/geocoder/v2/?callback=renderReverse&location='.$weidu.','.$jindu.'&output=json&pois=1&ak=usHzWa4rzd22DLO58GmUHUGTwgFrKyW5');
    $address = explode(',',$address); 
    $sub_address = substr($address[3],21);
    $sub_address =substr($sub_address,0,strlen($sub_address)-1); 
    return $sub_address;
}  

/**
 * 获取设置信息
 * @param  [type] $key [description]
 * @return [type]      [description]
 */
function getSettingValueByKey($key,$zcjy=null,$api=false,$shop_id=null){
    return app('setting')->valueOfKey($key,$zcjy,$api,$shop_id);
}


function getSettingValueByKeyCache($key){
    return Cache::remember('getSettingValueByKey'.$key, Config::get('web.cachetime'), function() use ($key){
        return empty(getSettingValueByKey($key)) ? 0 : getSettingValueByKey($key);
    });
}

/**
 * 获取主题设置
 * @return [array] [theme setting]
 */
function theme()
{
    if(empty(admin())){
      return [
        'name' => 'default'];
    }
    $themes = Config::get('zcjytheme.theme');
    $themeName = app('setting')->valueOfKey('theme');
    if (empty($themeName)) {
        $themeName = 'default';
    }
    foreach ($themes as $theme) {
        if ($theme['name'] == $themeName) {
            return $theme;
        }
    }
    return [
        'name' => 'default',
        'parent' => 'default',
        'display_name' => '默认主题',
        'image' => 'themes/default/cover.png',
        'des' => '默认主题',
        'maincolor' => '#ff4e44',
        'secondcolor' => '#84d4da'
    ];
}

/**
 * 主色调
 * @return [type] [description]
 */
function themeMainColor()
{
    $theme_maincolor = app('setting')->valueOfKey('theme_main_color');
    if (empty($theme_maincolor)) {
        return theme()['maincolor'];
    }
    return $theme_maincolor;
}

/**
 * 次色调
 * @return [type] [description]
 */
function themeSecondColor()
{
    $theme_secondcolor = app('setting')->valueOfKey('theme_second_color');
    if (empty($theme_secondcolor)) {
        return theme()['secondcolor'];
    }
    return $theme_secondcolor;
}

/**
 * 前端页面路径
 * @param  [type] $name [description]
 * @return [type]       [description]
 */
function frontView($name)
{
    $themeSetting = theme();
    if (view()->exists('front.'.theme()['name'].'.'.$name)) {
        return 'front.'.theme()['name'].'.'.$name;
    }else{
        if (view()->exists('front.'.theme()['parent'].'.'.$name)) {
            return 'front.'.theme()['parent'].'.'.$name;
        }else{
            
            return 'front.default.'.$name;
        }
    }
}


/**
 * 功能是否被打开 （需要系统 和商家同时开启该功能）
 * @param  [type] $func_name [description]
 * @return [type]            [description]
 */
function funcOpen($func_name,$zcjy=null,$api=false)
{
    $config  = Config::get('web.'.$func_name);
    if ($config && sysOpen($func_name,$zcjy,$api)) {
        return true;
    }else{
        return false;
    }
    //return empty($config) ? false : $config;
}

function funcOpenCache($func_name)
{
    return Cache::remember('funcOpen'.$func_name, Config::get('web.cachetime'), function() use ($func_name){
        return funcOpen($func_name);
    });
}

/**
 * 商家自己控制功能是否打开
 * @param  [type] $func_name [description]
 * @return [type]            [description]
 */
function sysOpen($func_name,$zcjy=null,$api=false)
{
    $config  = intval( getSettingValueByKey($func_name,$zcjy,$api) );
    return empty($config) ? false : true;
}

function sysOpenCache($func_name)
{
    return Cache::remember('sysOpen'.$func_name, Config::get('web.cachetime'), function() use ($func_name){
        return sysOpen($func_name);
    });
}


//将时间处理成以偶数小时开头，分跟秒为0的时间
function processTime($cur_time)
{
    // if ($cur_time->hour%2) {
    //     $cur_time->subHour();
    // }
    $cur_time->hour = 0;
    $cur_time->minute = 0;
    $cur_time->second = 0;
    return $cur_time;
}


/**
 * 笛卡尔积
 * @return [type] [description]
 */
function combineDika() {
    $data = func_get_args();
    $data = current($data);
    $cnt = count($data);
    $result = array();
    $arr1 = array_shift($data);
    foreach($arr1 as $key=>$item) 
    {
        $result[] = array($item);
    }       

    foreach($data as $key=>$item) 
    {                                
        $result = combineArray($result,$item);
    }
    return $result;
}

/**
 * 数组转对象
 * @param  [type] $d [description]
 * @return [type]    [description]
 */
function arrayToObject($d) {
    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return (object) array_map(__FUNCTION__, $d);
    }
    else {
        // Return object
        return $d;
    }
}

/**
 * 数组转字符串
 * @param  [type] $re1 [description]
 * @return [type]      [description]
 */
function arrayToString($re1){
    $str = "";
    $cnt = 0;
    foreach ($re1 as $value)
    {
        if($cnt == 0) {
            $str = $value;
        }
        else{
            $str = $str.','.$value;
        }
        $cnt++;
    }
}

/**
 * 两个数组的笛卡尔积
 * @param unknown_type $arr1
 * @param unknown_type $arr2
*/

function combineArray($arr1,$arr2) {         
    $result = array();
    foreach ($arr1 as $item1) 
    {
        foreach ($arr2 as $item2) 
        {
            $temp = $item1;
            $temp[] = $item2;
            $result[] = $temp;
        }
    }
    return $result;
}

/**
 * 删除数字元素
 * @param  [type] $arr [description]
 * @param  [type] $key [description]
 * @return [type]      [description]
 */
function array_remove($arr, $key){
    if(!array_key_exists($key, $arr)){
        return $arr;
    }
    $keys = array_keys($arr);
    $index = array_search($key, $keys);
    if($index !== FALSE){
        array_splice($arr, $index, 1);
    }
    return $arr;

}


//修改env
function modifyEnv(array $data)
{
    $envPath = base_path() . DIRECTORY_SEPARATOR . '.env';

    $contentArray = collect(file($envPath, FILE_IGNORE_NEW_LINES));

    $contentArray->transform(function ($item) use ($data){
        foreach ($data as $key => $value){
            if(str_contains($item, $key)){
                return $key . '=' . $value;
            }
        }
        return $item;
    });

    $content = implode($contentArray->toArray(), "\n");

    \File::put($envPath, $content);
}

/**
 * [截取指定字符串长度]
 * @param  [type] $str [description]
 * @param  [type] $num [description]
 * @return [type]      [description]
 */
function subdes($str, $num){
        global $Briefing_Length; 
        mb_regex_encoding("UTF-8");     
        $Foremost = mb_substr($str, 0, $num); 
        $re = "<(\/?) 
    (P|DIV|H1|H2|H3|H4|H5|H6|ADDRESS|PRE|TABLE|TR|TD|TH|INPUT|SELECT|TEXTAREA|OBJECT|A|UL|OL|LI| 
    BASE|META|LINK|HR|BR|PARAM|IMG|AREA|INPUT|SPAN)[^>]*(>?)"; 
        $Single = "/BASE|META|LINK|HR|BR|PARAM|IMG|AREA|INPUT|BR/i";     

        $Stack = array(); $posStack = array(); 

        mb_ereg_search_init($Foremost, $re, 'i'); 

        while($pos = mb_ereg_search_pos()){ 
            $match = mb_ereg_search_getregs(); 

            if($match[1]==""){ 
                $Elem = $match[2]; 
                if(mb_eregi($Single, $Elem) && $match[3] !=""){ 
                    continue; 
                } 
                array_push($Stack, mb_strtoupper($Elem)); 
                array_push($posStack, $pos[0]);             
            }else{ 
                $StackTop = $Stack[count($Stack)-1]; 
                $End = mb_strtoupper($match[2]); 
                if(strcasecmp($StackTop,$End)==0){ 
                    array_pop($Stack); 
                    array_pop($posStack); 
                    if($match[3] ==""){ 
                        $Foremost = $Foremost.">"; 
                    } 
                } 
            } 
        } 

        $cutpos = array_shift($posStack) - 1;     
        $Foremost =  mb_substr($Foremost,0,$cutpos,"UTF-8"); 
        return strip_tags($Foremost); 
}


/**
 * 指定位置插入字符串
 * @param $str  原字符串
 * @param $i    插入位置
 * @param $substr 插入字符串
 * @return string 处理后的字符串
 */
function insertToStr($str, $i, $substr){
    //指定插入位置前的字符串
    $startstr="";
    for($j=0; $j<$i; $j++){
        $startstr .= $str[$j];
    }

    //指定插入位置后的字符串
    $laststr="";
    for ($j=$i; $j<strlen($str); $j++){
        $laststr .= $str[$j];
    }

    //将插入位置前，要插入的，插入位置后三个字符串拼接起来
    $str = $startstr . $substr . $laststr;

    //返回结果
    return $str;
}


$key = 'wefwefewfewfw321651)(*&(&';
/**
 * 加密
 * @param  [type] $data [description]
 * @param  [type] $key  [description]
 * @return [type]       [description]
 */
function zcjy_encrypt($data, $key)  
{  
    $key    =   md5($key);  
    $x      =   0;  
    $len    =   strlen($data);  
    $l      =   strlen($key);  
    $char = '';
    $str = '';
    for ($i = 0; $i < $len; $i++)  
    {  
        if ($x == $l)   
        {  
            $x = 0;  
        }  
        $char .= $key{$x};  
        $x++;  
    }  
    for ($i = 0; $i < $len; $i++)  
    {  
        $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);  
    }  
    return base64_encode($str);  
}

/**
 * 解密
 * @param  [type] $data [description]
 * @param  [type] $key  [description]
 * @return [type]       [description]
 */
function zcjy_decrypt($data, $key)  
{  
    $key = md5($key);  
    $x = 0;  
    $data = base64_decode($data);  
    $len = strlen($data);  
    $l = strlen($key);  
    $char = '';
    $str = '';
    for ($i = 0; $i < $len; $i++)  
    {  
        if ($x == $l)   
        {  
            $x = 0;  
        }  
        $char .= substr($key, $x, 1);  
        $x++;  
    }  
    for ($i = 0; $i < $len; $i++)  
    {  
        if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1)))  
        {  
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));  
        }  
        else  
        {  
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));  
        }  
    }  
    return $str;  
}  