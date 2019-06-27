<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateDistributionLogRequest;
use App\Http\Requests\UpdateDistributionLogRequest;
use App\Repositories\DistributionLogRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\DistributionLog;

class DistributionLogController extends AppBaseController
{
    /** @var  DistributionLogRepository */
    private $distributionLogRepository;

    public function __construct(DistributionLogRepository $distributionLogRepo)
    {
        $this->distributionLogRepository = $distributionLogRepo;
    }

    /**
     * Display a listing of the DistributionLog.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //$this->distributionLogRepository->pushCriteria(new RequestCriteria($request));
        //$distributionLogs = $this->distributionLogRepository->all();
        $distributionLogs = DistributionLog::orderBy('created_at', 'desc')->paginate($this->defaultPage());

        return view('admin.distribution_logs.index')
            ->with('distributionLogs', $distributionLogs);
    }

    /**
     * Show the form for creating a new DistributionLog.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.distribution_logs.create');
    }

    /**
     * Store a newly created DistributionLog in storage.
     *
     * @param CreateDistributionLogRequest $request
     *
     * @return Response
     */
    public function store(CreateDistributionLogRequest $request)
    {
        $input = $request->all();

        $distributionLog = $this->distributionLogRepository->create($input);

        Flash::success('Distribution Log saved successfully.');

        return redirect(route('distributionLogs.index'));
    }

    /**
     * Display the specified DistributionLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $distributionLog = $this->distributionLogRepository->findWithoutFail($id);

        if (empty($distributionLog)) {
            Flash::error('Distribution Log not found');

            return redirect(route('distributionLogs.index'));
        }

        return view('admin.distribution_logs.show')->with('distributionLog', $distributionLog);
    }

    /**
     * Show the form for editing the specified DistributionLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $distributionLog = $this->distributionLogRepository->findWithoutFail($id);

        if (empty($distributionLog)) {
            Flash::error('Distribution Log not found');

            return redirect(route('distributionLogs.index'));
        }

        return view('admin.distribution_logs.edit')->with('distributionLog', $distributionLog);
    }

    /**
     * Update the specified DistributionLog in storage.
     *
     * @param  int              $id
     * @param UpdateDistributionLogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDistributionLogRequest $request)
    {
        $distributionLog = $this->distributionLogRepository->findWithoutFail($id);

        if (empty($distributionLog)) {
            Flash::error('Distribution Log not found');

            return redirect(route('distributionLogs.index'));
        }

        $distributionLog = $this->distributionLogRepository->update($request->all(), $id);

        Flash::success('Distribution Log updated successfully.');

        return redirect(route('distributionLogs.index'));
    }

    /**
     * Remove the specified DistributionLog from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $distributionLog = $this->distributionLogRepository->findWithoutFail($id);

        if (empty($distributionLog)) {
            Flash::error('Distribution Log not found');

            return redirect(route('distributionLogs.index'));
        }

        $this->distributionLogRepository->delete($id);

        Flash::success('Distribution Log deleted successfully.');

        return redirect(route('distributionLogs.index'));
    }
}
