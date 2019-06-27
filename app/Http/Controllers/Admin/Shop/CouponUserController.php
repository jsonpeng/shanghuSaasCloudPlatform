<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateCouponUserRequest;
use App\Http\Requests\UpdateCouponUserRequest;
use App\Repositories\CouponUserRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class CouponUserController extends AppBaseController
{
    /** @var  CouponUserRepository */
    private $couponUserRepository;

    public function __construct(CouponUserRepository $couponUserRepo)
    {
        $this->couponUserRepository = $couponUserRepo;
    }

    /**
     * Display a listing of the CouponUser.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->couponUserRepository->pushCriteria(new RequestCriteria($request));
        $couponUsers = $this->couponUserRepository->all();

        return view('coupon_users.index')
            ->with('couponUsers', $couponUsers);
    }

    /**
     * Show the form for creating a new CouponUser.
     *
     * @return Response
     */
    public function create()
    {
        return view('coupon_users.create');
    }

    /**
     * Store a newly created CouponUser in storage.
     *
     * @param CreateCouponUserRequest $request
     *
     * @return Response
     */
    public function store(CreateCouponUserRequest $request)
    {
        $input = $request->all();

        $couponUser = $this->couponUserRepository->create($input);

        Flash::success('Coupon User saved successfully.');

        return redirect(route('couponUsers.index'));
    }

    /**
     * Display the specified CouponUser.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $couponUser = $this->couponUserRepository->findWithoutFail($id);

        if (empty($couponUser)) {
            Flash::error('Coupon User not found');

            return redirect(route('couponUsers.index'));
        }

        return view('coupon_users.show')->with('couponUser', $couponUser);
    }

    /**
     * Show the form for editing the specified CouponUser.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $couponUser = $this->couponUserRepository->findWithoutFail($id);

        if (empty($couponUser)) {
            Flash::error('Coupon User not found');

            return redirect(route('couponUsers.index'));
        }

        return view('coupon_users.edit')->with('couponUser', $couponUser);
    }

    /**
     * Update the specified CouponUser in storage.
     *
     * @param  int              $id
     * @param UpdateCouponUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCouponUserRequest $request)
    {
        $couponUser = $this->couponUserRepository->findWithoutFail($id);

        if (empty($couponUser)) {
            Flash::error('Coupon User not found');

            return redirect(route('couponUsers.index'));
        }

        $couponUser = $this->couponUserRepository->update($request->all(), $id);

        Flash::success('Coupon User updated successfully.');

        return redirect(route('couponUsers.index'));
    }

    /**
     * Remove the specified CouponUser from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $couponUser = $this->couponUserRepository->findWithoutFail($id);

        if (empty($couponUser)) {
            Flash::error('Coupon User not found');

            return redirect(route('couponUsers.index'));
        }

        $this->couponUserRepository->delete($id);

        Flash::success('Coupon User deleted successfully.');

        return redirect(route('couponUsers.index'));
    }
}
