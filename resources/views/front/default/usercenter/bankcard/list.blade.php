@extends('front.default.layout.base')

@section('css')
<style>
	.page__bd_spacing{padding: 7.5px 0;}
	.withdraw-sum .weui-btn{margin-top: 0;border-radius:0;}
	.withdraw-sum .withdraw-bank{border-bottom: 1px solid #d4d6dc;margin: 0;}
</style>
@endsection

@section('content')
<div class="nav_tip">
  <div class="img">
    <a href="javascript:history.back(-1)"><i class="icon ion-ios-arrow-left"></i></a></div>
  <p class="titile">银行卡列表</p>
</div>
<div class="withdraw-sum weui-cells">
	<div class="weui-cell  withdraw-bank">
		<div class="weui-cell__hd ">
			<img src="{{ asset('images/bank1.png') }}" alt="">
		</div>
		<div class="weui-cell__bd">
			<p class="ft-l">招商银行</p>
			<p class="ft-s">1658储蓄卡</p>
		</div>
		<div class="weui-cell__ft">
			<i class="weui-icon-success-no-circle"></i>
		</div>
	</div>
	<div class="weui-cell  withdraw-bank">
		<div class="weui-cell__hd ">
			<img src="{{ asset('images/bank1.png') }}" alt="">
		</div>
		<div class="weui-cell__bd">
			<p class="ft-l">招商银行</p>
			<p class="ft-s">1658储蓄卡</p>
		</div>
		<div class="weui-cell__ft">
			<i class="weui-icon-success-no-circle"></i>
		</div>
	</div>
	<div class="weui-cell  withdraw-bank">
		<div class="weui-cell__hd ">
			<img src="{{ asset('images/bank1.png') }}" alt="">
		</div>
		<div class="weui-cell__bd">
			<p class="ft-l">招商银行</p>
			<p class="ft-s">1658储蓄卡</p>
		</div>
		<div class="weui-cell__ft">
			<i class="weui-icon-success-no-circle"></i>
		</div>
	</div>
	<div class="page__bd page__bd_spacing">
		<a href="javascript:;" class="weui-btn">+添加新卡片</a>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript">

</script>
@endsection