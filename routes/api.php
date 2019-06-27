<?php

$api = app('Dingo\Api\Routing\Router');



$api->version('v1', function ($api) {

	//小程序管理
	$api->group(['prefix' => 'manage'], function ($api) {

		### 管理员登录
		$api->get('login', 'App\Http\Controllers\API\Admin\CommonController@loginMiniManage');

		
		
		$api->group(['middleware' => 'api.auth'], function ($api) {
			/**
			 * 管理员才能做的操作 业务员只能看
			 */
			$api->group(['middleware' => 'manage'], function ($api) {
				### 门店管理
				$api->resource('shop','App\Http\Controllers\API\Admin\StoreShopController');

				
				/**
				 * 选择店铺后才可以做的操作
				 */
				### 信息统计
				$api->get('statistics','App\Http\Controllers\API\CommonController@statistics');
				
				### 会员管理
				$api->resource('user','App\Http\Controllers\API\Admin\UserController');
				
				### 服务管理
				$api->resource('service','App\Http\Controllers\API\Admin\ServiceController');

				### 产品分类管理
				$api->resource('category','App\Http\Controllers\API\Admin\CategoryController');

				### 产品管理
				$api->resource('product','App\Http\Controllers\API\Admin\ProductController');

				### 订单管理
				$api->resource('order','App\Http\Controllers\API\Admin\OrderController');

				### 会员卡管理
				$api->resource('userlevel','App\Http\Controllers\API\Admin\UserLevelController');

				### 预约管理
				$api->resource('subscribe','App\Http\Controllers\API\Admin\SubscribeController');

				### 技师管理
				$api->resource('technician','App\Http\Controllers\API\Admin\TechnicianController');
				
				### 图片上传
				$api->post('upload_images','App\Http\Controllers\API\CommonController@uploadImage');

				###
			});

		});
		
	});

	$api->group(['domain'=>'{account}.'.domain('shop'),'middleware' => 'api'], function($api){

		//小程序
		$api->group(['prefix' => 'mini_program'], function ($api) {
			//用户登录
			$api->get('login', 'App\Http\Controllers\API\UserController@loginMiniprogram');

			$api->get('setRelationship', 'App\Http\Controllers\API\UserController@SetRelationship');

			/**
			 * 小程序推广二维码
			 */
			$api->group(['middleware' => 'api.auth'], function ($api) {
				$api->get('distribution_code', 'App\Http\Controllers\API\UserController@distributionCode');
			});
		});

		### 使用服务成功监听
		$api->get('services_success_notify','App\Http\Controllers\Admin\Shop\ManagerController@servicesSuccessNotify');

		### 导航信息
		$api->get('banners', 'App\Http\Controllers\API\BannerController@banners');
		
		### 全部产品
		$api->get('products', 'App\Http\Controllers\API\ProductController@products');

		### 全部分类
		$api->get('cats_all','App\Http\Controllers\API\CategoryController@allCatsRoot');

		### 分类下的产品
		$api->get('products_of_cat', 'App\Http\Controllers\API\ProductController@productsOfCat');

		### 产品详情
		$api->get('product', 'App\Http\Controllers\API\ProductController@product');

		### 话题分类列表
		$api->get('post_cat_all','App\Http\Controllers\API\PostController@getCatsFound');

		### 话题列表
		$api->get('post_found','App\Http\Controllers\API\PostController@getPostsFound');

		### 公告消息列表
	    $api->get('getNotices','App\Http\Controllers\API\CommonController@getNotices');

	    ### 技师列表
	    $api->get('get_technicicans','App\Http\Controllers\API\CommonController@getTechnicians');

	    ### 根据技师id获取服务
        $api->get('get_services_by_technicican','App\Http\Controllers\API\CommonController@getServiceByTechnicicanIdApi');

	    ### 根据店铺id获取对应的服务
	    $api->get('get_services_by_shop','App\Http\Controllers\API\CommonController@getServiceByShopIdApi');

		### 根据服务id获取对应的技师
	   	$api->get('get_technicicans_by_service','App\Http\Controllers\API\CommonController@getTechniciansByServicesIdApi');

	   	
		#新品推荐
		$api->get('new_products', 'App\Http\Controllers\API\ProductController@newProducts');

		#拼团产品
		$api->get('team_sales', 'App\Http\Controllers\API\TeamSaleController@teamSaleProducts');

		#秒杀商品
		$api->get('flash_sales', 'App\Http\Controllers\API\ProductController@flashSaleProducts');

		##热销商品
		$api->get('sales_count_products','App\Http\Controllers\API\ProductController@salesCountProducts');

		##正在进行的活动
		$api->get('product_proms','App\Http\Controllers\API\ProductController@productPromps');
		
		##活动详情
		$api->get('product_proms/{id}','App\Http\Controllers\API\ProductController@productPrompsDetail');

		#猜你喜欢的产品
		$api->get('fav_product/{id}', 'App\Http\Controllers\API\ProductController@favProduct');


		##系统指定的功能
		$api->get('getSystemSettingFunc','App\Http\Controllers\API\CommonController@getSystemSettingFunc');


		### 搜索商品
		$api->get('product_search','App\Http\Controllers\API\ProductController@apiProductSearch');
		
		##其他信息
	    $api->get('timer', 'App\Http\Controllers\API\ProductController@giveFlashSaleTimer');

		//Route::any('notify_wechcat_pay', 'App\Http\Controllers\API\OrderController@payWechatNotify');
	    
	    ##当前主题
	    $api->get('themeNow','App\Http\Controllers\API\CommonController@themeNow');

	    ##所有功能配置项
	    //$api->get('getAllFunc','App\Http\Controllers\API\CommonController@getAllFunc');
	   
		$api->group(['middleware' => 'api.auth'], function ($api) {
			### 获取对应用户获得的服务的消耗二维码
			$api->get('get_service_user_qrcode','App\Http\Controllers\API\UserController@getServiceUserQrCode');

			### 充值金额列表
			$api->get('topup_list','App\Http\Controllers\API\CommonController@topupList');

			### 充值金额返回对应充值福利
			$api->get('topup_input','App\Http\Controllers\API\CommonController@topupInputPriceReturn');

			### 用户发起优惠买单
			$api->get('publish_discount_order','App\Http\Controllers\API\CommonController@publishDiscountOrder');

			### 发起充值
			$api->get('topup_publish','App\Http\Controllers\API\CommonController@publishTopup');

			### 用户发布文章及产品操作
			$api->get('publish_post','App\Http\Controllers\Admin\Shop\PostController@userPublishPost');

			### 用户删除发布的文章
			$api->get('delete_post','App\Http\Controllers\Admin\Shop\PostController@deletePublishPost');

			### 用户发布的文章及产品列表
			$api->get('user_posts','App\Http\Controllers\API\PostController@userPosts');

			### 图片上传
			$api->post('upload_images','App\Http\Controllers\API\CommonController@uploadImage');
			
		    ### 功能开关列表
    		$api->get('getFuncList','App\Http\Controllers\API\CommonController@getFuncList');

			### 全部店铺 带有距离
			$api->get('shops_all','App\Http\Controllers\API\CommonController@allShops');

			### 用户所有的消息/所有未读的消息
			$api->get('auth_notices','App\Http\Controllers\API\UserController@authNotices');
	   		
	   		### 批量设置消息为已读
	   		$api->get('read_notices','App\Http\Controllers\API\UserController@readAllNotices');

	   		### 删除单个通知消息
	   		$api->get('delete_notice','App\Http\Controllers\API\UserController@deleteNotice');

	   		### 新建预约
	   		$api->get('new_subscribe','App\Http\Controllers\API\CommonController@newSubscribe');

	   		### 用户的服务
	   		$api->get('auth_services','App\Http\Controllers\API\UserController@authServices');
	   		
	   		### 用户的预约
	   		$api->get('auth_subscribe','App\Http\Controllers\API\UserController@authSubscribe');

	   		### 用户手动取消预约
	   		$api->get('auth_cancle_subscribe','App\Http\Controllers\API\UserController@cancleSubscribe');

	   		### 小程序日历时间
    		$api->get('sub_timer','App\Http\Controllers\API\CommonController@subTimerSelected');

    		/**
    		 * 个人中心积分商城
    		 */
    		### 积分商城产品列表
    		$api->get('credits_shop_list','App\Http\Controllers\API\CommonController@creditsShopList');

    		### 积分商城产品详情
    		$api->get('credits_shop_detail','App\Http\Controllers\API\CommonController@creditsShopDetail');

    		### 发起积分商品兑换
    		$api->post('publish_credits_ex','App\Http\Controllers\API\CommonController@publishExchangeCreditsShop');

    		### 我的积分兑换
    		$api->get('auth_credits_shops','App\Http\Controllers\API\UserController@creditsShopLog');
			
			# 退出登录
			$api->post('logout', 'App\Http\Controllers\API\UserController@postLogout');

			### 获取用户信息
			$api->get('me', 'App\Http\Controllers\API\UserController@userInfo');

			### 用户积分记录
			$api->get('credits', 'App\Http\Controllers\API\UserController@credits');

			### 用户余额记录
			$api->get('funds', 'App\Http\Controllers\API\UserController@funds');

			#用户分佣记录
			$api->get('bouns', 'App\Http\Controllers\API\UserController@bouns');

			#推荐人列表
			$api->get('parterners', 'App\Http\Controllers\API\UserController@parterners');

			### 优惠券列表
			$api->get('coupons', 'App\Http\Controllers\API\CouponController@coupons');

			### 当前购物车能使用的优惠券
			$api->get('coupons_canuse', 'App\Http\Controllers\API\CouponController@couponsCanUse');

			#使用优惠券能得到的优惠
			$api->get('coupons_use/{coupon_id}', 'App\Http\Controllers\API\CouponController@couponsUse');


			// ##获取省列表
			// $api->get('provinces', 'App\Http\Controllers\API\AddressController@provinces');

			// ##根据地区id获取子列表
			// $api->get('cities/{cities_id}', 'App\Http\Controllers\API\AddressController@cities');

		
			/**
			 * 订单信息
			 */
			### 订单列表 1全部 2待付款 3待发货 4待确认 5退换货
			$api->get('orders','App\Http\Controllers\API\OrderController@orders');

			### 创建订单
			$api->post('order/create','App\Http\Controllers\API\OrderController@create');

			#订单详情
			$api->get('order/{id}','App\Http\Controllers\API\OrderController@detail');

			### 取消订单
			$api->get('order/cancel','App\Http\Controllers\API\OrderController@cancel');
			
			### 微信支付
			$api->get('pay_weixin','App\Http\Controllers\API\PayController@miniWechatPay');

			/**
			 * 购物车与结算
			 */
			#优惠金额计算
			$api->get('cart/preference','App\Http\Controllers\API\CartController@cartPreference');

			#运费计算
			// $api->get('cart/freight','App\Http\Controllers\API\CartController@freight');
			
		});
	});
});