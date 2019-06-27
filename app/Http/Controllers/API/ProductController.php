<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\ProductPrompRepository;
use App\Repositories\ProductRepository;
use App\Repositories\FlashSaleRepository;
use App\Repositories\TeamSaleRepository;
use Carbon\Carbon;

class ProductController extends Controller
{
    
	private $productRepository;
    private $flashSaleRepository;
    private $productPrompRepository;
    private $teamSaleRepository;
    public function __construct(
        ProductPrompRepository $productPrompRepo,
        ProductRepository $productRepo,
        FlashSaleRepository $flashSaleRepo,
        TeamSaleRepository $teamSaleRepo)
    {
        $this->productPrompRepository = $productPrompRepo;
        $this->productRepository = $productRepo;
        $this->teamSaleRepository = $teamSaleRepo;
        $this->flashSaleRepository = $flashSaleRepo;
    }

    /**
     * 新品
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function newProducts(Request $request)
    {
    	$skip = 0;
    	$take = 18;
    	if ($request->has('skip')) {
    		$skip = $request->input('skip');
    	}
    	if ($request->has('take')) {
    		$take = $request->input('take');
    	}
        $products = $this->productRepository->newProducts($skip, $take);
    	return ['status_code' => 0, 'data' => $products];
    }

    /**
     * 秒杀商品
     * @return [type] [description]
     */
    public function flashSaleProducts(Request $request)
    {
        $skip = 0;
        $take = 18;
        $time_begin = null;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        if ($request->has('time_begin')) {
            $time_begin = $request->input('time_begin');
        }
        $flashSaleProduct = $this->flashSaleRepository->salesBetweenTime($skip, $take, $time_begin);
        return ['status_code' => 0, 'data' => $flashSaleProduct];
    }


    /**
     * 热销商品
     * @return [type] [description]
     */
    public function salesCountProducts(Request $request)
    {
        $skip = 0;
        $take = 18;
        $time_begin = null;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
       
        $salesCountProducts = $this->productRepository->salesCountProducts($skip, $take);

        return ['status_code' => 0, 'data' => $salesCountProducts];
    }

    /**
     * 国家馆商品
     */
    public function countryProducts(Request $request,$country_id){
        $skip = 0;
        $take = 18;
        $time_begin = null;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
       
        $countryProducts = $this->productRepository->countryProducts($country_id,$skip, $take);

        return ['status_code' => 0, 'data' => $countryProducts];
    }


    /**
     * 小程序获取某分类的商品
     *
     * @SWG\Get(path="/api/products_of_cat",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序获取某分类的商品",
     *   description="小程序获取某分类的商品,不需要需要token信息",
     *   operationId="productsOfCatUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     ),
     *   @SWG\Parameter(
     *     in="formData",
     *     name="shop_id",
     *     type="string",
     *     description="店铺id",
     *     required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回banner图链接列表",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期",
     *     )
     * )
     */
    public function productsOfCat(Request $request)
    {
        $skip = 0;
        $take = 18;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        $cat_id = $request->input('cat_id');
        $shop_id = $request->input('shop_id');
        $products = $this->productRepository->getProductsCached($shop_id , $cat_id , $skip , $take);
        return ['status_code' => 0, 'data' => $products];
    }

    /**
     * 获取某分类下的产品列表(包含子分类)
     * @param  Request $request [description]
     * @param  [type]  $cat_id  [description]
     * @return [type]           [description]
     */
    public function productsOfCatWithChildren(Request $request, $cat_id)
    {
        $skip = 0;
        $take = 18;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        $products = $this->productRepository->getProductsOfCatWithChildrenCatsCached($cat_id, $skip, $take);
        return ['status_code' => 0, 'data' => $products];
    }



    /**
     * 小程序获取全部商品
     *
     * @SWG\Get(path="/api/products",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序获取全部商品",
     *   description="小程序获取全部商品,不需要需要token信息",
     *   operationId="productsAllUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     ),
     *   @SWG\Parameter(
     *     in="formData",
     *     name="shop_id",
     *     type="string",
     *     description="店铺id",
     *     required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回banner图链接列表",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期",
     *     )
     * )
     */
    public function products(Request $request)
    {
        $skip = 0;
        $take = 18;

        $account = $request->account;
        $shop_id = $request->input('shop_id');

        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        
        $products = $this->productRepository->products($shop_id , $skip , $take);
        return ['status_code' => 0, 'data' => $products];
    }

    /**
     * 小程序产品的具体信息
     *
     * @SWG\Get(path="/api/product",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序产品的具体信息",
     *   description="小程序产品的具体信息,不需要需要token信息",
     *   operationId="productContentUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="formData",
     *     name="token",
     *     type="string",
     *     description="token头信息",
     *     ),
     *   @SWG\Parameter(
     *     in="formData",
     *     name="shop_id",
     *     type="string",
     *     description="店铺id",
     *     required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="status_code=0请求成功,status_code=1参数错误,data返回banner图链接列表",
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="服务器出错",
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="token字段没带上或者token头已过期",
     *     )
     * )
     */
    public function product(Request $request)
    {
        $id = $request->input('id');
        $product = $this->productRepository->product($id);
        if (empty($product)) {
            return ['status_code' => 1, 'data' => '产品信息不存在'];
        } else {
            //商品展示图片
            $productImages = $product->images;
            //促销信息
            $promp = $this->productRepository->getPromp($product);
            //如果是拼团活动，则显示已拼但是未拼满的团
            $teamFounders = collect([]);
            if ($product->prom_type == 5) {
                $teamFounders = $this->teamSaleRepository->teamFounders($product->id);
            }
            //最终售价，将优惠活动计算在内
            $product['realPrice'] = $this->productRepository->getSalesPrice($product);

            //商品服务
            $services = $product->services()->get();

            //商品适用店铺
            $shops = $product->shop()->first();

            return ['status_code' => 0, 'data' => [
                'images' => $productImages,
                'promp' => $promp,
                'teamFounders' => $teamFounders,
                'product' => $product,
                'services' => $services,
                'shops'    =>  $shops
            ]];
        }
    }

    /**
     * 猜你喜欢的商品
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function favProduct(Request $request, $id)
    {
        $relatedProducts = $this->productRepository->relatedProducts($id);
        return ['status_code' => 0, 'data' => $relatedProducts];
    }

    /**
     * 秒杀倒计时给前端需要倒计时的时间
     * @param
     * @return [type]           [description]
     */
    public function giveFlashSaleTimer(){
        return ['status_code' => 0, 'data' =>processTime( Carbon::now() )->copy()->addHours(2)];
    }


    /**
     * 获取收藏状态
     * @param Request $request    [description]
     * @param [type]  $product_id [description]
     */
    public function getCollectStatus(Request $request, $product_id)
    {
        $user = auth()->user();
        $status=$this->productRepository->getCollectionStatusApi($user,$product_id);
        return ['status_code'=>0,'data'=>$status];
    }


    /**
     * 收藏动作
     * @param Request $request    [description]
     * @param [type]  $product_id,$status [description]
     */
    public function actionCollect(Request $request, $product_id,$status)
    {
        $user = auth()->user();
       if($status===false || $status=='false'){
           $user->collections()->detach($product_id);
           return ['status_code'=>0,'data'=>'取消收藏成功'];
       }elseif ($status===true || $status=='true'){
           $user->collections()->attach($product_id,['created_at'=>Carbon::now()]);
           return ['status_code'=>0,'data'=>'收藏成功'];
       }else{
           return ['status_code'=>1,'data'=>'未知错误'];
       }

    }

    /**
     * 用户收藏列表
     * @param Request $request    [description]
     * @param [type]   [description]
     */
    public function listCollect(Request $request)
    {
        $user = auth()->user();
        $collections=$user->collections();
        $skip = 0;
        $take = 18;
        $all_page=1;
        if ($request->has('skip')) {
            $skip = $request->input('skip');
        }
        if ($request->has('take')) {
            $take = $request->input('take');
        }
        $all_page= ceil($collections->count() / $take);
        $productList = $collections->skip($skip)->take($take)->get();
        return ['status_code' => 0, 'data' => $productList,'all_page'=>$all_page];  
    }

    /**
     * 品牌街
     */
    public function brandsList(Request $request){
        $brands = $this->brandRepository->allCached();
        return  ['status_code' => 0, 'data' => $brands]; 
    }

    /**
     * 通过品牌id获取对应的商品
     */
    public function productListByBrandId(Request $request, $brand_id){
        $products = $this->brandRepository->getProductsOfBrandCached($brand_id);
        return  ['status_code' => 0, 'data' => $products]; 
    }

    //listCollect

    /**
     * 添加收藏
     * @param Request $request    [description]
     * @param [type]  $product_id [description]
     */
    public function addCollect(Request $request, $product_id)
    {
        $user = auth()->user();
    }

    /**
     * 取消收藏
     * @param  Request $request    [description]
     * @param  [type]  $product_id [description]
     * @return [type]              [description]
     */
    public function cancelCollect(Request $request, $product_id)
    {
        $user = auth()->user();
    }

    /**
     * 产品搜索
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function apiProductSearch(Request $request)
    {
        $products = $this->productRepository->searchProduct($request->input('query'),$request->account);
        return ['status_code' => 0, 'data' => $products];
    }

     //当前正在进行的活动
    public function productPromps()
    {
       
        $promps = $this->productPrompRepository->curPromps();
        return ['status_code' => 0, 'data' => $promps];
    }

    //活动详情
    public function productPrompsDetail(Request $request, $id)
    {
        $products = $this->productRepository->productsOfPromp($id, 0, 200);
        return ['status_code' => 0, 'data' => $products];
    }


}
