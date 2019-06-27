<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateTeamSaleRequest;
use App\Http\Requests\UpdateTeamSaleRequest;
use App\Repositories\TeamSaleRepository;
use App\Repositories\ProductRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Product;
use App\Models\SpecProductPrice;
use App\Models\TeamSale;
use Illuminate\Support\Facades\Input;
use App\Repositories\FlashSaleRepository;

class TeamSaleController extends AppBaseController
{
    /** @var  TeamSaleRepository */
    private $teamSaleRepository;
    private $productRepository;
    private $flashSaleRepository;
    public function __construct(TeamSaleRepository $teamSaleRepo,ProductRepository $productRepo,FlashSaleRepository $flashSaleRepo)
    {
        $this->teamSaleRepository = $teamSaleRepo;
        $this->productRepository=$productRepo;
        $this->flashSaleRepository=$flashSaleRepo;
    }

    /**
     * Display a listing of the TeamSale.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->teamSaleRepository->pushCriteria(new RequestCriteria($request));
        $teamSales =TeamSale::where('id','>','0');
        $input=$request->all();
        $tools=$this->varifyTools($input);
        $created_desc_status=true;

        if(array_key_exists('name', $input)){
            $teamSales=$teamSales->where('name','like','%'.$input['name'].'%');
        }
        if(array_key_exists('type', $input) && !empty($input['type'])){
            $teamSales=$teamSales->where('type',$input['type']);
        }
        if(array_key_exists('price_sort', $input) && !empty($input['price_sort'])){
            $teamSales=$teamSales->orderBy('price',$input['price_sort']==0?'asc':'desc');
            $created_desc_status=false;
        }

        if($created_desc_status){
            $teamSales=$teamSales->orderBy('created_at','desc');
        }

        $teamSales=$this->accountInfo($teamSales);
        return view('admin.team_sales.index')
            ->with('teamSales', $teamSales)
            ->with('tools',$tools)
            ->withInput(Input::all());
    }

    /**
     * Show the form for creating a new TeamSale.
     *
     * @return Response
     */
    public function create()
    {
        $product_spec=null;
        return view('admin.team_sales.create')
                ->with('product_spec',$product_spec)
                ->with('teamSale',null);
    }

    /**
     * Store a newly created TeamSale in storage.
     *
     * @param CreateTeamSaleRequest $request
     *
     * @return Response
     */
    public function store(CreateTeamSaleRequest $request)
    {
        $input = $request->all();

        if(array_key_exists('product_spec',$input) && !empty($input['product_spec']) ) {
            $input=$this->progressTeamSale($input,$input['product_spec']);
        }else{
            return redirect(route('teamSales.create'))
                ->withErrors('请选择参加活动的商品')
                ->withInput($input);
        }
        //return $input;
        $input = attachAccoutInput($input);
        
        $teamSale = $this->teamSaleRepository->create($input);

        $this->updateTeamSaleInfo($teamSale);

        Flash::success('保存成功');

        return redirect(route('teamSales.index'));
    }

    /**
     * Display the specified TeamSale.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $teamSale = $this->teamSaleRepository->findWithoutFail($id);

        if (empty($teamSale)) {
            Flash::error('Team Sale not found');

            return redirect(route('teamSales.index'));
        }

        return view('admin.team_sales.show')->with('teamSale', $teamSale);
    }

    /**
     * Show the form for editing the specified TeamSale.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $teamSale = $this->teamSaleRepository->findWithoutFail($id);
        $product_spec=$teamSale->product_id.'_'.(is_null($teamSale->spec_id)?'0':$teamSale->spec_id);
        //return $product_spec;
        if (empty($teamSale)) {
            Flash::error('Team Sale not found');

            return redirect(route('teamSales.index'));
        }
        $product_id=$teamSale->product_id;
        //$spec_id=$teamSale->spec_id;
        //if($spec_id==0) {
            $product =$this->productRepository->findWithoutFail($product_id);
        // }else{
        //     $product=$this->specProductPriceRepository->findWithoutFail($spec_id);
        // }
        return view('admin.team_sales.edit')
                ->with('teamSale', $teamSale)
                ->with('product_spec',$product_spec)
                ->with('product',$product);
                //->with('spec_id',$spec_id);
    }

    /**
     * Update the specified TeamSale in storage.
     *
     * @param  int              $id
     * @param UpdateTeamSaleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTeamSaleRequest $request)
    {
        $input=$request->all();
        if(array_key_exists('product_spec',$input) && !empty($input['product_spec']) ) {
            $input=$this->progressTeamSale($input,$input['product_spec']);
        }else{
            return redirect(route('teamSales.edit',$id))
                ->withErrors('请选择参加活动的商品')
                ->withInput($input);
        }
        $teamSale = $this->teamSaleRepository->findWithoutFail($id);

        if (empty($teamSale)) {
            Flash::error('Team Sale not found');

            return redirect(route('teamSales.index'));
        }

        $teamSale = $this->teamSaleRepository->update($input, $id);
        $this->updateTeamSaleInfo($teamSale);

        Flash::success('更新成功');

        return redirect(route('teamSales.index'));
    }

    /**
     * Remove the specified TeamSale from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $teamSale = $this->teamSaleRepository->findWithoutFail($id);

        if (empty($teamSale)) {
            Flash::error('Team Sale not found');

            return redirect(route('teamSales.index'));
        }

        $this->teamSaleRepository->delete($id);
        //if($teamSale->spec_id==0) {
            $this->productRepository->resetPrompByPromId($id);
        // }else{
        //     $this->specProductPriceRepository->resetPrompByPromId($id);
        //     $this->productRepository->resetPrompByPromId($id);
        // }
        Flash::success('Team Sale deleted successfully.');

        return redirect(route('teamSales.index'));
    }


    private function progressTeamSale($inputs,$product_spec){
        $product_spec_arr=explode('_',$product_spec);
        //if($product_spec_arr[1]=="0") {
            $inputs['product_id']=$product_spec_arr[0];
            $inputs['spec_id']=0;
            $product=$this->productRepository->findWithoutFail($inputs['product_id']);
            if(!empty($product)){
                $inputs['origin_price']=$product->price;
            }
        // }else{
        //     $inputs['product_id']=$product_spec_arr[0];
        //     $inputs['spec_id']=$product_spec_arr[1];
        //     $product=$this->productRepository->findWithoutFail($inputs['product_id']);
        //     $product_spec=$this->specProductPriceRepository->findWithoutFail($inputs['spec_id']);
        //     if(!empty($product_spec)) {
        //         $inputs['origin_price'] = $product_spec->price;
        //     }
        // }
        return $inputs;
    }

    private function updateTeamSaleInfo($teamSale){
        //等于0只有商品没有规格信息
        //if($teamSale->spec_id==0){
            $this->productRepository->updateProductPrompType($teamSale->product_id,$teamSale->id,5);
           // $this->flashSaleRepository->deleteReplaceProductByProductIdOrSpecId($teamSale->product_id);
        // }else{
        //     $this->specProductPriceRepository->updateSpecPrompType($teamSale->spec_id,$teamSale->id,5);
        //     $this->productRepository->updateProductPrompType($teamSale->product_id,$teamSale->id,5);
        //     $this->specProductPriceRepository->resetPrivateByProductIdAndSpecIdAndPrompType($teamSale->product_id,$teamSale->spec_id,5);
        //     //$this->flashSaleRepository->deleteReplaceProductByProductIdOrSpecId($teamSale->product_id,$teamSale->spec_id);
        // }
    }


}
