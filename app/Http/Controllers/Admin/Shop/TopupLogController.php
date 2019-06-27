<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateTopupLogRequest;
use App\Http\Requests\UpdateTopupLogRequest;
use App\Repositories\TopupLogRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class TopupLogController extends AppBaseController
{
    /** @var  TopupLogRepository */
    private $topupLogRepository;

    public function __construct(TopupLogRepository $topupLogRepo)
    {
        $this->topupLogRepository = $topupLogRepo;
    }

    /**
     * Display a listing of the TopupLog.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->topupLogRepository->pushCriteria(new RequestCriteria($request));

         $topupLogs  = $this->defaultSearchState($this->topupLogRepository);
   
         $topupLogs  = $this->accountInfo( $topupLogs ,true);


        return view('admin.topup_logs.index')
            ->with('topupLogs', $topupLogs);
    }

    /**
     * Show the form for creating a new TopupLog.
     *
     * @return Response
     */
    public function create()
    {
        return view('topup_logs.create');
    }

    /**
     * Store a newly created TopupLog in storage.
     *
     * @param CreateTopupLogRequest $request
     *
     * @return Response
     */
    public function store(CreateTopupLogRequest $request)
    {
        $input = $request->all();

        $topupLog = $this->topupLogRepository->create($input);

        Flash::success('Topup Log saved successfully.');

        return redirect(route('topupLogs.index'));
    }

    /**
     * Display the specified TopupLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $topupLog = $this->topupLogRepository->findWithoutFail($id);

        if (empty($topupLog)) {
            Flash::error('Topup Log not found');

            return redirect(route('topupLogs.index'));
        }

        return view('topup_logs.show')->with('topupLog', $topupLog);
    }

    /**
     * Show the form for editing the specified TopupLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $topupLog = $this->topupLogRepository->findWithoutFail($id);

        if (empty($topupLog)) {
            Flash::error('Topup Log not found');

            return redirect(route('topupLogs.index'));
        }

        return view('topup_logs.edit')->with('topupLog', $topupLog);
    }

    /**
     * Update the specified TopupLog in storage.
     *
     * @param  int              $id
     * @param UpdateTopupLogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTopupLogRequest $request)
    {
        $topupLog = $this->topupLogRepository->findWithoutFail($id);

        if (empty($topupLog)) {
            Flash::error('Topup Log not found');

            return redirect(route('topupLogs.index'));
        }

        $topupLog = $this->topupLogRepository->update($request->all(), $id);

        Flash::success('Topup Log updated successfully.');

        return redirect(route('topupLogs.index'));
    }

    /**
     * Remove the specified TopupLog from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $topupLog = $this->topupLogRepository->findWithoutFail($id);

        if (empty($topupLog)) {
            Flash::error('Topup Log not found');

            return redirect(route('topupLogs.index'));
        }

        $this->topupLogRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('topupLogs.index'));
    }
}
