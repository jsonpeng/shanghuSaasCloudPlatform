<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\BrandRepository;
use Illuminate\Support\Facades\Config;

class BrandController extends Controller
{

	private $brandRepository;

    public function __construct(BrandRepository $brandRepo)
    {
        $this->brandRepository = $brandRepo;
    }

    public function index()
    {
    	$brands = $this->brandRepository->allCached();
    	return view(frontView('brand.index'), compact('brands'));
    }

    public function productList(Request $request, $brand_id)
    {
    	$products = $this->brandRepository->getProductsOfBrandCached($brand_id);
    	return view(frontView('brand.product_list'), compact('products'));
    }
}
