<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Category;
use App\Models\Theme;

use App\Http\Controllers\Controller;

use App\Repositories\ProductRepository;
use App\Repositories\ArticlecatsRepository;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Log;

class FoundController extends Controller
{

    
    private $productRepository;
    private $articlecatsRepository;
    public function __construct(
        ProductRepository $productRepo, 
        ArticlecatsRepository $articlecatsRepo
    )
    {
        $this->articlecatsRepository=$articlecatsRepo;
        $this->productRepository = $productRepo;

    }

    //发现首页
    public function index(Request $request, $type = 0){
        $hot_cats = null;
        if ($type) {
            #最新
            $newestPost= $this->articlecatsRepository->getCachePostsOfCatIdWithHot(null, $type);
            #热门
            $hotPost=$this->articlecatsRepository->getCachePostsOfCatIdWithHot(true,$type);

            //Log::info('newestPost');
            //Log::info($newestPost);

        } else {
            #热门话题列表
            $hot_cats=$this->articlecatsRepository->getCacheCategoryAll();

            #最新
            $newestPost= $this->articlecatsRepository->getAllCachePostsWithHot();

            #热门
            $hotPost=$this->articlecatsRepository->getAllCachePostsWithHot(true);
        }

        //$hot_cats=optional($hot_cats);

        return view(frontView('found.index'),compact('type','hot_cats','newestPost','hotPost'));
    }

    // public function cat(Request $request, $type)
    // {
    //     $cat = $this->articlecatsRepository->getCacheCategory($type);

    //     #最新
    //     $newestPost= $this->articlecatsRepository->getCachePostsOfCatIdWithHot(null, $type);

    //     #热门
    //     $hotPost=$this->articlecatsRepository->getCachePostsOfCatIdWithHot(true,$type);

    //     return view(frontView('found.cat'),compact('cat', 'newestPost', 'hotPost'));
    // }

    // //用户领取优惠券
    // public function userGetCoupons($coupons_id){
    //     $user=auth('web')->user();
    //     if(!empty($user)){
    //         app('commonRepo')->processGivenCoupon([$user], [$coupons_id], 1, '手动领取');
    //         return ['code'=>0,'message'=>'领取成功'];
    //     }else{
    //         return ['code'=>1,'message'=>'请先登录'];
    //     }
    // }


    
}
