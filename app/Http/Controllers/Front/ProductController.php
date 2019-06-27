<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Category;
use App\Models\Point;
use App\Models\Theme;
use App\Models\SpecProductPrice;
use App\Models\TeamFound;
use App\Models\TeamSale;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use DB;

use App\Repositories\ProductRepository;
//use App\Repositories\SpecProductPriceRepository;
use App\Repositories\ProductAttrValueRepository;
use App\Repositories\TeamSaleRepository;

use Config;
use EasyWeChat\Factory;

class ProductController extends Controller
{

	private $productRepository;
    //private $specProductPriceRepository;
    private $productAttrValueRepository;
    private $teamSaleRepository;

    public function __construct(
        ProductRepository $productRepo,
        //SpecProductPriceRepository $specProductPriceRepo,
        TeamSaleRepository $teamSaleRepo,
        ProductAttrValueRepository $productAttrValueRepo)
    {
        $this->productRepository = $productRepo;
        //$this->specProductPriceRepository = $specProductPriceRepo;
        $this->productAttrValueRepository = $productAttrValueRepo;
        $this->teamSaleRepository = $teamSaleRepo;
    }


    //产品详情
    public function index(Request $request, $id=0){

    	$product = $this->productRepository->product($id);
        //商品不存在
        if (empty($product) || $product->shelf == 0) {
            return redirect()->back();
        }
        //添加用户访问商品记录
        //
        //商品展示图片
        $productImages = $product->images;
        //商品规格信息
        //$filter_spec = $this->specProductPriceRepository->get_spec($product->id);
        //计算优惠价格
        $spec_goods_price = $this->specProductPriceRepository->productSpecWithSalePrice($id);
        // $spec_goods_prices = SpecProductPrice::where('product_id', $id)->get();
        // foreach ($spec_goods_prices as $item) {
        //     $item['realPrice'] = $this->specProductPriceRepository->getSalesPrice($item);
        // }
        // $spec_goods_price = json_encode($spec_goods_prices);
        //属性信息
        $attrs = $this->productAttrValueRepository->getAllAttrOfProductCached($product->id);
        //推荐产品
        $relatedProducts = $this->productRepository->relatedProducts($product->id);
        //促销信息
        $promp = $this->productRepository->getPromp($product);
        //服务保障
        $words = $product->words;
        //如果是拼团活动，则显示已拼但是未拼满的团
        $teamFounders = collect([]);
        $join_team = 0;
        if ($request->has('join_team')) {
            $join_team = $request->input('join_team');
        }
        $start_or_Join = 0;
        if ($request->has('start_or_Join')) {
            $start_or_Join = $request->input('start_or_Join');
        }
        if ($product->prom_type == 5) {
            $teamFounders = $this->teamSaleRepository->teamFounders($product->id);
        }

        //最终售价，将优惠活动计算在内
        $product['realPrice'] = $this->productRepository->getSalesPrice($product);

        $app = null;
        if(Config::get('web.app_env') == 'product'){
            $app = Factory::officialAccount(Config::get('wechat.official_account.default'));
        }

        return view(frontView('product.index'))
                ->with('app', $app)
                ->with('product', $product)
                ->with('join_team', $join_team)
                ->with('start_or_Join', $start_or_Join)
                ->with('attrs', $attrs)
                ->with('promp', $promp)
                ->with('words', $words)
                //->with('filter_spec', $filter_spec)
                ->with('relatedProducts', $relatedProducts)
                ->with('spec_goods_price', $spec_goods_price)
                ->with('productImages', $productImages)
                ->with('teamFounders', $teamFounders);
    }


    /**
     * 商品列表
     * @param  Request $request [description]
     * @param  integer $type    [商品类型 0全部 1新品 2销量 3国家馆]
     * @return [type]           [description]
     */
    public function productOfType(Request $request, $type)
    {
        $country_id = null;
        $products = collect([]);
        switch ($type) {
            case 0:
                $products = $this->productRepository->products();
                break;

            case 1:
                $products = $this->productRepository->newProducts();
                break;

            case 2:
                $products = $this->productRepository->salesCountProducts();
                break;

            case 3:
                //国家馆
                if (!$request->has('country_id') || empty($request->input('country_id'))) {
                    return redirect()->back();
                }
                $products = $this->productRepository->countryProducts($request->input('country_id'));
                $country_id = $request->input('country_id');
                break;
        }
        return view(frontView('product.list'))
                ->with('products', $products)
                ->with('type', $type)
                ->with('country_id', $country_id);
    }

    public function ajaxProductOfType(Request $request, $type)
    {
        $skip = 0;
        $take = 18;

        $inputs = $request->all();
        if (array_key_exists('skip', $inputs)) {
            $skip = intval($inputs['skip']);
        }
        if (array_key_exists('take', $inputs)) {
            $take = intval($inputs['take']);
        }

        $products = collect([]);
        switch ($type) {
            case 0:
                $products = $this->productRepository->products($skip, $take);
                break;

            case 1:
                $products = $this->productRepository->newProducts($skip, $take);
                break;

            case 2:
                $products = $this->productRepository->salesCountProducts($skip, $take);
                break;

            case 3:
                //国家馆
                if ($request->has('country_id') && !empty($request->input('country_id'))) {
                    $products = $this->productRepository->countryProducts($request->input('country_id'), $skip, $take);
                }
                break;
        }
        return ['code' => 0, 'data' => $products];
    }

    /**
     * 产品搜索
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function ajaxProductSearch(Request $request)
    {
        $products = $this->productRepository->searchProduct($request->input('query'));
        return ['code' => 0, 'data' => $products];
    }

}
