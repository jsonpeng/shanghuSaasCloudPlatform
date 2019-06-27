<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateTopupGiftsRequest;
use App\Http\Requests\UpdateTopupGiftsRequest;
use App\Repositories\TopupGiftsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class TopupGiftsController extends AppBaseController
{
    /** @var  TopupGiftsRepository */
    private $topupGiftsRepository;

    public function __construct(TopupGiftsRepository $topupGiftsRepo)
    {
        $this->topupGiftsRepository = $topupGiftsRepo;
    }

    /**
     * Display a listing of the TopupGifts.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->topupGiftsRepository->pushCriteria(new RequestCriteria($request));
        
        $topupGifts = $this->defaultSearchState($this->topupGiftsRepository);
   
        $topupGifts = $this->accountInfo($topupGifts);
    

        return view('admin.topup_gifts.index')
            ->with('topupGifts', $topupGifts);
    }

    /**
     * Show the form for creating a new TopupGifts.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.topup_gifts.create');
    }

    /**
     * Store a newly created TopupGifts in storage.
     *
     * @param CreateTopupGiftsRequest $request
     *
     * @return Response
     */
    public function store(CreateTopupGiftsRequest $request)
    {
        $input = $request->all();
        $input = attachAccoutInput($input);
        $topupGifts = $this->topupGiftsRepository->create($input);

        Flash::success('保存成功.');

        return redirect(route('topupGifts.index'));
    }

    /**
     * Display the specified TopupGifts.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $topupGifts = $this->topupGiftsRepository->findWithoutFail($id);

        if (empty($topupGifts)) {
            Flash::error('没有找到该充值服务');

            return redirect(route('topupGifts.index'));
        }

        return view('admin.topup_gifts.show')->with('topupGifts', $topupGifts);
    }

    /**
     * Show the form for editing the specified TopupGifts.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $topupGifts = $this->topupGiftsRepository->findWithoutFail($id);

        if (empty($topupGifts)) {
            Flash::error('没有找到该充值服务');

            return redirect(route('topupGifts.index'));
        }
        $coupon = $topupGifts->coupon()->first();
        return view('admin.topup_gifts.edit')
            ->with('topupGifts', $topupGifts)
            ->with('coupon',$coupon);
    }

    /**
     * Update the specified TopupGifts in storage.
     *
     * @param  int              $id
     * @param UpdateTopupGiftsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTopupGiftsRequest $request)
    {
        $topupGifts = $this->topupGiftsRepository->findWithoutFail($id);

        if (empty($topupGifts)) {
            Flash::error('没有找到该充值服务');

            return redirect(route('topupGifts.index'));
        }

        $topupGifts = $this->topupGiftsRepository->update($request->all(), $id);

        Flash::success('更新成功.');

        return redirect(route('topupGifts.index'));
    }

    /**
     * Remove the specified TopupGifts from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $topupGifts = $this->topupGiftsRepository->findWithoutFail($id);

        if (empty($topupGifts)) {
            Flash::error('没有找到该充值服务');

            return redirect(route('topupGifts.index'));
        }

        $this->topupGiftsRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('topupGifts.index'));
    }
}
