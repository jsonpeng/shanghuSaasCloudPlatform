<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use InfyOm\Generator\Utils\ResponseUtil;
use Response;
use Illuminate\Support\Facades\Artisan;
use Log;

class AppBaseController extends Controller
{

    public function events(Request $request,$appid=null){
         Log::info($request->all());
    }

    
    // public function index(Request $request){
    //     //Log::info($request->all());
    // }

    public function sendResponse($result, $message){
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    public function sendError($error, $code = 404){
        return Response::json(ResponseUtil::makeError($error), $code);
    }
    
     //清空缓存
    public function clearCache(){
        Artisan::call('cache:clear');
        return ['status'=>true,'msg'=>''];
    }

    /**
     * 获取分页数目
     * @return [int] [分页数目]
     */
    public function defaultPage(){
        return defaultPage();
    }

    /**
     * 验证是否展开
     * @return [int] [是否展开tools 0不展开 1展开]
     */
    public function varifyTools($input,$order=false){
        return varifyTools($input,$order);
    }

    /**
     * [取出对应账户并且取出 带上分页/全部 的内容]
     * @param  [type]    $obj        [description]
     * @param  [boolean] $paginate [description]
     * @param  [string]  $sort     [description]
     * @return [type]              [description]
     */
    public function accountInfo($obj,$paginate =true,$sort = 'desc'){
        return accountInfo($obj,$paginate,$sort);
    }

    /**
     * [初始化查询索引状态]
     * @param  [Repository / Model] $obj [description]
     * @return [type]                    [description]
     */
    public function defaultSearchState($obj){
        return defaultSearchState($obj);
    }

}
