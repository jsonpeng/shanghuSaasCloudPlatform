<?php

namespace App\Http\Controllers\Admin\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

use Illuminate\Support\Facades\Input;
use Redirect,Response;
use Image;
use Log;
use Config;

class AjaxController extends AppBaseController
{

    public function __construct(
      
    )
    {
       
    }


    public function index(Request $request){
        dd($request->account);
    }

    //根据店铺id获取对应的服务
    public function getServiceByShopIdApi(Request $request,$shop_id){
        return app('commonRepo')->shopRepo()->getServiceByShopId($shop_id);
    }


    //根据服务id获取对应的技师
    public function getTechniciansByServicesIdApi(Request $request,$service_id){
        return app('commonRepo')->serviceRepo()->getTechniciansByServicesId($service_id);
    }

    //给指定用户发消息
    public function sendNoticeByUserId(Request $request,$user_id){
        $content = $request->input('content');
        sendNotice($user_id,$content,false,'商户消息');
        return zcjy_callback_data('发送成功',0,'web');
    }

    //给群组用户发消息
    public function sendGroupUserNotices(Request $request){
        #发送内容
        $content = $request->input('content');
        #用户组
        $user_group = user_group();
        sendGroupNotice($content,$user_group,'商户消息');
        return zcjy_callback_data('发送成功',0,'web');
    }

   /**
    * 图片上传
    */
    public function uploadImage(){
        $file =  Input::file('file');
        return app('commonRepo')->uploadImages($file);
    }
   

}