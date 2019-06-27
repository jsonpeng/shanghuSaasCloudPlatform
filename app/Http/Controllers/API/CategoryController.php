<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
    }


    /**
     * 小程序获取所有分类信息
     *
     * @SWG\Get(path="/api/cats_all",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序获取所有分类信息",
     *   description="小程序获取所有分类信息,不需要需要token信息",
     *   operationId="allCatsRootUser",
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
    public function allCatsRoot(Request $request){
        $categories=$this->categoryRepository->getRootCategoriesCached($request->input('shop_id'));
        return ['status_code' => 0, 'data' => $categories];
    }

    

}
