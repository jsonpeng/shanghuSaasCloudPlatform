@extends('front.default.layout.base')

@section('css')
<style>.weui-grid{width: 25%;}</style>
@endsection

@section('content')
<div class="nav_tip">
  <div class="img">
    <a href="javascript:history.back(-1)"><i class="icon ion-ios-arrow-left"></i></a></div>
  <p class="titile">银行卡列表</p>
  <!--div class="userSet">
      <a href="javascript:;">
            <img src="{{ asset('images/default/more.png') }}" alt="">
      </a>
  </div-->
</div>
<div class="bankcard">
	@foreach($bankcards as $item)
	<a class="bc-1" href="/usercenter/bankcards/edit/{!! $item->id !!}">
		<div class="card weui-media-box weui-media-box_appmsg">
			<div class="weui-media-box__hd">
				<img src="{{ getBankImgByName($item->name) }}" class="weui-media-box__thumb" alt=""></div>
			<div class="weui-media-box__bd">
				<h4 class="weui-media-box__title">{!! $item->name !!}</h4>
				<p class="weui-media-box__desc">{!! $item->cardType !!}</p>
			</div>
		</div>
		<div class="weui-media-box weui-media-box_desc">
			<p class="cardnum">
				<span class="points">····</span>
				<span class="points">····</span>
				<span class="points">····</span>
				{!! $item->subcardno !!}
			</p>
		</div>
	</a>
	@endforeach

	<div class="add-card">
		<a href="/usercenter/bankcards/add" >+ 添加新卡片</a>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript">
  $('.add-card-func').click(function(){
	      $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              url:"/api/ajax_get_bank_info",
              type:"POST",
              success:function(data){
              		if(data.code==0){
      			    	var html='';
      			    	bankinfo=data.message;
		                for(var i=0;i<bankinfo.length;i++){
		                    html +='<option value="'+bankinfo[i].name+'">'+bankinfo[i].name+'</option>';
		                }
		                console.log(html);
                        layer.open({
						    type: 1,
						    content: '<form ><div class="weui-cells weui-cells_form"><div class="weui-cell"><div class="weui-cell__hd"><label class="weui-label">银行卡名称</label></div><div class="weui-cell__bd"><select class="weui-cells weui-cells_radio" name="name">'+html+'</select></div></div><div class="weui-cell"><div class="weui-cell__hd"><label class="weui-label">银行卡类型</label></div><div class="weui-cell__bd"><select class="weui-cells weui-cells_radio" name="type"><option value="0">储蓄卡</option><option value="1">信用卡</option></select></div></div><div class="weui-cell"><div class="weui-cell__hd"><label class="weui-label">支行</label></div><div class="weui-cell__bd"><input class="weui-input" type="text" placeholder="支行" name="bank_name" maxlength="10"></div></div><div class="weui-cell"><div class="weui-cell__hd"><label class="weui-label">用户名</label></div><div class="weui-cell__bd"><input class="weui-input" type="text" placeholder="用户名" name="user_name" maxlength="11"></div></div><div class="weui-cell"><div class="weui-cell__hd"><label class="weui-label">账号</label></div><div class="weui-cell__bd"><input class="weui-input" type="text" placeholder="账号" name="count" maxlength="128"></div></div></div><div class="weui-cell"><div class="weui-cell__hd"><label class="weui-label">短信提醒手机号</label></div><div class="weui-cell__bd"><input class="weui-input" type="text" placeholder="短信提醒手机号" name="mobile" maxlength="128"></div></div></div><div class="page"><div class="page__bd page__bd_spacing"><button class="weui-btn weui-btn_primary" type="button" onclick="saveForm()">保存</button> <a href="javascript:layer.closeAll()" class="weui-btn weui-btn_default">返回</a></div></div></form>'
						    ,anim: 'up'
						    ,style: 'position:fixed; bottom:0; left:0; width: 100%; height:auto; padding:10px 0; border:none;'
						  });
              		}
              }
          });

});
/*
$('.bc-1').click(function(){
  var id=$(this).data('id');
  var that=this;
   layer.open({
    content: '确定要删除改银行卡吗'
    ,btn: ['删除', '取消']
    ,skin: 'footer'
    ,yes: function(index){
    $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
    $.ajax({
                url:'/api/bank_info/'+id+'/del',
                type:'post',
                success:function(data){
                  if(data.code==0){
                    layer.open({
                    content: '删除成功'
                    ,skin: 'msg'
                    ,time: 2 
                  });
                    $(that).remove();
                  }else{
                          layer.open({
                    content: '未知错误'
                    ,skin: 'msg'
                    ,time: 2 
                  });
                  }

                }
              });
        }
  });
});
*/
</script>
@endsection