<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\ProductPrompRepository;
use App\Repositories\ProductRepository;
//use App\Repositories\SpecProductPriceRepository;

use Illuminate\Support\Facades\Config;
use App\Models\Product;

class ProductPrompController extends Controller
{

	private $productPrompRepository;
    private $productRepository;
    //private $specProductPriceRepository;
    public function __construct(
    	ProductPrompRepository $productPrompRepo,
    	ProductRepository $productRepo
    	//SpecProductPriceRepository $specProductPriceRepo)
    {
        $this->productPrompRepository = $productPrompRepo;
        $this->productRepository = $productRepo;
        //$this->specProductPriceRepository = $specProductPriceRepo;
    }

    public function index()
    {
    	//当前正在进行的活动
    	$promps = $this->productPrompRepository->curPromps();
    	return view(frontView('product_promp.index'), compact('promps'));
    }

    public function list(Request $request, $id)
    {
    	$products = $this->productRepository->productsOfPromp($id, 0, 200);
    	return view(frontView('product_promp.list'), compact('products'));
    }
}
