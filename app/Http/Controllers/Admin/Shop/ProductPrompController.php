<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateProductPrompRequest;
use App\Http\Requests\UpdateProductPrompRequest;
use App\Repositories\ProductPrompRepository;
use App\Repositories\ProductRepository;
//use App\Repositories\SpecProductPriceRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Product;
use App\Models\SpecProductPrice;
use App\Models\ProductPromp;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Log;


class ProductPrompController extends AppBaseController
{
    /** @var  ProductPrompRepository */
    private $productPrompRepository;
    private $productRepository;
    //private $specProductPriceRepository;
    public function __construct(ProductPrompRepository $productPrompRepo,ProductRepository $productRepo)
    {
        $this->productPrompRepository = $productPrompRepo;
        $this->productRepository=$productRepo;
       //$this->specProductPriceRepository=$specProductPriceRepo;
    }



    /*
     * 分页设置
     */
    public function prompPageSetView(){
        $page_list=empty(getSettingValueByKey('records_per_page'))?5:getSettingValueByKey('records_per_page');
         return view('admin.product_promps.page_set')
             ->with('page_list',$page_list);
    }

    /**
     * Display a listing of the ProductPromp.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->productPrompRepository->pushCriteria(new RequestCriteria($request));
        $productPromps =ProductPromp::orderBy('created_at','desc');
        $input=$request->all();
        $tools=$this->varifyTools($input);

        if(array_key_exists('name', $input)){
            $productPromps=$productPromps->where('name','like','%'.$input['name'].'%');
        }
        if(array_key_exists('type', $input) && !empty($input['type'])){
            $productPromps=$productPromps->where('type',$input['type']);
        }
        if(array_key_exists('start_time',$input) && !empty($input['start_time'])){
            $productPromps=$productPromps->where('time_begin','>=',$input['start_time']);
        }
        if(array_key_exists('end_time',$input) && !empty($input['end_time'])){
           $productPromps=$productPromps->where('time_end','<',$input['end_time']);
        }

        $productPromps=$this->accountInfo($productPromps);

        return view('admin.product_promps.index')
            ->with('tools',$tools)
            ->with('productPromps', $productPromps)
            ->withInput(Input::all());
    }

    /**
     * Show the form for creating a new ProductPromp.
     *
     * @return Response
     */
    public function create()
    {
        $product=[];
        $spec=[];
        return view('admin.product_promps.create')
            ->with('product',$product)
            ->with('spec',$spec);
    }

    /**
     * Store a newly created ProductPromp in storage.
     *
     * @param CreateProductPrompRequest $request
     *
     * @return Response
     */
    public function store(CreateProductPrompRequest $request)
    {
        $input = $request->all();
        if(!array_key_exists( 'product_spec',$input)){
            return redirect(route('productPromps.create'))
                ->withErrors('请选择参加活动的商品')
                ->withInput($input);
        }
        $input = attachAccoutInput($input);
        $productPromp = $this->productPrompRepository->create($input);
        if(array_key_exists( 'product_spec',$input) && !empty($input['product_spec']) ){
            $this->processPromp($input['product_spec'], $productPromp->id);
        }
        Flash::success('保存成功');

        return redirect(route('productPromps.index'));
    }

    /**
     * Display the specified ProductPromp.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $productPromp = $this->productPrompRepository->findWithoutFail($id);

        if (empty($productPromp)) {
            Flash::error('促销信息不存在');

            return redirect(route('productPromps.index'));
        }

        return view('admin.product_promps.show')->with('productPromp', $productPromp);
    }

    /**
     * Show the form for editing the specified ProductPromp.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $productPromp = $this->productPrompRepository->findWithoutFail($id);

        if (empty($productPromp)) {
            Flash::error('促销信息不存在');

            return redirect(route('productPromps.index'));
        }
        $product=$this->productRepository->getPrompProductWithSpecsByPromId($id);
        //$spec=$this->specProductPriceRepository->getPrompSpecsByPromId($id);

        return view('admin.product_promps.edit')
                ->with('productPromp', $productPromp)
                ->with('product',$product);
                //->with('spec',$spec);
    }

    /**
     * Update the specified ProductPromp in storage.
     *
     * @param  int              $id
     * @param UpdateProductPrompRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProductPrompRequest $request)
    {
        $input=$request->all();
        $productPromp = $this->productPrompRepository->findWithoutFail($id);

        if (empty($productPromp)) {
            Flash::error('促销信息不存在');
            return redirect(route('productPromps.index'));
        }

        if(!array_key_exists( 'product_spec',$input)){
            return redirect(route('productPromps.edit',$id))
                ->withErrors('请选择参加活动的商品')
                ->withInput($input);
        }

        $productPromp = $this->productPrompRepository->update($request->all(), $id);

        $product=$this->productRepository->resetPrompByPromId($id);
        //$spec=$this->specProductPriceRepository->resetPrompByPromId($id);

        if(array_key_exists( 'product_spec',$input) && !empty($input['product_spec']) ){
            $this->processPromp($input['product_spec'], $productPromp->id);
        }else{
            Flash::error('请选择参加活动的商品');
            return redirect(route('productPromps.edit', ['id' => $id]));
        }

        Flash::success('更新成功');

        return redirect(route('productPromps.index'));
    }

    /**
     * Remove the specified ProductPromp from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $productPromp = $this->productPrompRepository->findWithoutFail($id);

        if (empty($productPromp)) {
            Flash::error('促销信息不存在');

            return redirect(route('productPromps.index'));
        }

        $this->productPrompRepository->delete($id);

        $product=$this->productRepository->resetPrompByPromId($id);
        //$spec=$this->specProductPriceRepository->resetPrompByPromId($id);

        Flash::success('删除成功');

        return redirect(route('productPromps.index'));
    }

    private function processPromp($inputs, $promp_id)
    {
        $specIdArray =  $inputs;
        for ($i = count($specIdArray) - 1; $i >=0 ; $i--) {
            $spec_product=$specIdArray[$i];
            $spec_product_arr=explode('_',$spec_product);
            //if($spec_product_arr[1]=="0"){
                $this->productRepository->updateProductPrompType($spec_product_arr[0],$promp_id,3);
            // }else{
            //     $this->specProductPriceRepository->updateSpecPrompType($spec_product_arr[1],$promp_id,3);
            //     $this->productRepository->updateProductPrompType($spec_product_arr[0],$promp_id,3);
            // }
        }
    }
}
