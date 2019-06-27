<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateBankSetsRequest;
use App\Http\Requests\UpdateBankSetsRequest;
use App\Repositories\BankSetsRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Config;
use app\Permission;
use Illuminate\Support\Facades\Auth;

class PermissionsController extends AppBaseController
{
    /** @var  BankSetsRepository */
    private $bankSetsRepository;

    public function __construct(BankSetsRepository $bankSetsRepo)
    {
        $this->bankSetsRepository = $bankSetsRepo;
    }

    /**
     * Display a listing of the BankSets.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->bankSetsRepository->pushCriteria(new RequestCriteria($request));
        $input=$request->all();
        $tools=$this->varifyTools($input);
        $group=Config::get('rolesgroupfunc');
        $pemissions_list=Permission::orderBy('created_at','desc');
        if(array_key_exists('display_name',$input)){
            $pemissions_list=$pemissions_list->where('display_name','like','%'.$input['display_name'].'%');
        }
        if(array_key_exists('model',$input)){
            if(!empty($input['model'])) {
                $pemissions_list = $pemissions_list->where('model', $input['model']);
            }
        }
        if(array_key_exists('group',$input)){
            if(!empty($input['group'])) {
                $pemissions_list = $pemissions_list->where('tid', $input['group']);
            }
        }
        if(array_key_exists('name',$input)){
            $pemissions_list=$pemissions_list->where('name','like','%'.$input['name'].'%');
        }
        if(array_key_exists('type',$input)){
            if(!empty($input['type'])) {
                $pemissions_list = $pemissions_list->where('description', $input['type']);
            }
        }

        $pemissions_list=$pemissions_list->paginate($this->defaultPage());
        return view('admin.permissions.index',compact('tools','pemissions_list','input','group'));

    }

    /**
     * Show the form for creating a new BankSets.
     *
     * @return Response
     */
    public function create()
    {
        $group=Config::get('rolesgroupfunc');
        return view('admin.permissions.create')->with('group',$group);
    }

    /**
     * Store a newly created BankSets in storage.
     *
     * @param CreateBankSetsRequest $request
     *
     * @return Response
     */
    public function store(CreateBankSetsRequest $request)
    {
        $input = $request->all();

        if($input['tid']=='new'){
           $perm= Permission::orderBy('tid','desc')->first();
           if(!empty($perm)){
               $input['tid']=($perm->tid)+1;
           }
        }
        $permissions = Permission::create($input);

        Flash::success('保存成功.');

        return redirect(route('permissions.index'));
    }


    public function addPermToAdmin($id){
        $admin=Auth::guard('admin')->user();
        $role=$admin->roles()->first();
        if(!empty($role)) {
            $role->perms()->attach($id);
            return ['code'=>0,'message'=>'赋予权限成功'];
            }else{
            return ['code'=>1,'message'=>'未知错误'];
        }
    }


    public function delPermToAdmin($id){
        $admin=Auth::guard('admin')->user();
        $role=$admin->roles()->first();
        if(!empty($role)) {
            $role->perms()->detach($id);
            return ['code'=>0,'message'=>'移除权限成功'];
        }else{
            return ['code'=>1,'message'=>'未知错误'];
        }

    }
    /**
     * Display the specified BankSets.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $bankSets = $this->bankSetsRepository->findWithoutFail($id);

        if (empty($bankSets)) {
            Flash::error('Bank Sets not found');

            return redirect(route('bankSets.index'));
        }

        return view('admin.bank_sets.show')->with('bankSets', $bankSets);
    }

    /**
     * Show the form for editing the specified BankSets.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $bankSets = $this->bankSetsRepository->findWithoutFail($id);

        if (empty($bankSets)) {
            Flash::error('Bank Sets not found');

            return redirect(route('bankSets.index'));
        }

        return view('admin.bank_sets.edit')->with('bankSets', $bankSets);
    }

    /**
     * Update the specified BankSets in storage.
     *
     * @param  int              $id
     * @param UpdateBankSetsRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBankSetsRequest $request)
    {
        $bankSets = $this->bankSetsRepository->findWithoutFail($id);

        if (empty($bankSets)) {
            Flash::error('Bank Sets not found');

            return redirect(route('bankSets.index'));
        }

        $bankSets = $this->bankSetsRepository->update($request->all(), $id);

        Flash::success('保存成功.');

        return redirect(route('bankSets.index'));
    }

    /**
     * Remove the specified BankSets from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $bankSets = $this->bankSetsRepository->findWithoutFail($id);

        if (empty($bankSets)) {
            Flash::error('Bank Sets not found');

            return redirect(route('bankSets.index'));
        }

        $this->bankSetsRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('bankSets.index'));
    }
}
