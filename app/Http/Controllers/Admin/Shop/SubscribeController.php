<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateSubscribeRequest;
use App\Http\Requests\UpdateSubscribeRequest;
use App\Repositories\SubscribeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class SubscribeController extends AppBaseController
{
    /** @var  SubscribeRepository */
    private $subscribeRepository;

    public function __construct(SubscribeRepository $subscribeRepo)
    {
        $this->subscribeRepository = $subscribeRepo;
    }

    /**
     * Display a listing of the Subscribe.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->subscribeRepository->pushCriteria(new RequestCriteria($request));

        $input = $request->all();

        $input = array_filter( $input, function($v, $k) {
            return $v != '';
        }, ARRAY_FILTER_USE_BOTH );

        #打开状态
        $tools=$this->varifyTools($input);

        #初始化索引
        $subscribes  = $this->defaultSearchState($this->subscribeRepository);

        #根据预约人name模糊查询
        if(array_key_exists('subman',$input)){
            $subscribes = $subscribes->where('subman','like','%'.$input['subman'].'%');
        }

        #根据手机号模糊查询
        if(array_key_exists('mobile',$input)){
            $subscribes = $subscribes->where('mobile','like','%'.$input['mobile'].'%');
        }

        #根据到店时间起止查询
        if(array_key_exists('start_time',$input) && !empty($input['start_time'])){
            $subscribes=$subscribes->where('arrive_time','>=',$input['start_time']);
        }
        if(array_key_exists('end_time',$input) && !empty($input['end_time'])){
            $subscribes=$subscribes->where('arrive_time','<',$input['end_time']);
        }

        #根据预约门店查询
        if(array_key_exists('shop',$input)){
            $subscribes = $subscribes->where('shop_id',$input['shop']);
        }
        
        #根据状态查询
        if(array_key_exists('status',$input)){
            $subscribes = $subscribes->where('status',$input['status']);
        }

        #对应account的 并且带上分页
        $subscribes  = $this->accountInfo( $subscribes );

        #店铺
        $shops = app('commonRepo')->shopRepo()->allAccountShop(admin()->account);

        #预约状态
        $status = ['待服务','待分配','已完成','已超时','已取消'];

        return view('admin.subscribes.index')
            ->with('subscribes', $subscribes)
            ->with('input',$input)
            ->with('tools',$tools)
            ->with('shops',$shops)
            ->with('status',$status);
    }

    /**
     * Show the form for creating a new Subscribe.
     *
     * @return Response
     */
    public function create()
    {
        #店铺
        $shops = app('commonRepo')->shopRepo()->allAccountShop(admin()->account);

        #预约状态
        $status = ['待服务','待分配','已完成','已超时','已取消'];

        return view('admin.subscribes.create')
            ->with('shops',$shops)
            ->with('status',$status);
    }

    /**
     * Store a newly created Subscribe in storage.
     *
     * @param CreateSubscribeRequest $request
     *
     * @return Response
     */
    public function store(CreateSubscribeRequest $request)
    {
        $input = $request->all();

        $input = attachAccoutInput($input);

        $input['user_id'] = 0;
        // dd($input);
        $subscribe = $this->subscribeRepository->create($input);

        Flash::success('保存成功.');

        return redirect(route('subscribes.index'));
    }

    public function show()
    {

    }

    /**
     * 今日预约看板
     *
     * @return Response
     */
    public function watch()
    {
     
        $subscribes = $this->subscribeRepository->todaySubscribeList(admin()->account);
        return view('admin.subscribes.show')
            ->with('subscribes',$subscribes);
    }

    /**
     * Show the form for editing the specified Subscribe.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $subscribe = $this->subscribeRepository->findWithoutFail($id);

        if (empty($subscribe)) {
            Flash::error('Subscribe not found');

            return redirect(route('subscribes.index'));
        }
        #店铺
        $shops = app('commonRepo')->shopRepo()->allAccountShop(admin()->account);

        #已选的服务列表
        $selectedServices = app('commonRepo')->shopRepo()->getServiceByShopId($subscribe->shop_id)['message'];

        #已选的技师列表
        $selectedTechnicians =  app('commonRepo')->serviceRepo()->getTechniciansByServicesId($subscribe->service_id)['message'];

        #预约状态
        $status = ['待服务','待分配','已完成','已超时','已取消'];

        return view('admin.subscribes.edit')
        ->with('subscribe', $subscribe)
        ->with('shops',$shops)
        ->with('selectedServices',$selectedServices)
        ->with('selectedTechnicians',$selectedTechnicians)
        ->with('status',$status);
    }

    /**
     * Update the specified Subscribe in storage.
     *
     * @param  int              $id
     * @param UpdateSubscribeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSubscribeRequest $request)
    {
        $subscribe = $this->subscribeRepository->findWithoutFail($id);

        if (empty($subscribe)) {
            Flash::error('Subscribe not found');

            return redirect(route('subscribes.index'));
        }

        $subscribe = $this->subscribeRepository->update($request->all(), $id);


        if(!empty($subscribe->user_id)){
            #通知给用户预约状态
            sendNotice($subscribe->user_id,'您的预约已得到更新,当前状态['.$subscribe->status.'],请在个人中心查看,具体到店时间为'.$subscribe->arrive_time.'请按时到店里完成服务',false);
        }

        Flash::success('更新成功.');


        return redirect(route('subscribes.index'));
    }

    /**
     * Remove the specified Subscribe from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $subscribe = $this->subscribeRepository->findWithoutFail($id);

        if (empty($subscribe)) {
            Flash::error('Subscribe not found');

            return redirect(route('subscribes.index'));
        }

        $this->subscribeRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('subscribes.index'));
    }
}
