<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;


use App\Http\Controllers\Controller;

use App\Repositories\ProductRepository;
use App\Repositories\ArticlecatsRepository;
use App\Repositories\SingelPageRepository;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;


class PostController extends Controller
{

    
    private $productRepository;
    private $articlecatsRepository;
    private $singelPageRepository;

    public function __construct(
        ProductRepository $productRepo, 
        ArticlecatsRepository $articlecatsRepo,
        SingelPageRepository $singelPageRepo
    )
    {
        $this->articlecatsRepository=$articlecatsRepo;
        $this->productRepository = $productRepo;
        $this->singelPageRepository=$singelPageRepo;
    }

  
    /**
     * 小程序话题分类列表
     *
     * @SWG\Get(path="/api/post_cat_all",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序话题分类列表",
     *   description="小程序话题分类列表,不需要需要token信息",
     *   operationId="getCatsFoundUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="token",
     *     type="string",
     *     description="token头信息",
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
    public function getCatsFound(Request $request){
        $cats=$this->articlecatsRepository->getCacheCategoryAll($request->input('shop_id'));
        return zcjy_callback_data($cats);
    }


    /**
     * 单页列表
     */
    public function getSingePageList(){
        $singlepages=$this->singelPageRepository->descToShow();
        return zcjy_callback_data($singlepages);
    }

    /**
     * 单页内容
     */
    public function getSingePageBySlug($slug){

        $singlepage=$this->singelPageRepository->getCacheSinglePageBySlug($slug);
        return zcjy_callback_data($singlepage);

    }



    /**
     * 小程序话题列表
     *
     * @SWG\Get(path="/api/post_found",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序话题列表",
     *   description="小程序话题列表,不需要需要token信息",
     *   operationId="getCatsFoundUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="token",
     *     type="string",
     *     description="token头信息",
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
    public function getPostsFound(Request $request)
    {
        $skip = 0;
        $take = 18;

        # $type = null;有分类就是分类id没有就是null
        $type = $request->input('type');

        #是否热门
        $is_hot =null;

        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }

        if ($request->has('take')) {
            $take = $request->input('take');
        }

        if ($request->has('is_hot')) {
            $is_hot = $request->input('is_hot');
        }

        $shop_id = $request->input('shop_id');

        $posts=empty($type)?$this->articlecatsRepository->getAllCachePostsWithHot($shop_id,$is_hot,$skip,$take):$this->articlecatsRepository->getCachePostsOfCatIdWithHot($shop_id,$is_hot,$type,$skip,$take);
    
     
        return zcjy_callback_data($posts);

    }

    /**
     * 小程序用户发布的文章列表
     *
     * @SWG\Get(path="/api/user_posts",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序用户发布的文章列表",
     *   description="小程序用户发布的文章列表,需要token信息",
     *   operationId="userPostsUser",
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
    public function userPosts(Request $request){
        $user = auth()->user();

        $skip = 0;
        $take = 18;

        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }

        if ($request->has('take')) {
            $take = $request->input('take');
        }

        $posts = $this->articlecatsRepository->getUserPosts($user,$skip,$take);

        return zcjy_callback_data($posts);
    }






    
}
