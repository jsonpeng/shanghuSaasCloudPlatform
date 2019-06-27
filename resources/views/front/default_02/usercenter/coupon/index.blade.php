@extends('front.default.layout.base')

@section('css')
    <style>
		
    </style>
@endsection

@section('content')
<div class="nav_tip">
  <div class="img">
    <a href="/usercenter"><img src="{{ asset('images/return.png') }}" alt=""></a></div>
  <p class="titile">优惠券</p>
</div>
<div class="discount">
	<div class="weui-tab">
		<div class="weui-navbar">
		    <a class="weui-navbar__item  @if($type == -1) weui-bar__item_on @endif" href="/coupon">
		        全部
		    </a>
		    <a class="weui-navbar__item  @if($type == 0) weui-bar__item_on @endif" href="/coupon/0">
		        待使用
		    </a>
		    <a class="weui-navbar__item  @if($type == 2) weui-bar__item_on @endif" href="/coupon/2">
		        已使用
		    </a>
		    <a class="weui-navbar__item  @if($type == 3) weui-bar__item_on @endif" href="/coupon/3">
		        已失效
		    </a>
		</div>
	    <div class="weui-tab__panel" id="scroll-container">
	    	@if(!empty($coupons))
				@foreach($coupons as $item)

				<div class="weui_planel_item scroll-post @if( $item->status != 0 ) lose-effic uesed @endif">
					@if($item->status == 4)
						<div class="slide-toggle">
							<img  src="{{asset('images/cancel.png')}}" alt="">
						</div>
					@endif
					@if($item->status == 3)
						<div class="slide-toggle">
							<img  src="{{asset('images/guoqi.png')}}" alt="">
						</div>
					@endif
					@if($item->status == 2)
						<div class="slide-toggle">
							<img  src="{{asset('images/used.png')}}" alt="">
						</div>
					@endif
					@if($item->status == 1)
						<div class="slide-toggle">
							<img  src="{{asset('images/freeze.png')}}" alt="">
						</div>
					@endif
					@if($item->status == 0)
						<!--div class="slide-toggle">
							<img class="open" src="{{asset('images/top.png')}}" alt="">
							<img  class="shut" src="{{ asset('images/bottom.png') }}" alt="">
						</div-->
					@endif

					<div class="weui-panel_bd">
						<a href="javascript:;" class="weui-media-box weui-media-box_appmsg" style="align-items:flex-start;">
							@if($item['coupon']->type == '打折')
							<div class="weui-media-box_hd">
								<div class="type">折扣券</div>
								<div class="sum"><span>{!! $item['coupon']->discount !!}</span>折</div>
							</div>
							@endif

							@if($item['coupon']->type == '满减')
							<div class="weui-media-box_hd">
								<div class="type">满减券</div>
								<div class="sum"><span>{!! $item['coupon']->given !!}</span>元</div>
							</div>
							@endif

							<div class="weui-media-box_bd">
								<h4 class="weui-media-box_title">{{ $item['coupon']->name }}</h4>
								<p class="weui-media-box_desc">满{{ $item['coupon']->base }}可用，@if($item['coupon']->range==0)全场通用@endif @if($item['coupon']->range==1)指定分类@endif @if($item['coupon']->range==2)指定商品@endif</p>
								<p class="weui-media-box_desc">有效期：{{ substr($item->time_begin, 0, 10) }}-{{ substr($item->time_end, 0, 10) }}</p>
							</div>
						</a>
					</div>
					<!--div class="weui-media-box weui-media-box_text">
						1、优惠券有效期在规定的时间范围内，过期则无法使用；2、优惠券不能与部分团购商品及特价商品同时使用，在提交订单时系统有提示哪些不能使用优惠券；3、优惠券不能抵扣运费；
					</div-->
					
					@if ($item->status == 0)
						<div class="weui-media-box cut_line">
							<div class="border"></div>
							<div class="weui-cell-fl"></div>
							<div class="weui-cell-fr"></div>
						</div>
						<div class="weui-media-box link">
							<a href="javascript:;">立即使用</a>
						</div>
					@endif
				</div>
				@endforeach
			@endif
	    </div>
	</div>
 </div>

    @include(frontView('layout.nav'), ['tabIndex' => 4])
@endsection


@section('js')
    <script src="{{ asset('vendor/doT.min.js') }}"></script>

    <script type="text/template" id="template">
        @{{~it:value:index}}
        	<div class="weui_planel_item scroll-post @{{? value.status != 0 }} lose-effic uesed @{{?}}">

				@{{? value.status == 4 }}
					<div class="slide-toggle">
						<img  src="{{asset('images/cancel.png')}}" alt="">
					</div>
				@{{?}}
				@{{? value.status == 3 }}
					<div class="slide-toggle">
						<img  src="{{asset('images/guoqi.png')}}" alt="">
					</div>
				@{{?}}
				@{{? value.status == 2 }}
					<div class="slide-toggle">
						<img  src="{{asset('images/used.png')}}" alt="">
					</div>
				@{{?}}
				@{{? value.status == 1 }}
					<div class="slide-toggle">
						<img  src="{{asset('images/freeze.png')}}" alt="">
					</div>
				@{{?}}

				<div class="weui-panel_bd">
					<a href="javascript:;" class="weui-media-box weui-media-box_appmsg" style="align-items:flex-start;">
						@{{? value['coupon'].type == '打折' }}
						<div class="weui-media-box_hd">
							<div class="type">折扣券</div>
							<div class="sum"><span>@{{=value['coupon'].discount}}</span>折</div>
						</div>
						@{{?}}

						@{{? value['coupon'].type == '满减' }}
						<div class="weui-media-box_hd">
							<div class="type">满减券</div>
							<div class="sum"><span>@{{=value['coupon'].given}}</span>元</div>
						</div>
						@{{?}}

						<div class="weui-media-box_bd">
							<h4 class="weui-media-box_title">@{{=value['coupon'].name}}</h4>
							<p class="weui-media-box_desc">满@{{=value['coupon'].base}}可用，@{{? value['coupon'].range == 0 }} 全场通用@{{?}} @{{? value['coupon'].range == 1 }}指定分类@{{?}} @{{? value['coupon'].range == 2 }}指定商品 @{{?}}</p>
							<p class="weui-media-box_desc">有效期：@{{=value.time_begin}} - @{{=value.time_end}}</p>
						</div>
					</a>
				</div>

				

				@{{? value.status == 0 }}
				<div class="weui-media-box cut_line">
					<div class="border"></div>
					<div class="weui-cell-fl"></div>
					<div class="weui-cell-fr"></div>
				</div>
				<div class="weui-media-box link">
					<a href="javascript:;">立即使用</a>
				</div>
				@{{?}}

			</div>
        @{{~}}
    </script>

    <script type="text/javascript">

        $(document).ready(function(){
            //无限加载
            var fireEvent = true;
            var working = false;

            $(document).endlessScroll({

                bottomPixels: 250,

                fireDelay: 10,

                ceaseFire: function(){
                  if (!fireEvent) {
                    return true;
                  }
                },

                callback: function(p){

                  if(!fireEvent || working){return;}

                  working = true;

                  //加载函数
                  $.ajaxSetup({ 
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                  });
                  $.ajax({
                    url:"/ajax/coupons/{{ $type }}?skip=" + $('.scroll-post').length + "&take=18",
                    type:"GET",
                    success:function(data){
                      if (data.status_code != 0) {
                        return;
                      }

                      var coupons=data.data;

                      if (coupons.length == 0) {
                        fireEvent = false;
                        $('#scroll-container').append("<div id='loading-tips' style='padding: 15px; color: #999; font-size: 14px; text-align: center;'>别再扯了，已经没有了</div>");
                        return;
                      }
                      if (data.data.length) {
                      // 编译模板函数
                      var tempFn = doT.template( $('#template').html() );

                      // 使用模板函数生成HTML文本
                      var resultHTML = tempFn(data.data);

                      // 否则，直接替换list中的内容
                      $('#scroll-container').append(resultHTML);
                    } else {
                      
                    }
                    working = false;
                    }
                  });
                }
            });
        });
    </script>
@endsection