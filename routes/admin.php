<?php
use Illuminate\Http\Request;

//自动生成api文档
Route::group(['prefix' => 'swagger'], function () {
    Route::get('json', 'SwaggerController@getJSON');
  
});

//刷新缓存
Route::post('/clearCache','AppBaseController@clearCache');

//小程序通知消息
Route::post('/mini_event/{appid}','Admin\Shop\MinichatBindController@miniEvent');

Route::any('/mini_notify','Admin\Shop\MinichatBindController@miniNotify');


//测试使用服务状态
Route::get('/varify','Admin\Shop\ManagerController@varify');
//确认服务消耗
Route::post('enter_service_consumption','Admin\Shop\ManagerController@enterServiceConsumption');
//生成套餐支付二维码
Route::get('create_package_qrcode','Admin\Shop\PayController@createPackageQrCode');
//自动支付套餐测试
Route::get('pay_package','Admin\Shop\PayController@payPackageTest')->name('pay.package');
//支付套餐状态监听
Route::get('pay_package_callback/{id}','Admin\Shop\PayController@payPackageCallback')->name('pay.callback');

//访问中转
Route::get('/zcjy', function(){
	return checkLoginPath();
});


//测试
Route::get('/test',function(){
	 dd(app('commonRepo')->topupGiftsRepo()->minPriceReturn('5rzsgaj9',10));
	//return getDistance(108.54,42.33,108.32,40.22);
	//return sendGroupNotice(1);
	//return sendNotice(1,'测试哈哈测试哈哈测试哈哈测试哈哈测试哈哈',true,'操作消息');
	//readedNotice(1);
});

//商户首页
Route::group(['domain'=>'{account}.'.domain('shop'),'namespace' => 'Front\shop'],function(){

	Route::get('/index','IndexController@index');

});

//代理商首页
Route::group(['domain'=>'{account}.'.domain('proxy'),'namespace' => 'Front\proxy'],function(){

	Route::get('/index','IndexController@index');
	//对应商户注册链接
	Route::get('/register','RegisterController@showRegisterForm')->name('register');
    //注册逻辑
    Route::post('/register','RegisterController@register');
});

//在页面中的URL尽量试用ACTION来避免前缀的干扰
Route::group(['prefix' => 'zcjy', 'namespace' => 'Admin\Auth'], function () {
	//登录
	Route::get('login', 'LoginController@showLoginForm');
	//登录逻辑
	Route::post('login', 'LoginController@login');
	//退出
	Route::get('logout', 'LoginController@logout');


	//重置密码, 采用注册手机号重置
	Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::post('password/reset', 'ResetPasswordController@reset');
	Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');

});

//地图选择 距离计算
Route::get('settings/map','Admin\Common\SettingController@map');

Route::group(['middleware' => ['auth.admin:admin'], 'prefix' => 'zcjy', 'namespace' => 'Admin'], function () {

	/**
	 * 通用
	 */
	Route::group(['namespace' => 'Common'], function () {
		/**
		 * 商城设置
		 */
		//地图选择
		Route::get('settings/map','SettingController@map');
		//系统功能
		Route::get('settings/system', 'SettingController@system')->name('settings.system');
		//系统设置
		Route::get('settings/setting', 'SettingController@setting')->name('settings.setting');
		//系统设置请求
		Route::post('settings/setting', 'SettingController@update')->name('settings.setting.update');
		//主题设置
		Route::get('settings/themeSetting', 'SettingController@themeSetting')->name('settings.themeSetting');
		//对应的主题
		Route::get('settings/themeSetting/{theme}', 'SettingController@themeSettingActive')->name('settings.themeSettingActive');
		//主题颜色设置
		Route::post('/set_theme_color', 'SettingController@postThemeSetting');
		//站内信
		Route::resource('message','NoticesController');

	});

	/**
	 * 总部
	 */
	Route::group(['middleware' => 'role.header', 'namespace' => 'Headquarter'], function () {
		//收费套餐条目
	    Route::get('word_packages','ChargePackageController@wordsList')->name('wordlist.index');
	    Route::get('word_packages/add','ChargePackageController@wordsListAdd')->name('wordlist.create');
	    Route::post('word_packages/add','ChargePackageController@wordsListStore')->name('wordlist.store');
	    Route::post('word_packages/delete/{id}','ChargePackageController@wordsListDestroy')->name('wordlist.destroy');
	    Route::post('word_packages/{id}','ChargePackageController@wordsListUpdate');
		//收费套餐
		Route::resource('chargePackages', 'ChargePackageController');
		//套餐记录
		Route::resource('packageLogs', 'PackageLogController');
		//代理商/管理员管理
    	Route::resource('managers','ManagerController');
	});

	/**
	 * 代理商
	 */
	Route::group(['middleware' => 'role.proxy' , 'namespace' => 'Proxy'] ,function () {
		//商户管理
		Route::resource('shopManagers','ManagerController');
	});
	/**
	 * 商户
	 */
	Route::group(['middleware' => 'role.shop', 'namespace' => 'Shop'], function () {

		//绑定小程序
		Route::get('bind_mini_chat','MinichatBindController@bind')->name('minichat.bind');
		//授权回调
		Route::get('mini_notify','MinichatBindController@mini_notify');
		//购买会员
		Route::get('package/buy','PayController@index')->name('package.buy');
		//购买会员
		Route::get('package/{id}','PayController@detail')->name('package.detail');
		//店铺选择后 存储对应店铺的id到session
		Route::get('selectShopRedirect/{shop_id}','StoreShopController@selectShopRedirect');

		//店铺管理
		Route::resource('storeShops', 'StoreShopController');
		//充值服务
		Route::resource('topupGifts', 'TopupGiftsController');
		//充值记录
		Route::resource('topupLogs', 'TopupLogController');
		//到店优惠买单记录
		Route::resource('discountOrders', 'DiscountOrderController');


		//分店铺管理员管理
		Route::resource('shopBranchManagers','ManagerController');
		
		/**
		 * 商品相关
		 */
		//积分商城
		Route::resource('creditsServices', 'CreditsServiceController');
		//积分产品兑换记录
		Route::resource('creditServiceUsers', 'CreditServiceUserController');
	    //查找商品信息
	    Route::get('products/searchGoodsFrame','ProductController@searchGoodsFrame');
		//产品管理
		Route::resource('products', 'ProductController');
		//产品图片
		Route::resource('productImages', 'ProductImageController');
		//服务管理
		Route::resource('services', 'ServicesController');
		//预约看板
		Route::get('subscribes/watch', 'SubscribeController@watch')->name('subscribes.watch');
		//预约管理
		Route::resource('subscribes', 'SubscribeController');
		//技师管理
		Route::resource('technicians', 'TechnicianController');

		//会员等级
		Route::resource('userLevels', 'UserLevelController');

		//会员管理
		Route::resource('users', 'UserController'); 
		
		//产品分类
		Route::resource('categories', 'CategoryController');
		Route::get('childCategories/{parent_id}', 'CategoryController@categoriesOfParent'); 

	

		//订单管理
		Route::resource('orders', 'OrderController');
		//订单商品
		Route::resource('items', 'ItemController');
		//订单操作
	    Route::get('/order/print/{id}','OrderController@print');
	    Route::post('orders/addProductList','OrderController@addProductList');
	    Route::post('orders/delProductList/{item_id}','OrderController@delProductList');
	    Route::get('orders/{id}/delete','OrderController@deleteOrder');
		Route::get('orders/{id}/print', 'OrderController@printOrder'); 
		Route::get('orders/{id}/tripperprint', 'OrderController@tripperprintOrder')->name('order.print');
	    Route::post('orders/{order_id}/report', 'OrderController@reportOrder')->name('order.report');
	    //导出excel
	    Route::post('orders/reportMany', 'OrderController@reportOrderToMany')->name('order.report.many');

		
		//滚动横幅
		Route::resource('banners', 'BannerController');
	    Route::resource('{banner_id}/bannerItems', 'BannerItemController');

		//统计信息
		Route::get('statics', 'StatController@index')->name('stat.index');
		Route::post('report', 'StatController@report')->name('stat.report');

		// 三级分销
		Route::get('distributions/stats', 'DistributionController@stats')->name('distributions.stats');
		Route::get('distributions/lists', 'DistributionController@lists')->name('distributions.lists');
		Route::get('distributions/settings', 'DistributionController@settings')->name('distributions.settings');

		//分销分佣记录
		Route::resource('distributionLogs', 'DistributionLogController');

		//优惠券
		Route::get('coupons/given', 'CouponController@given')->name('coupons.given');
	    Route::post('coupons/given', 'CouponController@postGiven');
	    Route::get('coupons/given_integer', 'CouponController@givenInteger')->name('coupons.integer');
		Route::post('coupons/given_integer', 'CouponController@postGivenInteger');
		Route::get('coupons/stats', 'CouponController@stats')->name('coupons.stats');
		Route::resource('coupons', 'CouponController');
		Route::resource('couponRules', 'CouponRuleController');

	    //用户列表
	    Route::get('/frame/givenUserList','CouponController@givenUserList');

	    Route::get('Promps/pageSet','ProductPrompController@prompPageSetView')->name('promps.pageset');
	    Route::post('Promps/pageSetApi','ProductPrompController@prompPageSetApi')->name('promps.pageset.update');

		//产品促销
		Route::resource('productPromps', 'ProductPrompController');
		//订单促销
		Route::resource('orderPromps', 'OrderPrompController');
		//秒杀
		Route::resource('flashSales', 'FlashSaleController');
		//拼团列表
		Route::resource('teamSales', 'TeamSaleController');
		Route::resource('teamFounds', 'TeamFoundController');
		Route::resource('teamFollows', 'TeamFollowController');
		//Route::resource('teamLotteries', 'TeamLotteryController');

	    //银行卡设置
	    //Route::resource('bankSets', 'BankSetsController');
		//管理员管理
	   //
		//角色管理
		 //Route::resource('roles', 'RoleController');
		 //权限管理
	   // Route::resource('permissions','PermissionsController');

	    //单页面
	    Route::resource('singelPages', 'SingelPageController');
	    //钱包用户操作记录
	   // Route::resource('withDrawls', 'WithDrawlController');
	    
	    //新加文章
	    //文章分类
	    Route::resource('articlecats', 'ArticlecatsController');
	    //文章
	    Route::resource('posts', 'PostController');
	    //页面
	    Route::resource('pages', 'PageController');

	    //通知消息
	    Route::resource('notices', 'NoticeController');

	    /**
		 * iframe操作
		 */
		Route::group([ 'prefix' => 'iframe' ], function () {
			//服务选择iframe
			Route::get('services', 'ServicesController@servicesIframe');
			Route::get('coupons','CouponController@canUseCouponFrame');

		});
		/**
		 * ajax操作
		 */
		Route::group([ 'prefix' => 'ajax' ], function () {
			//积分修改
			Route::post('/user/{user_id}/credits_change','UserController@updateUserCredits');
			//余额修改
			Route::post('/user/{user_id}/money_change','UserController@updateUserMoney');
		    //为当前管理员赋予权限
		    Route::post('/perm/{id}/add','PermissionsController@addPermToAdmin');
		    //为当前管理员移除权限
		    Route::post('/perm/{id}/del','PermissionsController@delPermToAdmin');
		    //冻结用户
		    Route::post('/freezeuser/{userid}','UserController@freezeUserById');
		    //操作分销资格
		    Route::post('/distributeUser/{userid}','UserController@distributeUser');
		    //图片上传
		    Route::post('/uploads','AjaxController@uploadImage');
		    //根据店铺id获取对应的服务
		    Route::get('/get_services_by_shop/{shop_id}','AjaxController@getServiceByShopIdApi');
		   	//根据服务id获取对应的技师
		   	Route::get('/get_technicicans_by_service/{service_id}','AjaxController@getTechniciansByServicesIdApi');
		   	//给指定用户发消息
		   	Route::get('/send_notice/{user_id}','AjaxController@sendNoticeByUserId');
		   	//发送消息给群组用户
		   	Route::get('/send_group_notice','AjaxController@sendGroupUserNotices');
		});
	});
});







