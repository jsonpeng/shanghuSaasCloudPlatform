<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Repositories\RoleRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Permission;

class RoleController extends AppBaseController
{
    /** @var  roleRepository */
    private $roleRepository;

    public function __construct(RoleRepository $roleRepo)
    {
        $this->roleRepository = $roleRepo;
    }

    /**
     * Display a listing of the Role.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->roleRepository->pushCriteria(new RequestCriteria($request));
        $roles = $this->roleRepository->all();

        $roles = $roles->filter(function ($value) {
            return $value->name != 'super_admin';
        });

        return view('admin.roles.index')
            ->with('roles', $roles);
    }

    /**
     * Show the form for creating a new Role.
     *
     * @return Response
     */
    public function create()
    {
        $permissions = Permission::all();

        //dd($permissions);
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param CreateRoleRequest $request
     *
     * @return Response
     */
    public function store(CreateRoleRequest $request)
    {
        $input = $request->all();

        $role = $this->roleRepository->create($input);
        if (array_key_exists('permissions', $input)) {
            $role->perms()->sync($input['permissions']);
        }

        Flash::success('Role saved successfully.');

        return redirect(route('roles.index'));
    }

    /**
     * Display the specified Role.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $role = $this->roleRepository->findWithoutFail($id);
        $permissions = $role->perms()->get();
        //dd($permissions);
        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('roles.index'));
        }

        return view('admin.roles.show')->with('role', $role)->with('permissions', $permissions);
    }

    /**
     * Show the form for editing the specified Role.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $role = $this->roleRepository->findWithoutFail($id);

        $permissions = Permission::all();

        $selectedPermissions = [];
       $tmparray = $role->perms()->get()->toArray();

        //return $tmparray;
        while (list($key, $val) = each($tmparray)) {
            array_push($selectedPermissions, $val['id']);
        }
        //dd($selectedPermissions);
        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('roles.index'));
        }

        return view('admin.roles.edit')->with('role', $role)->with('permissions', $permissions)->with('selectedPermissions',$selectedPermissions);
    }

    /**
     * Update the specified Role in storage.
     *
     * @param  int              $id
     * @param UpdateRoleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRoleRequest $request)
    {
        $role = $this->roleRepository->findWithoutFail($id);

        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('roles.index'));
        }

        $role = $this->roleRepository->update($request->all(), $id);
        $role->perms()->sync($request->all()['permissions']);

        Flash::success('Role updated successfully.');

        return redirect(route('roles.index'));
    }

    /**
     * Remove the specified Role from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $role = $this->roleRepository->findWithoutFail($id);

        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('roles.index'));
        }

        $this->roleRepository->delete($id);

        Flash::success('Role deleted successfully.');

        return redirect(route('roles.index'));
    }
}
