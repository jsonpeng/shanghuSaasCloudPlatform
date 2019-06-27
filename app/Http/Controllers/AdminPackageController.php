<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAdminPackageRequest;
use App\Http\Requests\UpdateAdminPackageRequest;
use App\Repositories\AdminPackageRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AdminPackageController extends AppBaseController
{
    /** @var  AdminPackageRepository */
    private $adminPackageRepository;

    public function __construct(AdminPackageRepository $adminPackageRepo)
    {
        $this->adminPackageRepository = $adminPackageRepo;
    }

    /**
     * Display a listing of the AdminPackage.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->adminPackageRepository->pushCriteria(new RequestCriteria($request));
        $adminPackages = $this->adminPackageRepository->all();

        return view('admin_packages.index')
            ->with('adminPackages', $adminPackages);
    }

    /**
     * Show the form for creating a new AdminPackage.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin_packages.create');
    }

    /**
     * Store a newly created AdminPackage in storage.
     *
     * @param CreateAdminPackageRequest $request
     *
     * @return Response
     */
    public function store(CreateAdminPackageRequest $request)
    {
        $input = $request->all();

        $adminPackage = $this->adminPackageRepository->create($input);

        Flash::success('Admin Package saved successfully.');

        return redirect(route('adminPackages.index'));
    }

    /**
     * Display the specified AdminPackage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $adminPackage = $this->adminPackageRepository->findWithoutFail($id);

        if (empty($adminPackage)) {
            Flash::error('Admin Package not found');

            return redirect(route('adminPackages.index'));
        }

        return view('admin_packages.show')->with('adminPackage', $adminPackage);
    }

    /**
     * Show the form for editing the specified AdminPackage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $adminPackage = $this->adminPackageRepository->findWithoutFail($id);

        if (empty($adminPackage)) {
            Flash::error('Admin Package not found');

            return redirect(route('adminPackages.index'));
        }

        return view('admin_packages.edit')->with('adminPackage', $adminPackage);
    }

    /**
     * Update the specified AdminPackage in storage.
     *
     * @param  int              $id
     * @param UpdateAdminPackageRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAdminPackageRequest $request)
    {
        $adminPackage = $this->adminPackageRepository->findWithoutFail($id);

        if (empty($adminPackage)) {
            Flash::error('Admin Package not found');

            return redirect(route('adminPackages.index'));
        }

        $adminPackage = $this->adminPackageRepository->update($request->all(), $id);

        Flash::success('Admin Package updated successfully.');

        return redirect(route('adminPackages.index'));
    }

    /**
     * Remove the specified AdminPackage from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $adminPackage = $this->adminPackageRepository->findWithoutFail($id);

        if (empty($adminPackage)) {
            Flash::error('Admin Package not found');

            return redirect(route('adminPackages.index'));
        }

        $this->adminPackageRepository->delete($id);

        Flash::success('Admin Package deleted successfully.');

        return redirect(route('adminPackages.index'));
    }
}
