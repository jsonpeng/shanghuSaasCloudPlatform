<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateDiscountOrderRequest;
use App\Http\Requests\UpdateDiscountOrderRequest;
use App\Repositories\DiscountOrderRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class DiscountOrderController extends AppBaseController
{
    /** @var  DiscountOrderRepository */
    private $discountOrderRepository;

    public function __construct(DiscountOrderRepository $discountOrderRepo)
    {
        $this->discountOrderRepository = $discountOrderRepo;
    }

    /**
     * Display a listing of the DiscountOrder.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->discountOrderRepository->pushCriteria(new RequestCriteria($request));
    
        $discountOrders  = $this->defaultSearchState($this->discountOrderRepository);
   
        $discountOrders  = $this->accountInfo($discountOrders ,true);

        return view('admin.discount_orders.index')
            ->with('discountOrders', $discountOrders);
    }

    /**
     * Show the form for creating a new DiscountOrder.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.discount_orders.create');
    }

    /**
     * Store a newly created DiscountOrder in storage.
     *
     * @param CreateDiscountOrderRequest $request
     *
     * @return Response
     */
    public function store(CreateDiscountOrderRequest $request)
    {
        $input = $request->all();

        $discountOrder = $this->discountOrderRepository->create($input);

        Flash::success('Discount Order saved successfully.');

        return redirect(route('discountOrders.index'));
    }

    /**
     * Display the specified DiscountOrder.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $discountOrder = $this->discountOrderRepository->findWithoutFail($id);

        if (empty($discountOrder)) {
            Flash::error('没有找到该记录');

            return redirect(route('discountOrders.index'));
        }

        return view('admin.discount_orders.show')->with('discountOrder', $discountOrder);
    }

    /**
     * Show the form for editing the specified DiscountOrder.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $discountOrder = $this->discountOrderRepository->findWithoutFail($id);

        if (empty($discountOrder)) {
            Flash::error('没有找到该记录');

            return redirect(route('discountOrders.index'));
        }

        return view('admin.discount_orders.edit')->with('discountOrder', $discountOrder);
    }

    /**
     * Update the specified DiscountOrder in storage.
     *
     * @param  int              $id
     * @param UpdateDiscountOrderRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDiscountOrderRequest $request)
    {
        $discountOrder = $this->discountOrderRepository->findWithoutFail($id);

        if (empty($discountOrder)) {
            Flash::error('没有找到该记录');

            return redirect(route('discountOrders.index'));
        }

        $discountOrder = $this->discountOrderRepository->update($request->all(), $id);

        Flash::success('Discount Order updated successfully.');

        return redirect(route('discountOrders.index'));
    }

    /**
     * Remove the specified DiscountOrder from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $discountOrder = $this->discountOrderRepository->findWithoutFail($id);

        if (empty($discountOrder)) {
            Flash::error('没有找到该记录');

            return redirect(route('discountOrders.index'));
        }

        $this->discountOrderRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('discountOrders.index'));
    }
}
