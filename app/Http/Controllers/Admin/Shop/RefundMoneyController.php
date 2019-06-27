<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateRefundMoneyRequest;
use App\Http\Requests\UpdateRefundMoneyRequest;
use App\Repositories\RefundMoneyRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class RefundMoneyController extends AppBaseController
{
    /** @var  RefundMoneyRepository */
    private $refundMoneyRepository;

    public function __construct(RefundMoneyRepository $refundMoneyRepo)
    {
        $this->refundMoneyRepository = $refundMoneyRepo;
    }

    /**
     * Display a listing of the RefundMoney.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->refundMoneyRepository->pushCriteria(new RequestCriteria($request));
        $refundMoneys = $this->refundMoneyRepository->all();

        return view('admin.refund_moneys.index')
            ->with('refundMoneys', $refundMoneys);
    }

    /**
     * Show the form for creating a new RefundMoney.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.refund_moneys.create');
    }

    /**
     * Store a newly created RefundMoney in storage.
     *
     * @param CreateRefundMoneyRequest $request
     *
     * @return Response
     */
    public function store(CreateRefundMoneyRequest $request)
    {
        $input = $request->all();

        $refundMoney = $this->refundMoneyRepository->create($input);

        Flash::success('Refund Money saved successfully.');

        return redirect(route('refundMoneys.index'));
    }

    /**
     * Display the specified RefundMoney.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $refundMoney = $this->refundMoneyRepository->findWithoutFail($id);

        if (empty($refundMoney)) {
            Flash::error('Refund Money not found');

            return redirect(route('refundMoneys.index'));
        }

        return view('admin.refund_moneys.show')->with('refundMoney', $refundMoney);
    }

    /**
     * Show the form for editing the specified RefundMoney.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $refundMoney = $this->refundMoneyRepository->findWithoutFail($id);

        if (empty($refundMoney)) {
            Flash::error('Refund Money not found');

            return redirect(route('refundMoneys.index'));
        }

        return view('admin.refund_moneys.edit')->with('refundMoney', $refundMoney);
    }

    /**
     * Update the specified RefundMoney in storage.
     *
     * @param  int              $id
     * @param UpdateRefundMoneyRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRefundMoneyRequest $request)
    {
        $refundMoney = $this->refundMoneyRepository->findWithoutFail($id);

        if (empty($refundMoney)) {
            Flash::error('Refund Money not found');

            return redirect(route('refundMoneys.index'));
        }

        $refundMoney = $this->refundMoneyRepository->update($request->all(), $id);

        Flash::success('Refund Money updated successfully.');

        return redirect(route('refundMoneys.index'));
    }

    /**
     * Remove the specified RefundMoney from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $refundMoney = $this->refundMoneyRepository->findWithoutFail($id);

        if (empty($refundMoney)) {
            Flash::error('Refund Money not found');

            return redirect(route('refundMoneys.index'));
        }

        $this->refundMoneyRepository->delete($id);

        Flash::success('Refund Money deleted successfully.');

        return redirect(route('refundMoneys.index'));
    }
}
