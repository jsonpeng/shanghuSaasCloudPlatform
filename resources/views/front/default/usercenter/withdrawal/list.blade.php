@extends('front.default.layout.base')

@section('css')

@endsection

@section('content')
	<div class="nav_tip">
	  <div class="img">
	    <a href="javascript:history.back(-1)"><i class="icon ion-ios-arrow-left"></i></a></div>
	  <p class="titile">提现</p>
	  <!--div class="userSet">
	      <a href="javascript:;">
	            <img src="{{ asset('images/default/more.png') }}" alt="">
	      </a>
	  </div-->
	</div>
	@foreach($withdrawl as $item)
	<div class="weui-cells withdraw">
		<div class="weui-media-box withdraw-head">
			<p class="ft-l">申请提现</p>
			<p class="ft-s">{!! $item->created_at->format('m') !!}月{!! $item->created_at->format('d') !!}日</p>
		</div>
		<div class="weui-media-box withdraw-body">
			<p class="ft-s">提现金额</p>
			<p class="ft-l">¥{!! $item->price !!}</p>
		</div>
		<div class="weui-cell withdraw-text">
			<div class="weui-cell__hd">提现银行：</div>
			<div class="weui-cell__bd">{!! $item->card_name !!}</div>
		</div>
		<div class="weui-cell withdraw-text">
			<div class="weui-cell__hd">提现时间：</div>
			<div class="weui-cell__bd">{!! $item->created_at !!}</div>
		</div>
		<div class="weui-cell withdraw-text">
			<div class="weui-cell__hd">预计到账时间：</div>
			<div class="weui-cell__bd">{!! $item->arrive_time !!}</div>
		</div>
		<div class="weui-cell withdraw-text">
			<div class="weui-cell__hd">备注：</div>
			<div class="weui-cell__bd">{!! $item->status !!}</div>
		</div>
		<div class="weui-cell weui-cell_access withdraw-foot">
			<div class="weui-cell__bd">查看详情</div>
			<div class="weui-cell__ft"></div>
		</div>
	</div>
	@endforeach

	<div class="withdraw-apply">
		<a href="/usercenter/withdrawal/action">申请提现</a>
	</div>

@endsection


@section('js')
    
@endsection