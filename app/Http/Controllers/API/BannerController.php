<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\BannerRepository;

class BannerController extends Controller
{
    private $bannerRepository;

    public function __construct(BannerRepository $bannerRepo)
    {
        $this->bannerRepository = $bannerRepo;
    }

    /**
     * 小程序获取横幅
     *
     * @SWG\Get(path="/api/banners",
     *   tags={"小程序[前端显示]接口(https://{account}.shop.qijianshen.xyz)"},
     *   summary="小程序获取横幅",
     *   description="小程序获取横幅,不需要需要token信息",
     *   operationId="bannersUser",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="query",
     *     name="slug",
     *     type="string",
     *     description="横幅别名",
     *     required=true
     *     ),
     *   @SWG\Parameter(
     *     in="query",
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
    public function banners(Request $request)
    {

        $slug = $request->get('slug');

        $shop_id = $request->get('shop_id');
        
    	$banner = $this->bannerRepository->getBannerCached($slug,$shop_id);

    	return ['status_code' => 0, 'data' => $banner];
    }
}
