@extends('admin.layouts.app')

@section('css')
	<style>
		ul{
		  	list-style: none;
		  	margin:0;
		  	padding:0;
		}
		.section{
			margin:20px;
			background-color: #fff;
			box-shadow:0 0 8px rgba(0,14,45,0.11);
		}
		.pay-box{
			padding:20px 30px;
		}
		.pay-box ul li{
			font-size: 14px;
			line-height: 34px;
		}
		.pay-box ul li.select{
			padding-left:30px;
			overflow: hidden;
			margin:15px 0;
		}
		.pay-box ul li.select ul li{
			width:108px;
			padding:0 7px;
			border:2px solid #bfbfbf;
			border-radius:6px;
			float:left;
			margin-right: 28px;
		}
		.pay-box ul li.select ul li.active{
			border:2px solid #4c84ff;
		}
		.pay-box ul li.select ul li.active p{
			color:#4c84ff;
		}
		.pay-box ul li.select ul li p{
			line-height: 38px;
			font-size: 14.5px;
			text-align:center;
			margin-bottom: 0;
			color:#333;
		}
		.pay-box ul li.select ul li p:first-child{
			border-bottom:2px solid #ebebeb;
		}
		.pay-box ul li.price{
			padding-left:15px;
		}
		.pay-box ul li.price span{
			color:#4c84ff;
		}
		.pay-box ul li.check{
			margin-left: 70px;
			background: url(images/checked.png) left center no-repeat;
		}
		.pay-box ul li.check label{
			margin-bottom: 0;
		}
		.pay-box ul li.check input{
			width:14px;
    		height: 14px;
    		vertical-align: middle;
     		filter:alpha(opacity=0);   
	        -moz-opacity:0;   
	        -khtml-opacity: 0;   
	        opacity: 0;   
	        margin-right: 6px;
		}
		.pay-box .pay li span{
			margin-right: 20px;
		}
		.pay-box .pay li a{
		    display: inline-block;
		    padding: 6px 15px;
			background-color: #4c84ff;
			color:#fff;
		    font-size: 14px;
		    font-weight: 400;
		    line-height: 1.42857143;
		    text-align: center;
		    white-space: nowrap;
		    vertical-align: middle;
		    border-radius: 4px;
		}
		.line{
			width:100%;
			height:1px;
			background-color: #efefef;
			margin:0 10px;
		}
		.agree{
			padding:20px 30px;
		}
		.agree .btn{
			padding:6px 32px;
			background-color:#4c84ff;
			color:#fff;
		}
		.agreement{
			margin-top: 14px;
		}
		.agreement a{
			color:#4c84ff;
		}

		.pup-box,.chongzhi{
			width:540px;
			background-color: #fff;
			position:fixed;
			top:50%;
			left:50%;
			transform: translate(-50%, -50%);
			padding:0 15px;
			padding-bottom:45px;
			z-index: 1001;
		}
		.chongzhi{
			padding-bottom:0;
		}
		.chongzhi .title{
			padding:20px;
			font-size: 14px;
			font-weight:bold;
			border-bottom: 1px solid #efefef;
		}
		.chongzhi .title img{
			float: right;
		}
		.prices{
			display: none;
		}
	</style>
@endsection
		
@section('content')
	<div class="section">
		<div class="pay-box">
			<ul>
				<li>订购店铺：{{ shop(now_shop_id())->name }}</li>
				<li>购买内容：软件产品优惠方案-软件服务+{{ $package->name }}</li>
				<li>生效周期：<span class="package_time_month">12</span>个月</li>
				<li>选择购买年限：</li>
				<li class="select">
					<ul class="sel-price">
						@foreach ($package_prices as $item)
						<li data-years="{{ $item->years }}" data-oriprice="{{ $item->origin_price }}"  data-chaprice="{{ $item->discount_price }}" data-price="{{ $item->price }}" data-relprice="{{ $item->rel_price }}" data-id="{{ $item->id }}">
							<p>{{ $item->years }}年</p>
							<p>¥{{ round($item->price/$item->years,2) }}/年</p>
						</li>
						@endforeach
					</ul>
				</li>

				<li class="prices" style="padding-left:30px;">原价：<span class="package_origin_price"style="text-decoration:line-through;"></span></li>

				<li class="price prices">套餐价：<span class="package_ori_price"></span></li>
				@if($type == '升级')<li class="price prices">原套餐补差价立减：-<span class="package_cha_price"></span></li>@endif
				<li class="price prices">应付款：<span class="package_now_price"></span></li>

				
			</ul>
		</div>
		<div class="line"></div>
		<div class="agree">
			<button type="button" class="btn" id="popup">立即付款</button>
			<div class="agreement">点击付款即代表您已阅读并同意 <a href="">《芸来服务订购协议》</a></div>
		</div>
	</div>

	<div class="pup-box" style="display: none; width:540px;">
	
		<div class="pay-box">
			<ul class="pay">
				<li><span>应付金额：</span><span style="color:#4c84ff" class="package_rel_price">¥</span></li>
				<li><span>扫码付款：</span>使用微信或支付宝扫码支付，成功后即时到账</li>
				<li style="margin:10px 0"><span style="opacity: 0">占位占位：</span><img src="" alt=""></li>
			
			<p>
				单笔最高两万元，同时取决于您所用银行卡的限额；如需大额充值，建议分多次进行。充值金额是实时到账的，若收支明细中没有记录，可能是系统延迟引起，您可稍后查看。超过一天仍未显示到账，可以联系客服查询处理。
			</p>
		</div>
	</div>
	<div class="chongzhi" style="display: none;">
		<div class="title">
			充值
			<img src="" alt="" id="cha">
		</div>
		<div class="pay-box">
			<ul class="pay">
				<li><span>充值金额：</span><span style="color:#4c84ff">¥5800.00</span></li>
				
				<li style="margin:10px 0"><span style="opacity: 0">占位占位：</span><img src="/images/erweima.png" alt=""></li>
				<li style="margin-top: 10px;"><span style="opacity: 0">占位占位：</span><a href="">我已成功支付</a></li>
			</ul>
		</div>
		
	</div>
@endsection
		
@section('scripts')
	<script>
		$(document).ready(function(){
		    var flag = 1;
		    $(".check").click(function(){
		        if(flag == 1){
		            $(".check").css("background","url(images/checked.png) left center no-repeat");
		            flag = 0;
		        } else{
		            $(".check").css("background","url(images/check.png) left center no-repeat");
		            flag = 1;
		        }
		    })	
		    
			$('#popup').click(function(e) {
		    	e.preventDefault();
		    	var active_package =  $('.sel-price li.active');
		    	if(active_package.length){
		    		$.zcjyRequest('/create_package_qrcode',function(res){
		    			$('.pup-box').find('img').attr('src',res.qrcode);
					    layer.open({
					    	title:'{{ $type.$package->name }}'+'['+active_package.data('years')+'年]',
					        type: 1,
					        closeBtn: false,
					        shift: 7,
					        area: ['540px','40%'],
					        shadeClose: true,
					        content: $('.pup-box').html()
				        });
				        startInterval(res.log_id);
					},{package_price_id:active_package.data('id'),admin_id:"{{ admin()->id }}",type:"{{ $type }}",price:active_package.data('relprice')});
				}
				else{
					 layer.msg("请选择套餐!", {icon: 5});
				}
		    });

		    $('.sel-price li').click(function(e) {
		    	var origin_price = parseFloat($(this).data('oriprice'));
		    	var price =  parseFloat($(this).data('price'));
		    	var rel_price = parseFloat($(this).data('relprice'));
				var years = parseFloat($(this).data('years'));
				var cha_price = parseFloat($(this).data('chaprice'));

				if(cha_price != 0){
					//套餐立减补续费差价
					$('.package_cha_price').text(cha_price);
				}

				$('.prices').removeClass('prices');
				//生产周期
				$('.package_time_month').text(years *12);
				//原价
				$('.package_origin_price').text(origin_price);
				//套餐价格
				$('.package_ori_price').text(price);
				//套餐 应付价格
				$('.package_now_price,.package_rel_price').text(rel_price);
				$(this).addClass('active').siblings().removeClass('active');

			});
		});
		var package_interval=null;
		function startInterval(log_id){
			if(package_interval != null){
			  clearInterval(package_interval);
			}
			package_interval  = setInterval(function(){
			    	$.zcjyRequest('/pay_package_callback/'+log_id,function(res){
			    		if(res == '支付成功'){
			    			layer.msg(res, {icon: 1});
			    			location.href="{{ route('package.buy') }}";
			    		}
			    	});
			    },3000);
			return package_interval;
		}
	</script>
@endsection