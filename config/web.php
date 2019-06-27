<?php
return [
    'cachetime' => 2,
    'app_env' => env('APP_ENV'),

    'SMS_ID' => env('SMS_ID', ''),
	'SMS_KEY' => env('SMS_KEY', ''),
	'SMS_SIGN' => env('SMS_SIGN', ''),
	'SMS_TEMPLATE_VERIFY' => env('SMS_TEMPLATE_VERIFY', ''),

    //品牌街
    'FUNC_BRAND' => env('FUNC_BRAND', false),
	//商品优惠
	'FUNC_PRODUCT_PROMP' => env('FUNC_PRODUCT_PROMP', false),
	//订单优惠
	'FUNC_ORDER_PROMP' => env('FUNC_ORDER_PROMP', false),
	//订单取消
	'FUNC_ORDER_CANCEL' => env('FUNC_ORDER_CANCEL', false),
	//退换货
	'FUNC_AFTERSALE' => env('FUNC_AFTERSALE', false),
	//秒杀
	'FUNC_FLASHSALE' => env('FUNC_FLASHSALE', false),
	//拼团
	'FUNC_TEAMSALE' => env('FUNC_TEAMSALE', false),
	//优惠券
	'FUNC_COUPON' => env('FUNC_COUPON', false),
	//积分功能
	'FUNC_CREDITS' => env('FUNC_CREDITS', false),
	//余额功能（搭配银行卡）
	'FUNC_FUNDS' => env('FUNC_FUNDS', false),
	//三级分销
	'FUNC_DISTRIBUTION' => env('FUNC_DISTRIBUTION', false),
	//提现功能
	'FUNC_CASH_WITHDRWA' => env('FUNC_CASH_WITHDRWA', false),
	//微信功能
	'FUNC_WECHAT' => env('FUNC_WECHAT', false),
	//会员等级
	'FUNC_MEMBER_LEVEL' => env('FUNC_MEMBER_LEVEL', false),
	//开发票
	'FUNC_FAPIAO' => env('FUNC_FAPIAO', false),
	//主题选择
	'FUNC_THEME' => env('FUNC_THEME', false),
	//颜色配置
	'FUNC_COLOR' => env('FUNC_COLOR', false),
	//页面底部信息
	'FUNC_FOOTER' => env('FUNC_FOOTER', false),
	//文章信息
	'FUNC_POST' => env('FUNC_POST', false),
	//商品收藏
	'FUNC_COLLECT' => env('FUNC_COLLECT', false),
	//显示芸来技术支持
	'FUNC_YUNLIKE' => env('FUNC_YUNLIKE', false),
	//微信支付
	'FUNC_WECHATPAY' => env('FUNC_WECHATPAY', false),
	//微信个人支付
	'FUNC_PAYSAPI' => env('FUNC_PAYSAPI', false),
	//支付宝
	'FUNC_ALIPAY' => env('FUNC_ALIPAY', false),
    
];