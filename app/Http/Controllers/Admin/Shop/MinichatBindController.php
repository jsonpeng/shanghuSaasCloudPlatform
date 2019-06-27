<?php

namespace App\Http\Controllers\Admin\Shop;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use EasyWeChat\Factory;
use Log;
use App\Models\Minichat;
use App\Models\Admin;
use EasyWeChat\OpenPlatform\Server\Guard;

use Carbon\Carbon;
use GuzzleHttp\Client;

class MinichatBindController extends Controller
{

	private function processMiniAccount($minichat, $handelResult, $basicInfo, $admin_id)
	{
		if (empty($minichat)) {
    		$minichat = Minichat::create([
		        'app_id' => $handelResult['authorization_info']['authorizer_appid'],
		        'access_token' => $handelResult['authorization_info']['authorizer_access_token'],
		        'expires' => Carbon::now()->addSeconds($handelResult['authorization_info']['expires_in']),
		        'refresh_token' => $handelResult['authorization_info']['authorizer_refresh_token'],
		        'admin_id' => $admin_id,
		        'nick_name' => $basicInfo['authorizer_info']['nick_name'],
		        'head_img' => $basicInfo['authorizer_info']['head_img'],
		        'service_type_info' => $basicInfo['authorizer_info']['service_type_info']['id'],
		        'verify_type_info' => $basicInfo['authorizer_info']['verify_type_info']['id'],
		        'user_name' => $basicInfo['authorizer_info']['user_name'],
		        'principal_name' => $basicInfo['authorizer_info']['principal_name'],
		        'qrcode_url' => $basicInfo['authorizer_info']['qrcode_url'],
		        'signature' => $basicInfo['authorizer_info']['signature'],
		        'business_info_store' => $basicInfo['authorizer_info']['business_info']['open_store'],
		        'business_info_scan' => $basicInfo['authorizer_info']['business_info']['open_scan'],
		        'business_info_pay' => $basicInfo['authorizer_info']['business_info']['open_pay'],
		        'business_info_card' => $basicInfo['authorizer_info']['business_info']['open_card'],
		        'business_info_shake' => $basicInfo['authorizer_info']['business_info']['open_shake']
	    	]);
    	} else {
    		$minichat->update([
    			'access_token' => $handelResult['authorization_info']['authorizer_access_token'],
		        'expires' => Carbon::now()->addSeconds($handelResult['authorization_info']['expires_in']),
		        'refresh_token' => $handelResult['authorization_info']['authorizer_refresh_token'],
		        'admin_id' => $admin_id,
		        'nick_name' => $basicInfo['authorizer_info']['nick_name'],
		        'head_img' => $basicInfo['authorizer_info']['head_img'],
		        'service_type_info' => $basicInfo['authorizer_info']['service_type_info']['id'],
		        'verify_type_info' => $basicInfo['authorizer_info']['verify_type_info']['id'],
		        'user_name' => $basicInfo['authorizer_info']['user_name'],
		        'principal_name' => $basicInfo['authorizer_info']['principal_name'],
		        'qrcode_url' => $basicInfo['authorizer_info']['qrcode_url'],
		        'signature' => $basicInfo['authorizer_info']['signature'],
		        'business_info_store' => $basicInfo['authorizer_info']['business_info']['open_store'],
		        'business_info_scan' => $basicInfo['authorizer_info']['business_info']['open_scan'],
		        'business_info_pay' => $basicInfo['authorizer_info']['business_info']['open_pay'],
		        'business_info_card' => $basicInfo['authorizer_info']['business_info']['open_card'],
		        'business_info_shake' => $basicInfo['authorizer_info']['business_info']['open_shake']
    		]);
    	}

    	return $minichat;
	}
    public function bind()
    {

    	$config = [
			'app_id'   => 'wxad844ca9d11db36d',
			'secret'   => 'ecd3a93041694b70e1e445230b2b95e5',
			'token'    => 'BhOPpQiFlStSdKGueyl7N',
			'aes_key'  => 'BhOPpQiFlStSdKGueyl7N1OdUB5qTZW8jy2XecOCNgf'
		];

		$openPlatform = Factory::openPlatform($config);

		$admin = auth('admin')->user();

		$auth_url = $openPlatform->getPreAuthorizationUrl('http://www.qijianshen.xyz/mini_notify?admin='.$admin->account);

		return view('admin.minichat.authorize', compact('auth_url'));
    }

    public function miniNotify(Request $request)
    {
    	Log::info('miniNotify');
    	Log::info($request);

    	$auth_code = $request->input('auth_code');
    	$expires_in = $request->input('expires_in');

		$config = [
			'app_id'   => 'wxad844ca9d11db36d',
			'secret'   => 'ecd3a93041694b70e1e445230b2b95e5',
			'token'    => 'BhOPpQiFlStSdKGueyl7N',
			'aes_key'  => 'BhOPpQiFlStSdKGueyl7N1OdUB5qTZW8jy2XecOCNgf'
		];

		$openPlatform = Factory::openPlatform($config);

    	$server = $openPlatform->server;
    	if ($request->has('signature')) {
    		return $server->serve();
    	}
    	//授权APP信息
    	$handelResult = $openPlatform->handleAuthorize();
    	Log::info('handelResult');
    	Log::info($handelResult);
    	//获取账号基本信息
    	$basicInfo = $openPlatform->getAuthorizer($handelResult['authorization_info']['authorizer_appid']);
    	Log::info('basicInfo');
    	Log::info($basicInfo);

    	if (!array_key_exists('MiniProgramInfo', $basicInfo['authorizer_info'])) {
    		# 不是小程序授权
    		return '不是小程序授权';
    	}
    	//保存小程序信息，存在则更新，不存在则新建
    	if (!$request->has('admin')) {
    		return '没有管理员账号信息';
    	}

    	$admin_count = $request->input('admin');
    	$admin = Admin::where('account', $admin_count)->first();
    	if (empty($admin)) {
    		return '账号信息不存在';
    	}
    	$minichat = Minichat::where('app_id', $handelResult['authorization_info']['authorizer_appid'])->first();
    	$minichat = $this->processMiniAccount($minichat, $handelResult, $basicInfo, $admin->id);
    	//修改服务器地址
    	$client = new Client(['base_uri' => 'https://api.weixin.qq.com/wxa/']);
		$response = $client->request('POST', 'modify_domain?access_token='.$handelResult['authorization_info']['authorizer_access_token'], [
		    'body' => json_encode([
		        'action' => 'set',
		        'requestdomain' => ['https://www.qijianshen.xyz'],
		        'wsrequestdomain' => ['wss://www.qijianshen.xyz'],
			    'uploaddomain' => ['https://www.qijianshen.xyz'],
			    'downloaddomain' => ['https://www.qijianshen.xyz'],
		    ])
			// 'form_params' => [
		 //        'action' => 'add',
		 //        'requestdomain' => ['https://www.qijianshen.xyz','https://www.qijianshen.xyz'],
		 //        'wsrequestdomain' => ['wss://www.qijianshen.xyz','wss://www.qijianshen.xyz'],
			//     'uploaddomain' => ['https://www.qijianshen.xyz','https://www.qijianshen.xyz'],
			//     'downloaddomain' => ['https://www.qijianshen.xyz','https://www.qijianshen.xyz'],
		 //    ]
		    // 'body' => "{
		    //     'action':'add',
		    //     'requestdomain':['https://www.qijianshen.xyz','https://www.qijianshen.xyz'],
		    //     'wsrequestdomain':['wss://www.qijianshen.xyz','wss://www.qijianshen.xyz'],
		    //     'uploaddomain':['https://www.qijianshen.xyz','https://www.qijianshen.xyz'],
		    //     'downloaddomain':['https://www.qijianshen.xyz','https://www.qijianshen.xyz'],
		    // }"
            // 'headers' => [
            //     'content-type' => 'application/json',
            // ]
		]);

		$data = json_decode($response->getBody());
		Log::info('modify_domain');
		Log::info($response->getBody());
    	//设置小程序业务域名
    	$response = $client->request('POST', 'setwebviewdomain?access_token='.$handelResult['authorization_info']['authorizer_access_token'], [
			    'body' => json_encode([
			        'action' => 'set',
			        'webviewdomain' => ['https://www.qijianshen.xyz'],
			    ])
		]);

		$data = json_decode($response->getBody());
		Log::info('setwebviewdomain');
		Log::info($response->getBody());
    	//代码管理
		$response = $client->request('POST', 'commit?access_token='.$handelResult['authorization_info']['authorizer_access_token'], [
		    'body' => json_encode([
		    	"template_id" => 2,
				"ext_json" => json_encode([
			        'extAppid' => $handelResult['authorization_info']['authorizer_appid'],
			    	'ext' => [
			    		'server' => 'https://ajls3lyu.shop.qijianshen.xyz',
				        'name' => '到店系统',
				        'theme' => 'default',
				        'config' => [
				        	'FUNC_TEAMSALE' => true, 
				        	'FUNC_COUPON' => true, 
				        	'FUNC_CREDITS' => true, 
				        	'FUNC_DISTRIBUTION' => true, 
				        	'FUNC_CASH_WITHDRWA' => true, 
				        	'FUNC_MEMBER_LEVEL' => true
				        ],
			    	],
			        'pages' => [
					    'pages/index/index',
					    'pages/found/found',
					    'pages/usercenter/usercenter',
					    'pages/product/product',
					    'pages/subscribe/subscribe',
					    'pages/subscribe/addSubscribe',
					    'pages/store_list/store_list',
					    'pages/store_detail/store_detail',
					    'pages/usercenter/card',
					    'pages/usercenter/credits',
					    'pages/product/product_detail',
					    'pages/myserve/myserve',
					    'pages/privilege/privilege',
					    'pages/recharge/recharge',
					    'pages/orders/orders',
					    'pages/credits_mall/credits_mall',
					    'pages/usercenter/balance',
					    'pages/conversion/conversion',
					    'pages/issue/issue',
					    'pages/usercenter/coupon',
					    'pages/pay/pay',
					    'pages/pay/checkout',
					    'pages/message/message',
					    'pages/test/rili',
					    'pages/news/news',
					    'pages/publish/publish',
					    'pages/admin/index',
					    'pages/admin/card'
					]
			    ]), //*ext_json需为string类型，请参考下面的格式*
				"user_version" => "1.0",
				"user_desc" => "test",
		    ])
		]);


		$data = json_decode($response->getBody());
		Log::info('commit');
		Log::info($response->getBody());

		Log::info('体验二维码');
		return $response = $client->request('GET', 'get_qrcode?access_token='.$handelResult['authorization_info']['authorizer_access_token']);
		Log::info($response->getBody());

    	//获取授权方的帐号基本信息
    	//$openPlatform->getAuthorizer(string $appId);

    	//获取授权方的选项设置信息
    	//$openPlatform->getAuthorizerOption(string $appId, string $name);
    	//
    	//设置授权方的选项信息
    	//$openPlatform->setAuthorizerOption(string $appId, string $name, string $value);
    	//获取已授权的授权方列表
    	//$openPlatform->getAuthorizers(int $offset = 0, int $count = 500)
    	
	    return 'ok';
    }

    public function miniEvent(Request $request, $appid)
    {

    	Log::info('miniEvent');
    	Log::info($request->all());

    	$config = [
			'app_id'   => 'wxad844ca9d11db36d',
			'secret'   => 'ecd3a93041694b70e1e445230b2b95e5',
			'token'    => 'BhOPpQiFlStSdKGueyl7N',
			'aes_key'  => 'BhOPpQiFlStSdKGueyl7N1OdUB5qTZW8jy2XecOCNgf'
		];

		$openPlatform = Factory::openPlatform($config);

    	$server = $openPlatform->server;
	    // 处理授权成功事件，其他事件同理
	    $server->push(function ($message) {
	        // $message 为微信推送的通知内容，不同事件不同内容，详看微信官方文档
	        // 获取授权公众号 AppId： $message['AuthorizerAppid']
	        // 获取 AuthCode：$message['AuthorizationCode']
	        // 然后进行业务处理，如存数据库等...
	        Log::info($message);
	    }, Guard::EVENT_AUTHORIZED);

	    // 处理授权更新事件
		$server->push(function ($message) {
		    // ...
		}, Guard::EVENT_UPDATE_AUTHORIZED);

		// 处理授权取消事件
		$server->push(function ($message) {
		    // ...
		}, Guard::EVENT_UNAUTHORIZED);

	    return $server->serve();
    }
}
