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
	<div class="withdraw-sum weui-cells">
	
		<div class="weui-cell weui-cell_access withdraw-bank withdraw-bank-one">
			@if(!empty($first_card))
			<div class="weui-cell__hd ">
				<img src="{{ getBankImgByName($first_card->name) }}" alt="">
			</div>
			<div class="weui-cell__bd">
				<p class="ft-l">{!! $first_card->name !!}</p>
				<p class="ft-s">{!! $first_card->subcardno !!} {!! $first_card->cardType !!}</p>
			</div>
			<div class="weui-cell__ft"></div>
			@else
			请添加银行卡
			@endif
		</div>
	
		<div class="weui-cell">
			<div class="intr">提现金额<span> ( 提现最低<span id="min_price">{!! $min_price !!}</span>元起，每日限额{!! $max_num !!}笔 ) </span>:</div>
		</div>
		<div class="weui-cell">
			<div class="money-num weui-cell__bd"><span>¥</span><input type="text" name="bank_money_num"></div>
		</div>
		<div class="weui-cell withdraw-apply-info">
			<div class="weui-cell__hd">可用余额：<span id="can_use_money">{!! $user->user_money !!}</span>元</div>
			<div class="weui-cell__bd" id="all_with_draw">全部提现</div>
		</div>
		<div class="page__bd page__bd_spacing">
			<a href="javascript:;" class="weui-btn" id="enterWithDraw" data-bankid="@if(!empty($first_card)){!! $first_card->id !!}@endif">确认提现</a>
		</div>
	</div>

<div id="all_bank_list" style="display: none;">
<div class="withdraw-sum weui-cells">

	@foreach($bank_list as $item)
	<div class="weui-cell  withdraw-bank withdraw-bank-list" onclick="chooseOne(this)"  data-id="{!! $item->id !!}">
		<div class="weui-cell__hd ">
			<img src="{{ getBankImgByName($item->name) }}" alt="">
		</div>
		<div class="weui-cell__bd">
			<p class="ft-l">{!! $item->name !!}</p>
			<p class="ft-s">{!! $item->subcardno !!} {!! $item->cardType !!}</p>
		</div>
		<div class="weui-cell__ft">
			<i class="weui-icon-success-no-circle" style="display: none"></i>
		</div>
	</div>
	@endforeach

	<div class="page__bd page__bd_spacing">
		<a href="/usercenter/bankcards/add" class="weui-btn">+添加新卡片</a>
	</div>
</div>
</div>
@endsection


@section('js')
<script type="text/javascript">
	$(function(){
		//弹出银行卡列表选择
		$('.withdraw-bank-one').click(function(){
			  layer.open({
				    type: 1
				    ,content: $('#all_bank_list').html()
				    ,anim: 'up'
				    ,style: 'position:fixed; bottom:0; left:0; width: 100%; height: 200px; padding:10px 0; border:none;'
				  });
		});
		//确认提现
		$('#enterWithDraw').click(function(){
			var money_num=parseInt($('input[name=bank_money_num]').val());
			var bank_id=parseInt($(this).data('bankid'));
			var max_money=parseInt($('#can_use_money').text());
			var min_price=parseInt($('#min_price').text());

			if(money_num==0 || money_num==''){
			  		layer.open({
                      content:'请输入提现金额'
                      ,skin: 'msg'
                      ,time: 2 
                    });
                    return false;
			}
			if(money_num>max_money){
					layer.open({
                      content:'提现金额不能大于余额'
                      ,skin: 'msg'
                      ,time: 2 
                    });
                    return false;
			}
			if(money_num<min_price){
					layer.open({
                      content:'提现金额不能小于'+min_price+'元'
                      ,skin: 'msg'
                      ,time: 2 
                    });
                    return false;
			}
		  $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              url:"/api/withdraw_account",
              type:"POST",
              data:'price='+money_num+'&bank_id='+bank_id,
              success:function(data){
              	if(data.code==0){
              		layer.open({
                      content:data.message
                      ,skin: 'msg'
                      ,time: 2 
                    });
                    setTimeout(function(){
                    	 location.href=data.url;
                    },1000);
              	}else{
              			layer.open({
                      content:data.message
                      ,skin: 'msg'
                      ,time: 2 
                    });
              	}
              }
          });
		});
		//全部提现
		$('#all_with_draw').click(function(){
			$('input[name=bank_money_num]').val($('#can_use_money').text());
		});
	});

	//多张银行卡列表选择
	function chooseOne(obj){
		var bankid=$(obj).data('id');
		$('.withdraw-bank-list').find('i').hide();
		$(obj).find('i').show();
		var bank_html=$(obj).html();
		setTimeout(function(){
			layer.closeAll();
			$('.withdraw-bank-one').html(bank_html.replace('weui-icon-success-no-circle','weui-icon-success-no-circles'));
			$('#enterWithDraw').data('bankid',bankid);
			//console.log($('#enterWithDraw').data('bankid'));
		},500);
	}
</script>  
@endsection