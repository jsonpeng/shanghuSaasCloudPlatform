@extends('front.default.layout.base')

@section('css')
    <style>
        .weui-grid{width: 25%;}
        body{background-color:{{ themeSecondColor() }};}
        .nav_tip{background:transparent;}
        .nav_tip .titile{color: #fff;font-size: 17px;}
        .shareCode{margin-bottom: 0;margin-top:15px;height: auto;}
        .weui-cell__hd img{width:35.5px;margin-left: 60px;margin-right: 10px;}
        .weui-cell__bd{text-align: left;}
        .ft-l{font-size:16px;}
        .ft-s{font-size: 14px;color: #949494;}
    </style>
@endsection

@section('content')
	<div class="nav_tip">
	  <div class="img">
	    <a href="javascript:history.back(-1)"><i class="icon ion-ios-arrow-left"></i></a></div>
	  <p class="titile">联系客服</p>
	  <!--div class="userSet">
	      <a href="javascript:;">
	            <img src="{{ asset('images/default/more.png') }}" alt="">
	      </a>
	  </div-->
	</div>

    @foreach ($kefu as $item)
    <div class="weui_planel_item shareCode">
        <div class="weui-media-box">
            {{-- <i><img class="" src="" alt=""></i><span>用户名称</span> --}}
            <div class="weui-cell">
                <div class="weui-cell__hd"><img class="" src="{!! $item->head_img !!}" alt=""></div>
                <div class="weui-cell__bd">
                    <p class="ft-l">{!! $item->Jobs !!}客服：{!! $item->name !!}</p>
                    <p class="ft-s">扫描或长按二维码联系客服</p>
                </div>
            </div>
        </div>
        <div class="weui-media-box cut_line">
            <div class="border"></div>
            <div class="weui-cell-fl"></div>
            <div class="weui-cell-fr"></div>
        </div>
        <div class="weui-media-box QRcode">
            <div class="QRimg">
                <img src="{!! $item->qr_code !!}" alt="">
            </div>
        </div>
    </div>
   @endforeach


@endsection


@section('js')
    
@endsection