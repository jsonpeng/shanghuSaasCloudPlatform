<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateServicesRequest;
use App\Http\Requests\UpdateServicesRequest;
use App\Repositories\ServicesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ServicesController extends AppBaseController
{
    /** @var  ServicesRepository */
    private $servicesRepository;

    public function __construct(ServicesRepository $servicesRepo)
    {
        $this->servicesRepository = $servicesRepo;
    }

    /**
     * Display a listing of the Services.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->servicesRepository->pushCriteria(new RequestCriteria($request));

        $services = account($this->servicesRepository->model(),null,true)
                ->orWhere('all_use',1)
                ->orderBy('created_at','desc')
                ->paginate(defaultPage());


        return view('admin.services.index')
            ->with('services', $services);
    }


    public function servicesIframe(Request $request){
        $input =$request->all();

        $services = account($this->servicesRepository->model(),null,true)
                ->orWhere('all_use',1)
                ->orderBy('created_at','desc');
              

        if(array_key_exists('name',$input)){
             $services =  $services->where('name','like','%'.$input['name'].'%');
        }

        $services =  $services->paginate(defaultPage());

        $services_num = count($services);

        return view('admin.services.iframe')
              ->with('services',$services)
              ->with('services_num',$services_num)
              ->with('input',$input);
    }

    /**
     * Show the form for creating a new Services.
     *
     * @return Response
     */
    public function create()
    {

        $shops = app('commonRepo')->shopRepo()->allAccountShop(admin()->account);

        return view('admin.services.create')
            ->with('shops',$shops)
            ->with('selectedShops',[]);
    }

    /**
     * 关联店铺操作
     * @param  [type] $input    [description]
     * @param  [type] $services [description]
     * @return [type]           [description]
     */
    private function attachShop($input,$services){
        $flag = true;
        if ( array_key_exists('shops', $input) && !empty($input['shops'])) {
            $services->shops()->sync($input['shops']);
        }else{
            $flag = false;
        } 
        return $flag;  
    }

    /**
     * 验证表单提交信息
     * @param  [type] $input [description]
     * @return [type]        [description]
     */
    private function validateInput($input){
        $flag = false;
        if($input['time_type'] == 0){
            if(empty($input['time_begin']) || empty($input['time_end'])){
                $flag = '请选择有效期';
            }
        }else{
            if(empty($input['expire_days'])){
                $flag = '请选择固定天数';
            }
        }
        return $flag;
    }

    /**
     * Store a newly created Services in storage.
     *
     * @param CreateServicesRequest $request
     *
     * @return Response
     */
    public function store(CreateServicesRequest $request)
    {
        $input = $request->all();

        $input = attachAccoutInput($input);

        $validate = $this->validateInput($input);

        if($validate){
            return redirect(route('services.create'))
                        ->withErrors($validate)
                        ->withInput($input);
        }

        array_key_exists('all_use',$input) 
        ?
            $input['all_use'] = 1
        :
            $input['all_use'] = 0;

        $services = $this->servicesRepository->create($input);


        Flash::success('保存成功.');

        return redirect(route('services.index'));
    }

    /**
     * Display the specified Services.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $services = $this->servicesRepository->findWithoutFail($id);

        if (empty($services)) {
            Flash::error('Services not found');

            return redirect(route('services.index'));
        }

        return view('admin.services.show')->with('services', $services);
    }

    /**
     * Show the form for editing the specified Services.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $services = $this->servicesRepository->findWithoutFail($id);

        if (empty($services)) {
            Flash::error('Services not found');

            return redirect(route('services.index'));
        }
 
    
        return view('admin.services.edit')
            ->with('services', $services);
    }

    /**
     * Update the specified Services in storage.
     *
     * @param  int              $id
     * @param UpdateServicesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateServicesRequest $request)
    {
        $services = $this->servicesRepository->findWithoutFail($id);

        if (empty($services)) {
            Flash::error('Services not found');

            return redirect(route('services.index'));
        }
        $input = $request->all();

        $validate = $this->validateInput($input);

        if($validate){
            return redirect(route('services.edit',$services->id))
                        ->withErrors($validate)
                        ->withInput($input);
        }

        array_key_exists('all_use',$input) 
        ?
            $input['all_use'] = 1
        :
            $input['all_use'] = 0;
       
    
        $services = $this->servicesRepository->update($input, $id);

  
        Flash::success('更新成功.');

        return redirect(route('services.index'));
    }

    /**
     * Remove the specified Services from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $services = $this->servicesRepository->findWithoutFail($id);

        if (empty($services)) {
            Flash::error('Services not found');

            return redirect(route('services.index'));
        }
        #删除关联店铺
        $services->shops()->sync([]);

        $this->servicesRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('services.index'));
    }
}
