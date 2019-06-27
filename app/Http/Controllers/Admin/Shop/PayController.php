<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;

class PayController extends AppBaseController{

	//套餐列表
	public function index(){

		#套餐列表
		$packages = app('commonRepo')->chargePackageRepo()->getAdminPackages(admin());
		#商户当前的套餐状况
		$admin_package = getAdminPackageStatus();
		
		
	 	return view('admin.pay.index',compact('packages','admin_package'));
	}

	//套餐支付详情
	public function detail(Request $request,$id){
		$package = app('commonRepo')->chargePackageRepo()->findWithoutFail($id);
		
		if(empty($package)){
			return redirect(route('package.buy'));
		}

		$type = '购买';

		if($request->has('type')){
			session([admin()->id.'_package_type'=>$request->get('type')]);
			return redirect(route('package.detail',$id));
		}

		#类型
		if(!empty(session(admin()->id.'_package_type'))){
			
			$type = session(admin()->id.'_package_type');
		}
		#套餐组合
		$package_prices = $this->attachRelPrice($package->prices()->orderBy('years','asc')->get(),$type);
		// dd($package_prices);
		return view('admin.pay.detail',compact('package','package_prices','type'));
	}

	private function attachRelPrice($package_prices,$type){
		foreach ($package_prices as $key => $val) {
			$val['rel_price'] = $val->price;
			$val['discount_price'] = 0;
			if($type == '升级'){
				$admin_package = getAdminPackageStatus();
				#当前商户套餐还有多少天
				$admin_package_time = $admin_package['time'];
				       #过期升级按一年收费
                        if($admin_package_time <= 0){
                              $val['rel_price'] = $val->price;
                        }

                        #剩余套餐时间超过365天 和 刚买升级直接减去之前套餐价格
                        if($admin_package_time >= 365){
                              $val['rel_price'] = $val->price - $admin_package['package']->price;
                              $val['discount_price'] = $val->price - $val['rel_price'];
                        }

                        if($admin_package_time < 365){
                              #其他按照使用天数来减
                              $val['rel_price'] = round($val->price- $admin_package['package']->price*($admin_package_time/365));
                              $val['discount_price'] = $val->price - $val['rel_price'];
                        }
			}
		}
		return $package_prices;
	}

	//生成套餐支付二维码
	public function createPackageQrCode(Request $request){
		$log = app('commonRepo')->createPackageLog($request->get('package_price_id'),$request->get('admin_id'),$request->get('type'),$request->get('price'));
		if(!empty($log)){
			$qrcode = app('commonRepo')->createQrCodes(route('pay.package').'?package_log_id='.$log->id,150);
		}
		else{
			return zcjy_callback_data('生成二维码失败',1,'web');
		}
		return zcjy_callback_data(['qrcode'=>$qrcode,'log_id'=>$log->id],0,'web');
	}

	//支付监听状态
	public function payPackageCallback($id){
		$package_log = app('commonRepo')->packageLogRepo()->findWithoutFail($id);
		if(empty($package_log)){
			return zcjy_callback_data('没有该套餐记录',1,'web');
		}
		if($package_log->status == '已完成'){
			return zcjy_callback_data('支付成功',0,'web');
		}
		else{
			return zcjy_callback_data('等待支付',3,'web');
		}
	}

	//支付测试回转
	public function payPackageTest(Request $request){
		$input = $request->all();

		if(!array_key_exists('package_log_id',$input) || empty($input['package_log_id']) || empty(app('commonRepo')->packageLogRepo()->findWithoutFail($input['package_log_id']))){
			return zcjy_callback_data('缺少支付参数',1,'web');
		}

		#处理套餐购买
		app('commonRepo')->processPackageById($input['package_log_id']);

		return zcjy_callback_data('支付成功',0,'web');

	}




}