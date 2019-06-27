<?php

namespace App\Http\Controllers\Admin\Shop;

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
use App\Models\ServicesUser;
use Carbon\Carbon;

class ManagerController extends AppBaseController
{
    /** @var  managerRepository */
    private $managerRepository;



    public function __construct(ManagerRepository $managerRepo)
    {
        $this->managerRepository = $managerRepo;

    }

    
    /**
     * 小程序服务使用成功提示
     *
     * @SWG\Get(path="/api/mini_program/services_success_notify",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序服务使用成功提示",
     *   description="小程序服务使用成功提示,不需要token信息",
     *   operationId="servicesSuccessNotifyUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="nickname",
     *     type="string",
     *     description="昵称",
           ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,status_code=2服务还未使用,data返回提示信息",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期",
     *     )
     * )
     */
    public function servicesSuccessNotify(Request $request){
        $service_user = ServicesUser::find($request->input('id'));
        //$old_num = $service_user->num;
        if(!empty($service_user)){
            if($service_user->status=='已使用'){
                return zcjy_callback_data('服务使用成功');
            }
            else{
                return zcjy_callback_data('服务还未使用',2);
            }
        }
        else{
            return zcjy_callback_data('该服务不存在',1);
        }
    }

    //确认服务消耗 如果服务次数是多次每次减1 如果只有1次直接消耗
    public function enterServiceConsumption(Request $request){
        $input = $request->all();

        $sevice_user = ServicesUser::find($input['service_user_id']);

        if(empty($sevice_user)){
            return zcjy_callback_data('该服务不存在',1,'web');
        }

        $user = $sevice_user->user()->first();

        $service =  $sevice_user->service()->first();

        #确保account一致
        if($input['account'] == $user->account && $input['account'] ==  $service->account){
            #如果服务剩余次数等于0 更新为已使用
            $sevice_user->update(['status' => '已使用','use_time'=>Carbon::now(),'use_shop'=>$input['shop']]);

            #提示给用户和商户 服务已使用
            #通知商户
            sendNotice(admin($user->account)->id,'用户'.a_link($user->nickname,'/zcjy/users/'.$user->id).'在您的店铺下的'.a_link('[服务]'.$service->name.'','/zcjy/services/'.$service->id.'/edit').tag('已使用').',使用店铺是'.tag($input['shop']).',使用时间是'.Carbon::now());

            #通知用户 
            sendNotice($user->id,'您的服务['.$service->name.']已使用,使用店铺是'.$input['shop'].',使用时间是'.Carbon::now().',请在个人中心查看',false);

            #如果大于1更新剩余次数 

            return zcjy_callback_data('服务使用成功',0,'web');
        }
        else{
            return zcjy_callback_data('account信息输入错误',1,'web');
        }
    }

    public function varify(Request $request){
        $input = $request->all();
        if(!array_key_exists('key',$input) || !array_key_exists('service_user_id',$input)){
            return redirect('/');
        }
        $input = optional($input);
        $sevice_user = ServicesUser::find($input['service_user_id']);
        $shops = $sevice_user->service()->first()->shops()->get();
        return view('admin.varify.index',compact('input','shops'));
    }

    //操作后跳转
    private function redirect_url(){

        return redirect(route('shopBranchManagers.index'));
        
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
        }
        
        $parent = admin()->id;

        $managers = $this->managerRepository->allManager($input['type'],$parent);

        return view('admin.managers.index')
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

        $input['type'] = '商户';
        #该账号下的所有店铺
        $shops = app('commonRepo')->shopRepo()->allAccountShop(admin()->account);
        #选中的店铺
        $selectedShops = [];
        return view('admin.managers.create',compact('input','shops','selectedShops'));
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
     
        if(!array_key_exists('shops', $input) || array_key_exists('shops', $input) && empty($input['shops'])){
              return redirect(route('shopBranchManagers.create'))
                        ->withErrors('请选择管理店铺')
                        ->withInput($input);
        }

        $input['password'] = Hash::make($input['password']);
        $input['parent_id'] = admin()->id;
        $input['member_end'] = admin()->member_end;
        $input['account'] = admin()->account;

        $manager = $this->managerRepository->create($input);

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

        return view('admin.managers.show')->with('manager', $manager);
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

        #该账号下的所有店铺
        $shops = app('commonRepo')->shopRepo()->allAccountShop(admin()->account);
        #选中的店铺
        $selectedShops = [];

        $tmparray = $manager->shops()->get()->toArray();
        
        foreach ($tmparray as $key => $val) {
             array_push($selectedShops, $val['id']);
        }

        return view('admin.managers.edit')
            ->with('manager', $manager)
            ->with('input',$input)
            ->with('shops',$shops)
            ->with('selectedShops',$selectedShops);
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

        if(!array_key_exists('shops', $input) || array_key_exists('shops', $input) && empty($input['shops'])){
              return redirect(route('shopBranchManagers.edit',$id))
                        ->withErrors('请选择管理店铺')
                        ->withInput($input);
        }

        $input = array_filter( $input, function($v, $k) {
            return $v != '';
        }, ARRAY_FILTER_USE_BOTH );

        if(array_key_exists('password',$input) && !empty($input['password'])){
             $input['password'] = Hash::make($input['password']);
        }

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
