<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMoneyLogRequest;
use App\Http\Requests\UpdateMoneyLogRequest;
use App\Repositories\MoneyLogRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class MoneyLogController extends AppBaseController
{
    /** @var  MoneyLogRepository */
    private $moneyLogRepository;

    public function __construct(MoneyLogRepository $moneyLogRepo)
    {
        $this->moneyLogRepository = $moneyLogRepo;
    }

    /**
     * Display a listing of the MoneyLog.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->moneyLogRepository->pushCriteria(new RequestCriteria($request));
        $moneyLogs = $this->moneyLogRepository->all();

        return view('money_logs.index')
            ->with('moneyLogs', $moneyLogs);
    }

    /**
     * Show the form for creating a new MoneyLog.
     *
     * @return Response
     */
    public function create()
    {
        return view('money_logs.create');
    }

    /**
     * Store a newly created MoneyLog in storage.
     *
     * @param CreateMoneyLogRequest $request
     *
     * @return Response
     */
    public function store(CreateMoneyLogRequest $request)
    {
        $input = $request->all();

        $moneyLog = $this->moneyLogRepository->create($input);

        Flash::success('Money Log saved successfully.');

        return redirect(route('moneyLogs.index'));
    }

    /**
     * Display the specified MoneyLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $moneyLog = $this->moneyLogRepository->findWithoutFail($id);

        if (empty($moneyLog)) {
            Flash::error('Money Log not found');

            return redirect(route('moneyLogs.index'));
        }

        return view('money_logs.show')->with('moneyLog', $moneyLog);
    }

    /**
     * Show the form for editing the specified MoneyLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $moneyLog = $this->moneyLogRepository->findWithoutFail($id);

        if (empty($moneyLog)) {
            Flash::error('Money Log not found');

            return redirect(route('moneyLogs.index'));
        }

        return view('money_logs.edit')->with('moneyLog', $moneyLog);
    }

    /**
     * Update the specified MoneyLog in storage.
     *
     * @param  int              $id
     * @param UpdateMoneyLogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMoneyLogRequest $request)
    {
        $moneyLog = $this->moneyLogRepository->findWithoutFail($id);

        if (empty($moneyLog)) {
            Flash::error('Money Log not found');

            return redirect(route('moneyLogs.index'));
        }

        $moneyLog = $this->moneyLogRepository->update($request->all(), $id);

        Flash::success('Money Log updated successfully.');

        return redirect(route('moneyLogs.index'));
    }

    /**
     * Remove the specified MoneyLog from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $moneyLog = $this->moneyLogRepository->findWithoutFail($id);

        if (empty($moneyLog)) {
            Flash::error('Money Log not found');

            return redirect(route('moneyLogs.index'));
        }

        $this->moneyLogRepository->delete($id);

        Flash::success('Money Log deleted successfully.');

        return redirect(route('moneyLogs.index'));
    }
}
