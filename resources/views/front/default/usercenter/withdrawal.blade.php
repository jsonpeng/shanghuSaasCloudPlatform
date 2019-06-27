@extends('front.default.layout.base')

@section('css')

@endsection

@section('content')
	<div class="nav_tip">
	  <div class="img">
	    <a href="javascript:history.back(-1)"><i class="icon ion-ios-arrow-left"></i></a></div>
	  <p class="titile">提现</p>
	</div>
	<div class="weui-cells withdraw">
		<div class="weui-media-box withdraw-head">
			<p class="ft-l">申请提现</p>
			<p class="ft-s">2月26日</p>
		</div>
		<div class="weui-media-box withdraw-body">
			<p class="ft-s">提现金额</p>
			<p class="ft-l">¥99.90</p>
		</div>
		<div class="weui-cell withdraw-text">
			<div class="weui-cell__hd">提现银行：</div>
			<div class="weui-cell__bd">提现银行</div>
		</div>
		<div class="weui-cell withdraw-text">
			<div class="weui-cell__hd">提现时间：</div>
			<div class="weui-cell__bd">2018-2-26 18:02:11</div>
		</div>
		<div class="weui-cell withdraw-text">
			<div class="weui-cell__hd">预计到账时间：</div>
			<div class="weui-cell__bd">2018-2-26 18:02:11</div>
		</div>
		<div class="weui-cell withdraw-text">
			<div class="weui-cell__hd">备注：</div>
			<div class="weui-cell__bd">提现到账状态</div>
		</div>
		<div class="weui-cell weui-cell_access withdraw-foot">
			<div class="weui-cell__bd">查看详情</div>
			<div class="weui-cell__ft"></div>
		</div>
	</div>
	<div class="withdraw-apply">
		<a href="">申请提现</a>
	</div>
@endsection


@section('js')
    
@endsection