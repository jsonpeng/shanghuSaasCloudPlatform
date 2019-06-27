<?php

namespace App\Http\Controllers\Admin\Headquarter;

use App\Http\Requests\CreatePackageLogRequest;
use App\Http\Requests\UpdatePackageLogRequest;
use App\Repositories\PackageLogRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class PackageLogController extends AppBaseController
{
    /** @var  PackageLogRepository */
    private $packageLogRepository;

    public function __construct(PackageLogRepository $packageLogRepo)
    {
        $this->packageLogRepository = $packageLogRepo;
    }

    /**
     * Display a listing of the PackageLog.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->packageLogRepository->pushCriteria(new RequestCriteria($request));

        $packageLogs =paginate($this->defaultSearchState($this->packageLogRepository)
        ->orderBy('created_at','desce'));


        return view('headquarter.package_logs.index')
            ->with('packageLogs', $packageLogs);
    }

    /**
     * Show the form for creating a new PackageLog.
     *
     * @return Response
     */
    public function create()
    {
        return view('headquarter.package_logs.create');
    }

    /**
     * Store a newly created PackageLog in storage.
     *
     * @param CreatePackageLogRequest $request
     *
     * @return Response
     */
    public function store(CreatePackageLogRequest $request)
    {
        $input = $request->all();

        $packageLog = $this->packageLogRepository->create($input);

        Flash::success('Package Log saved successfully.');

        return redirect(route('packageLogs.index'));
    }

    /**
     * Display the specified PackageLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $packageLog = $this->packageLogRepository->findWithoutFail($id);

        if (empty($packageLog)) {
            Flash::error('没有找到该记录');

            return redirect(route('packageLogs.index'));
        }

        return view('headquarter.package_logs.show')->with('packageLog', $packageLog);
    }

    /**
     * Show the form for editing the specified PackageLog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $packageLog = $this->packageLogRepository->findWithoutFail($id);

        if (empty($packageLog)) {
            Flash::error('没有找到该记录');

            return redirect(route('packageLogs.index'));
        }

        return view('headquarter.package_logs.edit')->with('packageLog', $packageLog);
    }

    /**
     * Update the specified PackageLog in storage.
     *
     * @param  int              $id
     * @param UpdatePackageLogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePackageLogRequest $request)
    {
        $packageLog = $this->packageLogRepository->findWithoutFail($id);

        if (empty($packageLog)) {
            Flash::error('没有找到该记录');

            return redirect(route('packageLogs.index'));
        }

        $packageLog = $this->packageLogRepository->update($request->all(), $id);

        Flash::success('Package Log updated successfully.');

        return redirect(route('packageLogs.index'));
    }

    /**
     * Remove the specified PackageLog from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $packageLog = $this->packageLogRepository->findWithoutFail($id);

        if (empty($packageLog)) {
            Flash::error('没有找到该记录');

            return redirect(route('packageLogs.index'));
        }

        $this->packageLogRepository->delete($id);

        Flash::success('删除套餐记录成功.');

        return redirect(route('packageLogs.index'));
    }
}
