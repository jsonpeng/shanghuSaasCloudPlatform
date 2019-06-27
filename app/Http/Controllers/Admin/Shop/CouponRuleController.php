<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateCouponRuleRequest;
use App\Http\Requests\UpdateCouponRuleRequest;
use App\Repositories\CouponRuleRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Coupon;
use App\Models\CouponRule;

class CouponRuleController extends AppBaseController
{
    /** @var  CouponRuleRepository */
    private $couponRuleRepository;

    public function __construct(CouponRuleRepository $couponRuleRepo)
    {
        $this->couponRuleRepository = $couponRuleRepo;
    }

    /**
     * Display a listing of the CouponRule.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->couponRuleRepository->pushCriteria(new RequestCriteria($request));
        $couponRules = $this->couponRuleRepository->all();

        return view('admin.coupon_rules.index')
            ->with('couponRules', $couponRules);
    }

    /**
     * Show the form for creating a new CouponRule.
     *
     * @return Response
     */
    public function create()
    {
        $coupons = Coupon::all();
        return view('admin.coupon_rules.create')->with('coupons', $coupons);
    }

    /**
     * Store a newly created CouponRule in storage.
     *
     * @param CreateCouponRuleRequest $request
     *
     * @return Response
     */
    public function store(CreateCouponRuleRequest $request)
    {
        $input = $request->all();
        if ( array_key_exists('type', $input) ) {
            if ($input['type'] == '新用户注册' && CouponRule::where('type', '新用户注册')->count() > 0) {
                Flash::error('新用户注册发放优惠券规则已经存在，不能再次创建');
                return redirect(route('couponRules.index'));
            } else if ($input['type'] == '推荐新用户下单' && CouponRule::where('type', '推荐新用户下单')->count() > 0) {
                Flash::error('推荐新用户下单发放优惠券规则已经存在，不能再次创建');
                return redirect(route('couponRules.index'));
            }
        }

        $input = array_filter( $input, function($v, $k) {
            return $v != '';
        }, ARRAY_FILTER_USE_BOTH );

        $couponRule = $this->couponRuleRepository->create($input);

        if ( array_key_exists('coupons', $input) ) {
            $couponRule->coupons()->sync($input['coupons']);
        }

        Flash::success('优惠券发放规则创建成功.');

        return redirect(route('couponRules.index'));
    }

    /**
     * Display the specified CouponRule.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $couponRule = $this->couponRuleRepository->findWithoutFail($id);

        if (empty($couponRule)) {
            Flash::error('优惠券规则不存在');

            return redirect(route('couponRules.index'));
        }

        return view('admin.coupon_rules.show')->with('couponRule', $couponRule);
    }

    /**
     * Show the form for editing the specified CouponRule.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $couponRule = $this->couponRuleRepository->findWithoutFail($id);

        if (empty($couponRule)) {
            Flash::error('优惠券发放规则不存在');

            return redirect(route('couponRules.index'));
        }

        $coupons = Coupon::all();
        $selectedCoupons = [];
        $tmparray = $couponRule->coupons()->get()->toArray();
        while (list($key, $val) = each($tmparray)) {
            array_push($selectedCoupons, $val['id']);
        }

        return view('admin.coupon_rules.edit')->with('couponRule', $couponRule)->with('coupons', $coupons)->with('selectedCoupons', $selectedCoupons);
    }

    /**
     * Update the specified CouponRule in storage.
     *
     * @param  int              $id
     * @param UpdateCouponRuleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCouponRuleRequest $request)
    {
        $couponRule = $this->couponRuleRepository->findWithoutFail($id);

        if (empty($couponRule)) {
            Flash::error('优惠券规则不存在');

            return redirect(route('couponRules.index'));
        }
        $input = $request->all();
        unset($input['type']);
        $couponRule = $this->couponRuleRepository->update($input, $id);

        
        if ( array_key_exists('coupons', $input) ) {
            $couponRule->coupons()->sync($input['coupons']);
        }else{
            $couponRule->coupons()->sync([]);
        }

        Flash::success('优惠券规则更新成功.');

        return redirect(route('couponRules.index'));
    }

    /**
     * Remove the specified CouponRule from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $couponRule = $this->couponRuleRepository->findWithoutFail($id);

        if (empty($couponRule)) {
            Flash::error('优惠券规则不存在');

            return redirect(route('couponRules.index'));
        }
        $couponRule->coupons()->sync([]);
        $this->couponRuleRepository->delete($id);

        Flash::success('删除成功');

        return redirect(route('couponRules.index'));
    }
}
