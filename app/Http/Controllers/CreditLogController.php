<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCreditLogRequest;
use App\Http\Requests\UpdateCreditLogRequest;
use App\Repositories\CreditLogRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class CreditLogController extends AppBaseController
{
    /** @var  CreditLogRepository */
    private $creditLogRepository;

    public function __construct(CreditLogRepository $creditLogRepo)
    {
        $this->creditLogRepository = $creditLogRepo;
    }

    /**
     * Display a listing of the CreditLog.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->creditLogRepository->pushCriteria(new RequestCriteria($request));
        $creditLogs = $this->creditLogRepository->all();

        return view('credit_logs.index')
            ->with('creditLogs', $creditLogs);
    }

    /**
     * Show the form for creating a new CreditLog.
     *
     * @return Response
     */
    public function create()
    {
        return view('credit_logs.create');
    }

    /**
     * Store a newly created CreditLog in storage.
     *
     * @param CreateCreditLogRequest $request
     *
     * @return Response
     */
    public function store(CreateCreditLogRequest $request)
    {
        $input = $request->all();

        $creditLog = $this->creditLogRepository->create($input);

        Flash::success('Credit Log saved successfully.');

        return redirect(route('creditLogs.index'));
    }

    /**
     * Display the specified CreditLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $creditLog = $this->creditLogRepository->findWithoutFail($id);

        if (empty($creditLog)) {
            Flash::error('Credit Log not found');

            return redirect(route('creditLogs.index'));
        }

        return view('credit_logs.show')->with('creditLog', $creditLog);
    }

    /**
     * Show the form for editing the specified CreditLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $creditLog = $this->creditLogRepository->findWithoutFail($id);

        if (empty($creditLog)) {
            Flash::error('Credit Log not found');

            return redirect(route('creditLogs.index'));
        }

        return view('credit_logs.edit')->with('creditLog', $creditLog);
    }

    /**
     * Update the specified CreditLog in storage.
     *
     * @param  int              $id
     * @param UpdateCreditLogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCreditLogRequest $request)
    {
        $creditLog = $this->creditLogRepository->findWithoutFail($id);

        if (empty($creditLog)) {
            Flash::error('Credit Log not found');

            return redirect(route('creditLogs.index'));
        }

        $creditLog = $this->creditLogRepository->update($request->all(), $id);

        Flash::success('Credit Log updated successfully.');

        return redirect(route('creditLogs.index'));
    }

    /**
     * Remove the specified CreditLog from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $creditLog = $this->creditLogRepository->findWithoutFail($id);

        if (empty($creditLog)) {
            Flash::error('Credit Log not found');

            return redirect(route('creditLogs.index'));
        }

        $this->creditLogRepository->delete($id);

        Flash::success('Credit Log deleted successfully.');

        return redirect(route('creditLogs.index'));
    }
}
