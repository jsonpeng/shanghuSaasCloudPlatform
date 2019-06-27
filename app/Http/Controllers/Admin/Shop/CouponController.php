<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Repositories\CouponRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\UserLevelRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Coupon;
use App\Models\CouponUser;
use App\User;
use App\Models\UserLevel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

class CouponController extends AppBaseController
{
    /** @var  CouponRepository */
    private $couponRepository;
    private $categoryRepository;

    public function __construct(CouponRepository $couponRepo, CategoryRepository $categoryRepo)
    {
        $this->couponRepository = $couponRepo;
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * [可以使用的优惠券]
     * @return [type] [description]
     */
    public function canUseCouponFrame(Request $request){
        $input = $request->all();
        $coupons = Coupon::where('account',admin()->account)
        ->where('shop_id',now_shop_id());
        
        if(array_key_exists('name',$input)){
            $coupons = $coupons->where('name','like','%'.$input['name'].'%');
        }

        $counpons_num = $coupons->count();      
        //过滤过期的
        
        // $coupons = $coupons->filter(function($coupon,$key){
        //     return $coupon->time_type == 1 && Carbon::parse($coupon->time_end)->lt(Carbon::now());
        // });
        
        $coupons = $coupons->paginate($this->defaultPage());
        return view('admin.coupons.iframe')
            ->with('input',$input)
            ->with('coupons',$coupons)
            ->with('counpons_num',$counpons_num);
    }

    /**
     * Display a listing of the Coupon.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->couponRepository->pushCriteria(new RequestCriteria($request));
        $coupons = Coupon::where('id','>','0');
        $input=$request->all();
        $tools=$this->varifyTools($input);
        $created_desc_status=true;

        if(array_key_exists('id_sort',$input)){
            $coupons=$coupons->orderBy('id',$input['id_sort']==0?'asc':'desc');
            $created_desc_status=false;
        }
        if(array_key_exists('name', $input)){
            $coupons=$coupons->where('name','like','%'.$input['name'].'%');
        }
        if(array_key_exists('type', $input) && !empty($input['type'])){
            $coupons=$coupons->where('type',$input['type']);
        }
        if(array_key_exists('start_time',$input) && !empty($input['start_time'])){
            $coupons=$coupons->where('time_begin','>=',$input['start_time']);
        }
        if(array_key_exists('end_time',$input) && !empty($input['end_time'])){
            $coupons=$coupons->where('time_end','<',$input['end_time']);
        }
        if(array_key_exists('range', $input) && !empty($input['range'])){
            $coupons=$coupons->where('range',$input['range']);
        }
        if($created_desc_status){
            $coupons=$coupons->orderBy('created_at','desc');
        }
        $coupons=$coupons
        ->where('account',admin()->account)
        ->where('shop_id',now_shop_id())
        ->paginate($this->defaultPage());

        return view('admin.coupons.index')
            ->with('coupons', $coupons)
            ->with('tools',$tools)
            ->withInput(Input::all());
    }

    /**
     * Show the form for creating a new Coupon.
     *
     * @return Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->getRootCatArray();
        $level02Selections = [0 => '请选择分类'];
        $level03Selections = [0 => '请选择分类'];
        $level01 = 0; $level02 = 0; $level03 = 0;
        $add_spec_product=0;
        $add_product_id=0;
        $products=[];
        $specs=[];
        return view('admin.coupons.create', compact('categories', 'level01', 'level02', 'level03', 'level02Selections','products','specs' ,'level03Selections','add_spec_product','add_product_id'));
    }

    /**
     * Store a newly created Coupon in storage.
     *
     * @param CreateCouponRequest $request
     *
     * @return Response
     */
    public function store(CreateCouponRequest $request)
    {
        $input = $request->all();

        $input = array_filter( $input, function($v, $k) {
            return $v != '';
        }, ARRAY_FILTER_USE_BOTH );

        if($input['range']==1){
            if (!empty($input['level01'])) {
                $input['category_id'] = $input['level01'];
            }else{
                $input['category_id'] = 0;
            }
            if($input['category_id'] == 0 ){
                return redirect(route('coupons.create'))
                        ->withErrors('请选择参加活动的分类')
                        ->withInput($input);
            }
        }

        if($input['range']==2){
            if(!array_key_exists('product_spec',$input)){
                return redirect(route('coupons.create'))
                        ->withErrors('请选择参加活动的商品')
                        ->withInput($input);
            }
        }

        $input = attachAccoutInput($input);

        $coupon = $this->couponRepository->create($input);

        if(array_key_exists('product_spec',$input) && !empty($input['product_spec'])){
           $this->updateWithProductInfo($input['product_spec'],$coupon);
        }


        Flash::success('优惠券创建成功');

        return redirect(route('coupons.index'));
    }

    /**
     * Show the form for editing the specified Coupon.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $coupon = $this->couponRepository->findWithoutFail($id);
        
        if (empty($coupon)) {
            Flash::error('优惠券不存在');

            return redirect(route('coupons.index'));
        }

        $categories = $this->categoryRepository->getRootCatArray();
        //如果是指定分类，则获取指定的分类层级信息
        $level02Selections = [0 => '请选择分类'];
        $level03Selections = [0 => '请选择分类'];
        $level01 = 0; $level02 = 0; $level03 = 0;
        if ($coupon->range == 1) {
            $category = $this->categoryRepository->findWithoutFail($coupon->category_id);
            $level01 = $coupon->category_id;
            $level02 = 0;
            $level03 = 0;
        }
            /*
            if (!empty($category)) {
                $catIds = explode('_', $category->parent_path);
                switch (count($catIds)) {
                    case 1:
                        //一级分类
                        $level01 = $coupon->category_id;
                        break;
                    case 2:
                        //二级分类
                        $level01 = intval($catIds[1]);
                        $level02 = $coupon->category_id;
                        $level02Selections = $this->categoryRepository->getRootCatArray($catIds[1]);
                        break;
                    case 3:
                        //三级分类
                        $level01 = $catIds[1];
                        $level02 = $catIds[2];
                        $level02Selections = $this->categoryRepository->getRootCatArray($catIds[1]);
                        $level03 = $coupon->category_id;
                        $level03Selections = $this->categoryRepository->getRootCatArray($catIds[2]);
                        break;
                    default:
                        $level01 = $catIds[1];
                        $level02 = $catIds[2];
                        $level02Selections = $this->categoryRepository->getRootCatArray($catIds[1]);
                        $level03 = $coupon->category_id;
                        $level03Selections = $this->categoryRepository->getRootCatArray($catIds[2]);
                        break;
                }
            }*/
            
        $products=$this->couponRepository->getCouponProductListByCouponId($id);

        $specs=[];

        return view('admin.coupons.edit', compact('coupon', 'categories', 'level01', 'level02', 'level03', 'level02Selections', 'level03Selections','products','specs'));
    }

    /**
     * Update the specified Coupon in storage.
     *
     * @param  int              $id
     * @param UpdateCouponRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCouponRequest $request)
    {
        $coupon = $this->couponRepository->findWithoutFail($id);

        if (empty($coupon)) {
            Flash::error('优惠券不存在');

            return redirect(route('coupons.index'));
        }

        $input = $request->all();
        
          if($input['range']==1){
            if (!empty($input['level01'])) {
                $input['category_id'] = $input['level01'];
            }else{
                $input['category_id'] = 0;
            }
            if($input['category_id'] == 0 ){
                return redirect(route('coupons.create'))
                        ->withErrors('请选择参加活动的分类')
                        ->withInput($input);
            }
        }

        if($input['range']==2){
            if(!array_key_exists('product_spec',$input)){
                return redirect(route('coupons.create'))
                        ->withErrors('请选择参加活动的商品')
                        ->withInput($input);
            }
        }

        $coupon = $this->couponRepository->update($input, $id);

        //$spec_arr=[];
        if(array_key_exists('product_spec',$input) && !empty($input['product_spec']) ){
            //先清空
            $coupon->products()->sync([]);
            //然后更新信息
            $this->updateWithProductInfo($input['product_spec'],$coupon);
        }else{
            $coupon->products()->sync([]);
        }
        //不是也清空
        if($coupon->range!=2){
            $coupon->products()->sync([]);
        }

        Flash::success('优惠券更新成功');

        return redirect(route('coupons.index'));
    }

    /**
     * Remove the specified Coupon from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $coupon = $this->couponRepository->findWithoutFail($id);

        if (empty($coupon)) {
            Flash::error('优惠券不存在');

            return redirect(route('coupons.index'));
        }
        $coupon->products()->sync([]);

        $this->couponRepository->delete($id);


        Flash::success('优惠券删除成功');

        return redirect(route('coupons.index'));
    }

    //逐个发放
    public function given()
    {

        $users=User::all();
        $coupons = Coupon::all();
        $selectedCoupons = [];
        return view('admin.coupons.given_onebyone',compact('users', 'coupons', 'selectedCoupons'));
    }

    public function givenUserList(Request $request){
        $users=User::where('id','>',0);
        $users_level=UserLevel::all();
        $users_num=$users->count();
        $input=$request->all();
        $page_list=$this->defaultPage();
        $tools=$this->varifyTools($input);

        if(array_key_exists('nickname',$input) && !empty($input['nickname'])){
            $users=$users->where('nickname','like','%'.$input['nickname'].'%');
        }
        if(array_key_exists('user_level',$input) && !empty($input['user_level'])){
            $users=$users->where('user_level',$input['user_level']);
        }
        if(array_key_exists('price_sort',$input) && !empty($input['price_sort'])){
            $users=$users->orderBy('consume_total',$input['price_sort']==0?'asc':'desc');
        }
        if(array_key_exists('mobile',$input)&& !empty($input['mobile']) ){
            $users=$users->where('mobile','like','%'.$input['mobile'].'%');
        }
        if(array_key_exists('page_list',$input)&& !empty($input['page_list']) ){
            $page_list=$input['page_list'];
        }
        $users=$users->paginate($page_list);
        return view('admin.coupons.given_userlist',compact('tools','users', 'users_num','input','users_level'));
    }

    //整体发放
    public function givenInteger(UserLevelRepository $userLevelRepo)
    {
        $user_levels = $userLevelRepo->all();
        $coupons = Coupon::all();
        $selectedCoupons = [];
        return view('admin.coupons.given', compact('user_levels', 'coupons', 'selectedCoupons'));
    }

    //逐个发放请求接口
    public function postGiven(Request $request){
        if (!$request->has('user_ids') || !$request->has('count') || !$request->has('coupons') || intval($request->input('count'))<1 || count($request->input('coupons')) < 1 || count($request->input('user_ids')) < 1 ) {
            return ['code' => 4, 'message' => '参数错误'];
        }
        $input=$request->all();
        $coupons=$input['coupons'];
        $users = User::whereIn('id', $input['user_ids'])->select('id')->get();
        if(!empty($users)) {
            app('commonRepo')->processGivenCoupon($users, $coupons, $input['count'], '管理员手动发放');
            return ['code' => 0, 'message' => '发放成功'];
        }else{
            return ['code' => 1, 'message' => '未知错误'];
        }

    }
    //整体发放请求接口
    public function postGivenInteger(Request $request)
    {
        if (!$request->has('user_level') || !$request->has('count') || !$request->has('coupons') || intval($request->input('count'))<1 || count($request->input('coupons')) < 1 ) {
            return ['code' => 4, 'message' => '参数错误'];
        }
        $input = $request->all();
        $users = User::where('user_level', $input['user_level'])->select('id')->get();
        if(!empty($users)) {
            app('commonRepo')->processGivenCoupon($users, $input['coupons'], $input['count'], '管理员手动发放');
            return ['code' => 0, 'message' => '发放成功'];
        }else{
            return ['code' => 1, 'message' => '未知错误'];
        }
    }

    //优惠券统计
    public function stats()
    {
        return view('admin.coupons.stats');
    }

    

    //更新优惠券关联商品信息
    private function updateWithProductInfo($inputs,$coupon){
        $specIdArray =  $inputs;
        for ($i = 0; $i < count($specIdArray); $i++) {
            $spec_product=$specIdArray[$i];
            $spec_product_arr=explode('_',$spec_product);
            if($spec_product_arr[1]=="0"){
                $coupon->products()->attach($spec_product_arr[0]);
            }
        }
    }
}