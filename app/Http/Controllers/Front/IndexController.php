<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Category;
use App\Models\Theme;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Repositories\CouponRepository;
use App\Repositories\ProductRepository;


use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Mail;
use App\Models\Order;
use App\Models\Notice;

class IndexController extends Controller
{

    private $couponRepository;
    // private $bannerRepository;
    private $productRepository;
    
    

    public function __construct(
        ProductRepository $productRepo, 
        CouponRepository $couponRepo
    )
    {
        $this->couponRepository = $couponRepo;
        $this->productRepository = $productRepo;
    }

    //商城首页
    public function index(Request $request){

        //获取推荐分类给前端
        $categories = Category::where('recommend', 1)->orderBy('sort', 'desc')->get();
        //秒杀倒计时给前端需要倒计时的时间
        $cur = processTime( Carbon::now() );
        $time = $cur->copy()->addHours(2);
        //获取手动领取的优惠券
        $coupons=$this->couponRepository->getCouponOfRule(4);
        return view(frontView('index'), compact('categories', 'time', 'coupons'));
    }

    //用户领取优惠券
    public function userGetCoupons($coupons_id){
        if(auth('web')->check()){
            $user = auth('web')->user();
            app('commonRepo')->processGivenCoupon([$user], [$coupons_id], 1, '手动领取');
            return ['code'=>0,'message'=>'领取成功'];
        }else{
            return ['code'=>1,'message'=>'请先登录'];
        }
    }

    public function notice(Request $request, $id)
    {
        $notice = notice($id);
        if (empty($notice)) {
            return redirect('/');
        }
        return view(frontView('notices.detail'), compact('notice'));
    }

    //物流查询
    public function logistics(Request $request){
        $type=$request->input('type');
        $postid=$request->input('postid');
        $html= file_get_contents('https://m.kuaidi100.com/index_all.html');

        return view(frontView('logistics.index'), compact('type','postid','html'));
    }
    
}
