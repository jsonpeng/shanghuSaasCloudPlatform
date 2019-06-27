@extends('front.default.layout.base')

@section('css')
	<link rel="stylesheet" href="{{ asset('vendor/progress/main.css') }}">
    <style>

    </style>
@endsection


@section('content')
	<div class="nav_tip">
	  <div class="img">
	    <a href="javascript:history.back(-1)"><i class="icon ion-ios-arrow-left"></i></a></div>
	  <p class="titile">服务单详情</p>
	  <!--div class="userSet">
	      <a href="javascript:;">
	            <img src="{{ asset('images/default/more.png') }}" alt="">
	      </a>
	  </div>
	</div-->
  	<div class="progress-bar-wrapper"></div>
  	<div class="refundstatus">{{ $orderRefund->refundStatus }}</div>
   	<div class="zcjy-product-check">
		<img src="{{ $orderRefund->item->pic }}" class="productImage" onerror="this.src= '/images/default.jpg' ">
		<div class="product-name">{{ $orderRefund->item->name }}</div>
		<div class="remark">{{ $orderRefund->item->unit}}</div>
		<div class="price"> <span style="float: left;">¥{{$orderRefund->item->price}}</span> <span style="float: right; margin-right: 0.75rem;">x{{ $orderRefund->count }}</span></div>
	</div>
    
    @if('等待买家发货' == $orderRefund->refundStatus)
    	<div onclick="delivery()">去发货</div>
    @endif

    @if(0 == $orderRefund->status || 1 == $orderRefund->status)
    	<div onclick="cancel()" class="cancelrefund"><span>取消售后</span></div>
    @endif
    
	<div>
        <div class="weui-mask" id="iosMask" style="display: none"></div>
        <div class="weui-actionsheet" id="iosActionsheet">
            <div class="weui-actionsheet__title">
                <p class="weui-actionsheet__title-text">请输入快递信息</p>
            </div>
            <div class="weui-actionsheet__menu">
            	<form id="delivery_form">
                <div class="weui-actionsheet__cell"><span style="width: 100px; display: inline-block;">快递公司</span> <input type="text" name="return_delivery_company"></div>
                <div class="weui-actionsheet__cell"><span style="width: 100px; display: inline-block;">快递单号</span> <input type="text" name="return_delivery_no"></div>
                <div class="weui-actionsheet__cell"><span style="width: 100px; display: inline-block;">邮费</span> <input type="text" name="return_delivery_money"></div>
                </form>
            </div>
            <div class="weui-actionsheet__action">
                <div class="weui-actionsheet__cell" id="iosActionsheetCancel">提交</div>
            </div>
        </div>
    </div>
@endsection

@section('js')
	<script src="{{ asset('vendor/progress/progress-bar.js') }}"></script>
	<script>
		ProgressBar.singleStepAnimation = 300;
		ProgressBar.init(
		  [ @foreach ($progress['list'] as $element)
		  	'{{ $element }}',
		  @endforeach ],
		  '{!! $progress['cur'] !!}',
		  'progress-bar-wrapper' // created this optional parameter for container name (otherwise default container created)
		);

		function delivery() {
			showActionSheet();
		}

		var $iosActionsheet = $('#iosActionsheet');
        var $iosMask = $('#iosMask');

        function hideActionSheet() {
            $iosActionsheet.removeClass('weui-actionsheet_toggle');
            $iosMask.fadeOut(200);
        }

        function showActionSheet() {
            $iosActionsheet.addClass('weui-actionsheet_toggle');
            $iosMask.fadeIn(200);
        }

        function submitDelivery() {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url:"/refund/changeDelivery/{{ $orderRefund->id }}",
				type:"GET",
				data: $('#delivery_form').serialize(),
				success: function(data) {
				if (data.code) {
					layer.open({
					    content: data.message
					    ,skin: 'msg'
					    ,time: 2 //2秒后自动关闭
					 });
				}else{
					location.reload();
				}
				},
				error: function(data) {
					//提示失败消息
				},
			});
            
        }

        $iosMask.on('click', hideActionSheet);
        $('#iosActionsheetCancel').on('click', function(){
        	hideActionSheet();
        	submitDelivery();
        });
        $("#showIOSActionSheet").on("click", function(){
            showActionSheet();
        });

        function cancel() {
        	$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url:"/refund/cancel/{{ $orderRefund->id }}",
				type:"GET",
				data: '',
				success: function(data) {
				if (data.code) {
					layer.open({
					    content: data.message
					    ,skin: 'msg'
					    ,time: 2 //2秒后自动关闭
					 });
				}else{
					location.reload();
				}
				},
				error: function(data) {
					//提示失败消息
				},
			});
        }
	</script>

@endsection