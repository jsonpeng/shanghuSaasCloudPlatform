<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateCreditServiceUserRequest;
use App\Http\Requests\UpdateCreditServiceUserRequest;
use App\Repositories\CreditServiceUserRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class CreditServiceUserController extends AppBaseController
{
    /** @var  CreditServiceUserRepository */
    private $creditServiceUserRepository;

    public function __construct(CreditServiceUserRepository $creditServiceUserRepo)
    {
        $this->creditServiceUserRepository = $creditServiceUserRepo;
    }

    /**
     * Display a listing of the CreditServiceUser.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->creditServiceUserRepository->pushCriteria(new RequestCriteria($request));

        $creditServiceUsers = $this->defaultSearchState($this->creditServiceUserRepository);

        $creditServiceUsers = $this->accountInfo($creditServiceUsers);
      
        return view('admin.credit_service_users.index')
            ->with('creditServiceUsers', $creditServiceUsers);
    }

    /**
     * Show the form for creating a new CreditServiceUser.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.credit_service_users.create');
    }

    /**
     * Store a newly created CreditServiceUser in storage.
     *
     * @param CreateCreditServiceUserRequest $request
     *
     * @return Response
     */
    public function store(CreateCreditServiceUserRequest $request)
    {
        $input = $request->all();

        $creditServiceUser = $this->creditServiceUserRepository->create($input);

        Flash::success('Credit Service User saved successfully.');

        return redirect(route('creditServiceUsers.index'));
    }

    /**
     * Display the specified CreditServiceUser.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $creditServiceUser = $this->creditServiceUserRepository->findWithoutFail($id);

        if (empty($creditServiceUser)) {
            Flash::error('Credit Service User not found');

            return redirect(route('creditServiceUsers.index'));
        }

        return view('admin.credit_service_users.show')->with('creditServiceUser', $creditServiceUser);
    }

    /**
     * Show the form for editing the specified CreditServiceUser.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $creditServiceUser = $this->creditServiceUserRepository->findWithoutFail($id);

        if (empty($creditServiceUser)) {
            Flash::error('Credit Service User not found');

            return redirect(route('creditServiceUsers.index'));
        }

        return view('admin.credit_service_users.edit')->with('creditServiceUser', $creditServiceUser);
    }

    /**
     * Update the specified CreditServiceUser in storage.
     *
     * @param  int              $id
     * @param UpdateCreditServiceUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCreditServiceUserRequest $request)
    {
        $creditServiceUser = $this->creditServiceUserRepository->findWithoutFail($id);

        if (empty($creditServiceUser)) {
            Flash::error('Credit Service User not found');

            return redirect(route('creditServiceUsers.index'));
        }

        $creditServiceUser = $this->creditServiceUserRepository->update($request->all(), $id);

        Flash::success('Credit Service User updated successfully.');

        return redirect(route('creditServiceUsers.index'));
    }

    /**
     * Remove the specified CreditServiceUser from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $creditServiceUser = $this->creditServiceUserRepository->findWithoutFail($id);

        if (empty($creditServiceUser)) {
            Flash::error('Credit Service User not found');

            return redirect(route('creditServiceUsers.index'));
        }

        $this->creditServiceUserRepository->delete($id);

        Flash::success('Credit Service User deleted successfully.');

        return redirect(route('creditServiceUsers.index'));
    }
}
