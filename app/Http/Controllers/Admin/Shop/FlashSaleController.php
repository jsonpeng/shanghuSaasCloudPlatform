<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Requests\CreateFlashSaleRequest;
use App\Http\Requests\UpdateFlashSaleRequest;
use App\Models\SpecProductPrice;
use App\Repositories\FlashSaleRepository;
use App\Repositories\ProductRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\Product;
use App\Models\FlashSale;
use Illuminate\Support\Facades\Input;
use App\Repositories\TeamSaleRepository;

class FlashSaleController extends AppBaseController
{
    /** @var  FlashSaleRepository */
    private $flashSaleRepository;
    private $productRepository;
    private $teamSaleRepository;
    public function __construct(FlashSaleRepository $flashSaleRepo,ProductRepository $productRepo,TeamSaleRepository $teamSaleRepo)
    {
        $this->flashSaleRepository = $flashSaleRepo;
        $this->productRepository=$productRepo;
        $this->teamSaleRepository=$teamSaleRepo;
    }

    /**
     * Display a listing of the FlashSale.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->flashSaleRepository->pushCriteria(new RequestCriteria($request));
        $flashSales =FlashSale::where('id','>','0');
        $input=$request->all();
        $tools=$this->varifyTools($input);
        //$created_desc_status=true;
        if(array_key_exists('name', $input)){
            $flashSales=$flashSales->where('name','like','%'.$input['name'].'%');
        }
        if( array_key_exists('price_sort', $input) ){
            $flashSales=$flashSales->orderBy('price',$input['price_sort'] == 0 ? 'asc' : 'desc');
            //$created_desc_status=false;
        }
        if(array_key_exists('start_time',$input) && !empty($input['start_time'])){
            $flashSales=$flashSales->where('time_begin','>=',$input['start_time']);
        }
        if(array_key_exists('end_time',$input) && !empty($input['end_time'])){
            $flashSales=$flashSales->where('time_end','<',$input['end_time']);
        }
        if(array_key_exists('page_list', $input) && !empty($input['page_list'])) {
            $page_list=$input['page_list'];
        }
      
        $flashSales=$this->accountInfo($flashSales);
        
        return view('admin.flash_sales.index')
            ->with('flashSales', $flashSales)
            ->with('tools',$tools)
            ->withInput(Input::all());
    }

    /**
     * Show the form for creating a new FlashSale.
     *
     * @return Response
     */
    public function create()
    {
        $product_spec=null;
        return view('admin.flash_sales.create')
                ->with('product_spec',$product_spec);
    }

    /**
     * Store a newly created FlashSale in storage.
     *
     * @param CreateFlashSaleRequest $request
     *
     * @return Response
     */
    public function store(CreateFlashSaleRequest $request)
    {
        $input = $request->all();
        if(array_key_exists('product_spec', $input) && !empty($input['product_spec']))
        {
            $input=$this->progressFlashSale($input, $input['product_spec']);

            // if(!$this->varifyProductNum($input)){
            //     return redirect(route('flashSales.create'))
            //         ->withErrors('参与数量不得大于商品库存')
            //         ->withInput($input);
            // }
        }

        if(!array_key_exists('product_spec', $input) || empty($input['product_spec'])){
              return redirect(route('flashSales.create'))
                    ->withErrors('请选择参与商品')
                    ->withInput($input);
        }
        
        $input = attachAccoutInput($input);

        $flashSale = $this->flashSaleRepository->create($input);
        $this->updateFlashSaleInfo($flashSale);
        Flash::success('保存成功');

        return redirect(route('flashSales.index'));
    }

    /**
     * Display the specified FlashSale.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $flashSale = $this->flashSaleRepository->findWithoutFail($id);

        if (empty($flashSale)) {
            Flash::error('信息不存在');

            return redirect(route('flashSales.index'));
        }

        return view('admin.flash_sales.show')->with('flashSale', $flashSale);
    }

    /**
     * Show the form for editing the specified FlashSale.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $flashSale = $this->flashSaleRepository->findWithoutFail($id);
        $product_spec=$flashSale->product_id.'_'.(is_null($flashSale->spec_id)?'0':$flashSale->spec_id);
        if (empty($flashSale)) {
            Flash::error('信息不存在');

            return redirect(route('flashSales.index'));
        }

        $product_id=$flashSale->product_id;
        //$spec_id=$flashSale->spec_id;
        //if($spec_id==0) {
            $product =$this->productRepository->findWithoutFail($product_id);
        // }else{
        //     $product=$this->specProductPriceRepository->findWithoutFail($spec_id);
        // }

        return view('admin.flash_sales.edit')
                ->with('flashSale', $flashSale)
                ->with('product_spec',$product_spec)
                ->with('product',$product);
                //->with('spec_id',$spec_id);
    }

    /**
     * Update the specified FlashSale in storage.
     *
     * @param  int              $id
     * @param UpdateFlashSaleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFlashSaleRequest $request)
    {
        $flashSale = $this->flashSaleRepository->findWithoutFail($id);

        if (empty($flashSale)) {
            Flash::error('信息不存在');

            return redirect(route('flashSales.index'));
        }
        $input=$request->all();

        if(array_key_exists('product_spec',$input) && !empty($input['product_spec'])) {
            $input= $this->progressFlashSale($input,$input['product_spec']);
            // if( !$this->varifyProductNum($input) ){
            //     return redirect(route('flashSales.edit',$id))
            //         ->withErrors('参与数量不得大于商品库存')
            //         ->withInput($input);
            // }
        }

       if(!array_key_exists('product_spec', $input) || empty($input['product_spec'])){
              return redirect(route('flashSales.edit',$id))
                    ->withErrors('请选择参与商品')
                    ->withInput($input);
        }

        $flashSale = $this->flashSaleRepository->update($input, $id);
        $this->updateFlashSaleInfo($flashSale);
        Flash::success('更新成功');

        return redirect(route('flashSales.index'));
    }

    /**
     * Remove the specified FlashSale from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $flashSale = $this->flashSaleRepository->findWithoutFail($id);

        if (empty($flashSale)) {
            Flash::error('信息不存在');

            return redirect(route('flashSales.index'));
        }

        $this->flashSaleRepository->delete($id);
        //if($flashSale->spec_id==0) {
            $this->productRepository->resetPrompByPromId($id);
        // }else{
        //     $this->specProductPriceRepository->resetPrompByPromId($id);
        //     $this->productRepository->resetPrompByPromId($id);
        // }
        Flash::success('删除成功');

        return redirect(route('flashSales.index'));
    }

    private function progressFlashSale($inputs, $product_spec)
    {
        $product_spec_arr=explode('_', $product_spec);

        if($product_spec_arr[1] == "0") {
            //没有规格
            $inputs['product_id'] = $product_spec_arr[0];
           // $inputs['spec_id'] = 0;
            $product=$this->productRepository->findWithoutFail($inputs['product_id']);
            if(!empty($product)){
                $inputs['origin_price']=$product->price;
                $inputs['image']=$product->image;
            }
        }
        return $inputs;
    }




    private function varifyProductNum($inputs){
        //if($inputs['spec_id'] == 0) {
            //无规格
            $product=$this->productRepository->findWithoutFail($inputs['product_id']);
            //inventory -1表示不限量供应
            if (empty($product)) {
                return false;
            }
            if($product->inventory != -1){
                $product_inventory = $product->inventory;
                if($inputs['product_num'] > $product_inventory){
                    return false;
                }else{
                    return true;
                }
            }else{
                return true;
            }
        // }else{
        //     $product=$this->specProductPriceRepository->findWithoutFail($inputs['spec_id']);
        //     if (empty($product)) {
        //         return false;
        //     }
        //     if($product->inventory != -1){
        //         $product_inventory = $product->inventory;
        //         if($inputs['product_num'] > $product_inventory){
        //             return false;
        //         }else{
        //             return true;
        //         }
        //     }else{
        //         return true;
        //     }
        // }
    }

    private function updateFlashSaleInfo($flashSale){
            //等于0只有商品没有规格信息
            //if($flashSale->spec_id==0){
                $this->productRepository->updateProductPrompType($flashSale->product_id,$flashSale->id,1);
               // $this->teamSaleRepository->deleteReplaceProductByProductIdOrSpecId($flashSale->product_id);
            // }else{
            //     $this->specProductPriceRepository->updateSpecPrompType($flashSale->spec_id,$flashSale->id,1);
            //     $this->productRepository->updateProductPrompType($flashSale->product_id,$flashSale->id,1);
            //     $this->specProductPriceRepository->resetPrivateByProductIdAndSpecIdAndPrompType($flashSale->product_id,$flashSale->spec_id,1);
            //    // $this->teamSaleRepository->deleteReplaceProductByProductIdOrSpecId($flashSale->product_id,$flashSale->spec_id);
            // }
    }

}
