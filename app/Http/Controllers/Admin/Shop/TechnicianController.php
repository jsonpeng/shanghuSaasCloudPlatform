<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateTechnicianRequest;
use App\Http\Requests\UpdateTechnicianRequest;
use App\Repositories\TechnicianRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class TechnicianController extends AppBaseController
{
    /** @var  TechnicianRepository */
    private $technicianRepository;

    public function __construct(TechnicianRepository $technicianRepo)
    {
        $this->technicianRepository = $technicianRepo;
    }

    /**
     * Display a listing of the Technician.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->technicianRepository->pushCriteria(new RequestCriteria($request));
        //$technicians = $this->technicianRepository->all();

        $technicians = $this->defaultSearchState($this->technicianRepository);
   
        $technicians = $this->accountInfo($technicians);
        
        return view('admin.technicians.index')
            ->with('technicians', $technicians);
    }

    /**
     * Show the form for creating a new Technician.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.technicians.create')
                ->with('workdays',[]);
    }

    /**
     * Store a newly created Technician in storage.
     *
     * @param CreateTechnicianRequest $request
     *
     * @return Response
     */
    public function store(CreateTechnicianRequest $request)
    {
        $input = $request->all();

        if(!array_key_exists('services_id', $input) || array_key_exists('services_id', $input) && empty($input['services_id'])){
             return redirect(route('technicians.create'))
                        ->withErrors('请选择服务')
                        ->withInput($input);
        }

        $input['workday'] = implode(',',$input['workday']);

        $input = attachAccoutInput($input);

        $technician = $this->technicianRepository->create($input);

        #关联服务
        $technician->services()->sync($input['services_id']);

        Flash::success('保存成功');

        return redirect(route('technicians.index'));
    }

    /**
     * Display the specified Technician.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $technician = $this->technicianRepository->findWithoutFail($id);

        if (empty($technician)) {
            Flash::error('没有找到该技师');

            return redirect(route('technicians.index'));
        }

        return view('admin.technicians.show')->with('technician', $technician);
    }

    /**
     * Show the form for editing the specified Technician.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $technician = $this->technicianRepository->findWithoutFail($id);

        if (empty($technician)) {
            Flash::error('没有找到该技师');
            return redirect(route('technicians.index'));
        }
        $services = $technician->services()->get();
        $workdays = explode(',',  $technician->workday);
        
        return view('admin.technicians.edit')
            ->with('technician', $technician)
            ->with('services',$services)
            ->with('workdays',$workdays);
    }

    /**
     * Update the specified Technician in storage.
     *
     * @param  int              $id
     * @param UpdateTechnicianRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTechnicianRequest $request)
    {
        $technician = $this->technicianRepository->findWithoutFail($id);

        if (empty($technician)) {
            Flash::error('没有找到该技师');

            return redirect(route('technicians.index'));
        }
        $input = $request->all();

        if(!array_key_exists('services_id', $input) || array_key_exists('services_id', $input) && empty($input['services_id'])){
             return redirect(route('technicians.create'))
                        ->withErrors('请选择服务')
                        ->withInput($input);
        }

        $input['workday'] = implode(',',$input['workday']);

        $technician = $this->technicianRepository->update($input, $id);

        #关联服务
        $technician->services()->sync($input['services_id']);

        Flash::success('更新成功.');

        return redirect(route('technicians.index'));
    }

    /**
     * Remove the specified Technician from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $technician = $this->technicianRepository->findWithoutFail($id);

        if (empty($technician)) {
            Flash::error('没有找到该技师');

            return redirect(route('technicians.index'));
        }

        #置空服务
        $technician->services()->sync([]);

        $this->technicianRepository->delete($id);

        Flash::success('删除成功.');

        return redirect(route('technicians.index'));
    }
}
