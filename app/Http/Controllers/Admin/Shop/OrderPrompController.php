<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateOrderPrompRequest;
use App\Http\Requests\UpdateOrderPrompRequest;
use App\Repositories\OrderPrompRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Illuminate\Support\Facades\Input;
use App\Models\OrderPromp;

class OrderPrompController extends AppBaseController
{
    /** @var  OrderPrompRepository */
    private $orderPrompRepository;

    public function __construct(OrderPrompRepository $orderPrompRepo)
    {
        $this->orderPrompRepository = $orderPrompRepo;
    }

    /**
     * Display a listing of the OrderPromp.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->orderPrompRepository->pushCriteria(new RequestCriteria($request));
        $orderPromps = OrderPromp::orderBy('created_at','desc');
        $input=$request->all();
        $tools=$this->varifyTools($input);
        if(array_key_exists('name', $input)){
            $orderPromps=$orderPromps->where('name','like','%'.$input['name'].'%');
        }
        if(array_key_exists('type', $input) && !empty($input['type'])){
            $orderPromps=$orderPromps->where('type',$input['type']);
        }
        if(array_key_exists('start_time',$input) && !empty($input['start_time'])){
            $orderPromps=$orderPromps->where('time_begin','>=',$input['start_time']);
        }
        if(array_key_exists('end_time',$input) && !empty($input['end_time'])){
            $orderPromps=$orderPromps->where('time_end','<',$input['end_time']);
        }

        $orderPromps=$this->accountInfo($orderPromps);

        return view('admin.order_promps.index')
            ->with('orderPromps', $orderPromps)
            ->with('tools',$tools)
            ->withInput(Input::all());
    }

    /**
     * Show the form for creating a new OrderPromp.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.order_promps.create');
    }

    /**
     * Store a newly created OrderPromp in storage.
     *
     * @param CreateOrderPrompRequest $request
     *
     * @return Response
     */
    public function store(CreateOrderPrompRequest $request)
    {
        $input = $request->all();

        $orderPromp = $this->orderPrompRepository->create($input);

        Flash::success('保存成功');

        return redirect(route('orderPromps.index'));
    }

    /**
     * Display the specified OrderPromp.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $orderPromp = $this->orderPrompRepository->findWithoutFail($id);

        if (empty($orderPromp)) {
            Flash::error('Order Promp not found');

            return redirect(route('orderPromps.index'));
        }

        return view('admin.order_promps.show')->with('orderPromp', $orderPromp);
    }

    /**
     * Show the form for editing the specified OrderPromp.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $orderPromp = $this->orderPrompRepository->findWithoutFail($id);

        if (empty($orderPromp)) {
            Flash::error('Order Promp not found');

            return redirect(route('orderPromps.index'));
        }

        return view('admin.order_promps.edit')->with('orderPromp', $orderPromp);
    }

    /**
     * Update the specified OrderPromp in storage.
     *
     * @param  int              $id
     * @param UpdateOrderPrompRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOrderPrompRequest $request)
    {
        $orderPromp = $this->orderPrompRepository->findWithoutFail($id);

        if (empty($orderPromp)) {
            Flash::error('Order Promp not found');

            return redirect(route('orderPromps.index'));
        }

        $orderPromp = $this->orderPrompRepository->update($request->all(), $id);

        Flash::success('更新成功');

        return redirect(route('orderPromps.index'));
    }

    /**
     * Remove the specified OrderPromp from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $orderPromp = $this->orderPrompRepository->findWithoutFail($id);

        if (empty($orderPromp)) {
            Flash::error('Order Promp not found');

            return redirect(route('orderPromps.index'));
        }

        $this->orderPrompRepository->delete($id);

        Flash::success('Order Promp deleted successfully.');

        return redirect(route('orderPromps.index'));
    }
}
