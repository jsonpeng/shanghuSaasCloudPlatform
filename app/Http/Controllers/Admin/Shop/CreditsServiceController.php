<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateCreditsServiceRequest;
use App\Http\Requests\UpdateCreditsServiceRequest;
use App\Repositories\CreditsServiceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class CreditsServiceController extends AppBaseController
{
    /** @var  CreditsServiceRepository */
    private $creditsServiceRepository;

    public function __construct(CreditsServiceRepository $creditsServiceRepo)
    {
        $this->creditsServiceRepository = $creditsServiceRepo;
    }

    /**
     * Display a listing of the CreditsService.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->creditsServiceRepository->pushCriteria(new RequestCriteria($request));
 
        $creditsServices = $this->defaultSearchState($this->creditsServiceRepository);

        $creditsServices = $this->accountInfo($creditsServices);

        return view('admin.credits_services.index')
            ->with('creditsServices', $creditsServices);
    }

    /**
     * Show the form for creating a new CreditsService.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.credits_services.create');
    }

    /**
     * Store a newly created CreditsService in storage.
     *
     * @param CreateCreditsServiceRequest $request
     *
     * @return Response
     */
    public function store(CreateCreditsServiceRequest $request)
    {
        $input = $request->all();

        $input = $this->dealInput($input,$request);
        
        if($input['type'] == '服务' && empty($input['service_id'])){
              return redirect(route('creditsServices.create'))
                    ->withErrors('请选择服务')
                    ->withInput($input);
        }

        $creditsService = $this->creditsServiceRepository->create($input);

        Flash::success('保存成功.');

        return redirect(route('creditsServices.index'));
    }


    /**
     * 处理input输入
     * @param  [type] $input [description]
     * @return [type]        [description]
     */
    private function dealInput($input,$request){
        #添加account信息
        $input = attachAccoutInput($input);

        #处理content 
        if (array_key_exists('content', $input)) {
            $input['content'] = str_replace("../../../", $request->getSchemeAndHttpHost().'/' ,$input['content']);
            $input['content'] = str_replace("../../", $request->getSchemeAndHttpHost().'/' ,$input['content']);
        }

        $input['service_id'] = null;

        #处理服务id
        if($input['type'] == '服务'){
            if(array_key_exists('services_id', $input)){
                $input['service_id'] = $input['services_id'][0];
            }
        }

        #处理次数
        if(empty($input['count_time'])){
            $input['count_time'] = 0;
        }

        return $input;
    }


    /**
     * Display the specified CreditsService.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $creditsService = $this->creditsServiceRepository->findWithoutFail($id);

        if (empty($creditsService)) {
            Flash::error('没有该积分');

            return redirect(route('creditsServices.index'));
        }

        return view('admin.credits_services.show')->with('creditsService', $creditsService);
    }

    /**
     * Show the form for editing the specified CreditsService.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $creditsService = $this->creditsServiceRepository->findWithoutFail($id);

        if (empty($creditsService)) {
            Flash::error('没有该积分');

            return redirect(route('creditsServices.index'));
        }

        $service = null;

        if($creditsService->type == '服务'){
            $service = $creditsService->service()->first();
        }

        return view('admin.credits_services.edit')
        ->with('creditsService', $creditsService)
        ->with('service',$service);
    }

    /**
     * Update the specified CreditsService in storage.
     *
     * @param  int              $id
     * @param UpdateCreditsServiceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCreditsServiceRequest $request)
    {
        $creditsService = $this->creditsServiceRepository->findWithoutFail($id);

        if (empty($creditsService)) {
            Flash::error('没有该积分');

            return redirect(route('creditsServices.index'));
        }

        $old_type = $creditsService->type;

        $input = $request->all();

        $input = $this->dealInput($input,$request);

        if($input['type'] == '服务' && empty($input['service_id'])){
              return redirect(route('creditsServices.edit',$id))
                    ->withErrors('请选择服务')
                    ->withInput($input);
        }

        #如果是从兑换服务转换成兑换礼物 就置空service_id
        if($old_type == '服务' && $input['type'] == '礼物' ){
            $input['service_id'] = null;
        }

        $creditsService = $this->creditsServiceRepository->update($input, $id);

        Flash::success('更新成功.');

        return redirect(route('creditsServices.index'));
    }

    /**
     * Remove the specified CreditsService from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $creditsService = $this->creditsServiceRepository->findWithoutFail($id);

        if (empty($creditsService)) {
            Flash::error('没有该积分');

            return redirect(route('creditsServices.index'));
        }

        $this->creditsServiceRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('creditsServices.index'));
    }
}
