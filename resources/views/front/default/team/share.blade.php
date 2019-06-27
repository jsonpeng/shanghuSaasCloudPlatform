@extends('front.default.layout.base')

@section('css')
    <style>
    </style>
@endsection

@section('content')
    <div class="pay-attention weui-cell">
    	<div class="weui-cell__hd">
    		<img src="{{ asset('images/bank1.png') }}" alt="">
    	</div>
    	<div class="weui-cell__bd">上百种免费商品限量速抢</div>
    	<div class="weui-cell__ft">
    		<a href="javascript:;">立即关注</a>
    	</div>
    </div>

    @foreach ($orderItems as $element)
        <div class="zcjy-product-check">
          <div class="productImage">
            <img src="{{ $element->image }}" >
          </div>
          <div class="product-name">{{ $element->name }}</div>
          <div class="remark">{{ $element->spec_keyname }}</div>
          <div class="price"> <span style="float: left;">¥{{ $element->price }}</span> <span style="float: right; margin-right: 0.75rem;">x{{ $element->count }}</span></div>
        </div>
    @endforeach
    
    <div class="weui-cell promise-list">
        @foreach ($words as $element)
            <div class="promise-item"><i class="icon ion-ios-checkmark-outline"></i>{{ $element->name }}</div>
        @endforeach
    </div>
    <div class="share-bill">
        @if ($teamFound->join_num < $teamFound->need_mem)
            <div class="title">
                <p><i class="icon ion-person-stalker"></i>拼单未满，还差<span class="num">{{ $teamFound->need_mem - $teamFound->join_num }}</span>人，剩余<span class="time"><i>00</i>:<i>00</i>:<i>00</i></span></p>
            </div>
            <div class="partner">
                <div class="partner-item active">
                    <span class="label">拼主</span>
                    <img src="{{ $teamFound->head_pic }}" alt="">
                </div>
                @foreach ($teamFollows as $element)
                    <div class="partner-item ">
                        <img src="{{ $element->head_pic }}" alt="">
                    </div>
                @endforeach
                
                <div class="partner-item empty">
                    <i class="icon ion-help"></i>
                </div>
            </div>
            <a href="/product/28?start_or_Join=1&join_team={{ $teamFound->id }}" class="weui-btn share-join">立即参与拼单</a>
        @else
            <div class="title">
                <p><i class="icon ion-person-stalker"></i>该团人员已满</p>
            </div>
            <div class="partner">
                <div class="partner-item active">
                    <span class="label">拼主</span>
                    <img src="{{ $teamFound->head_pic }}" alt="">
                </div>
                @foreach ($teamFollows as $element)
                    <div class="partner-item ">
                        <img src="{{ $element->head_pic }}" alt="">
                    </div>
                @endforeach
            </div>
            <div class="other-share">
                <p>试试参与别的团吧</p>
            </div>
            <div class="other-share-list">
                <div class="other-share-item weui-cell">
                    <div class="weui-cell__hd">
                        <div class="img">
                            <img src="{{ asset('images/bank1.png') }}" alt="">
                        </div>
                        <span class="user-name">爱我的你122</span>
                    </div>
                    <div class="weui-cell__bd">
                        <p>还差<span class="num">1</span>人拼成</p>
                        <div class="last-time">
                            剩余 <i>23</i>:<i>58</i>:<i>12</i>
                        </div>
                    </div>
                    <div class="weui-cell__ft">
                        <a href="">去拼单</a>
                    </div>
                </div>
            </div>
        @endif
    	
    	
    	<div class="tips weui-cell">
    		<div class="weui-cell__hd">拼单须知</div>
    		<div class="weui-cell__bd">好友拼单·人满发货·人不满退款</div>
    	</div>
    </div>
<!-- 	点击关注弹出层 -->
    <div class="alert-cover">
    	<div class="content">
    		<a href="javascript:;" class="close-btn"><i class="icon ion-ios-close-empty"></i></a>
    		<p class="title">长按指纹识别二维码，关注我们</p>
    		<p class="info">关注后继续购买，才能接收发货通知</p>
    		<div class="qrcode-list">
    			<div class="qrcode">
    				<img src="{{ asset('images/default/QRcode.png') }}" alt="" >
    			</div>
    			<div class="print">
    				<img src="{{ asset('images/default/print.png') }}" alt="">
    			</div>

    		</div>
    	</div>
    </div>
@endsection


@section('js')
   <script>
   		$('.pay-attention a').on('click', function(event) {
   			event.preventDefault();
   			/* Act on the event */
   			$('.alert-cover').css({'visibility':'visible'});
   		});
   		$('.alert-cover .close-btn').click(function(event) {
   			/* Act on the event */
   			$('.alert-cover').css({'visibility':'hidden'});
   		});

        function joinTeam() {
            window.location.href="/checknow?specPriceItemId="+specPriceItemId+'&count='+count+'&product_id='+product_id+'&prom_type='+prom_type+'&prom_id='+prom_id+'&join_team='+join_team+'&start_or_Join='+startOrJoin;
        }
   </script>
@endsection
