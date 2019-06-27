<?php

namespace App\Http\Controllers\Admin\Proxy;

use App\Http\Requests\CreateManagerRequest;
use App\Http\Requests\UpdateManagerRequest;
use App\Repositories\ManagerRepository;
//use App\Repositories\RoleRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Hash;
use Carbon\Carbon;


class ManagerController extends AppBaseController
{
    /** @var  managerRepository */
    private $managerRepository;



    public function __construct(ManagerRepository $managerRepo)
    {
        $this->managerRepository = $managerRepo;

    }

    //操作后跳转
    private function redirect_url(){
        $uri = '';
        if(session(admin()->id.'_manager') == '代理商'){
            $uri = '?type=代理商';
        }
        return  redirect(route('shopManagers.index').$uri);
        
    }

    /**
     * Display a listing of the Shop.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->managerRepository->pushCriteria(new RequestCriteria($request));

        $input=$request->all();

        if(!array_key_exists('type',$input)){
            $input['type'] = '商户';
            session([admin()->id.'_manager'=>'商户']);
        }
        else{
            $input['type'] = '代理商';
            session([admin()->id.'_manager'=>'代理商']);
        }
        
        $parent = admin()->id;

        $managers = $this->managerRepository->allManager($input['type'],$parent);

        return view('proxy.managers.index')
              ->with('managers', $managers)
              ->with('input',$input);
    }

    /**
     * Show the form for creating a new Shop.
     *
     * @return Response
     */
    public function create(Request $request)
    {
	    $input=$request->all();

       
        $input = $this->proxyInput($input);
        

        return view('proxy.managers.create',compact('input'));
    }

    private function proxyInput($input){
           
            $input['type'] = session(admin()->id.'_manager');
           
            return $input;
    }

    /**
     * Store a newly created Shop in storage.
     *
     * @param CreatemanagerRequest $request
     *
     * @return Response
     */
    public function store(CreatemanagerRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['parent_id'] = admin()->id;
        $days = shop_account_times();
        $input['member_end'] = Carbon::now()->addDays($days);
        $input['account'] = app('commonRepo')->accountString();
        $input['shop_type'] = 1;
        $input = $this->proxyInput($input);
        $manager = $this->managerRepository->create($input);
        
        #为商户生成一个套餐记录
        app('commonRepo')->adminPackageRepo()->generateAdminPackage($manager->id);
     
        sendGroupNotice(notice_template('添加',$manager->type.$manager->nickname),null,'操作消息');

        Flash::success('创建成功');

       return $this->redirect_url();
    }

    /**
     * Display the specified Shop.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $manager = $this->managerRepository->findWithoutFail($id);

        if (empty($manager)) {
            Flash::error('管理员信息不存在');

            return redirect(route('managers.index'));
        }

        return view('proxy.managers.show')->with('manager', $manager);
    }

    /**
     * Show the form for editing the specified Shop.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(Request $request,$id)
    {
        $manager = $this->managerRepository->findWithoutFail($id);
        
        $input=$request->all();

        if (empty($manager)) {
            Flash::error('管理员信息不存在');

            return redirect(route('managers.index'));
        }
       $input = $this->proxyInput($input);

        return view('proxy.managers.edit')
            ->with('manager', $manager)
            ->with('input',$input);
    }

    /**
     * Update the specified Shop in storage.
     *
     * @param  int              $id
     * @param UpdatemanagerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatemanagerRequest $request)
    {
        $manager = $this->managerRepository->findWithoutFail($id);

        if (empty($manager)) {
            Flash::error('管理员信息不存在');

            return redirect(route('managers.index'));
        }

        $input = $request->all();

        $input = array_filter( $input, function($v, $k) {
            return $v != '';
        }, ARRAY_FILTER_USE_BOTH );

        if(array_key_exists('password',$input) && !empty($input['password'])){
             $input['password'] = Hash::make($input['password']);
        }
        $input = $this->proxyInput($input);
        $manager = $this->managerRepository->update($input, $id);

        sendGroupNotice(notice_template('更新',$manager->type.$manager->nickname),null,'操作消息');

        Flash::success('更新成功.');

       return $this->redirect_url();
    }

    /**
     * Remove the specified Shop from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $manager = $this->managerRepository->findWithoutFail($id);

        if (empty($manager)) {
            Flash::error('管理员信息不存在');

            return redirect(route('managers.index'));
        }

        $this->managerRepository->delete($id);

        sendGroupNotice(notice_template('删除',$manager->type.$manager->nickname),null,'操作消息');

        Flash::success('删除成功.');

        return $this->redirect_url();
    }
}
