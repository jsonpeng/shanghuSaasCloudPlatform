@extends('front.default.layout.base')

@section('css')
<style>.weui-grid{width: 25%;}</style>
@endsection

@section('content')
<div class="nav_tip">
  <div class="img">
    <a href="javascript:history.back(-1)"><i class="icon ion-ios-arrow-left"></i></a></div>
  <p class="titile">添加银行卡</p>
</div>
<form >
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <label class="weui-label">银行卡名称</label>
            </div>
            <div class="weui-cell__bd">
                @if(!empty($bankinfo))
                <select class="weui-select pl0" name="name">
                @foreach($bankinfo as $item)
                <option value="{!! $item->name !!}">{!! $item->name !!}</option>
                @endforeach
                </select>
                @else
                无
                @endif
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <label class="weui-label">银行卡类型</label>
            </div>
            <div class="weui-cell__bd">
                <select class="weui-select pl0" id="card_type" name="type">
                    <option value="0" selected>储蓄卡</option>
                    <option value="1">信用卡</option>
                </select>
            </div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <label class="weui-label">支行</label>
            </div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="text" placeholder="支行" name="bank_name" maxlength="100"></div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <label class="weui-label">用户名</label>
            </div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="text" placeholder="用户名" name="user_name" maxlength="16"></div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__hd">
                <label class="weui-label">账号</label>
            </div>
            <div class="weui-cell__bd">
                <input class="weui-input" type="text" placeholder="账号" name="count" maxlength="128"></div>
        </div>
    <div class="weui-cell">
        <div class="weui-cell__hd">
            <label class="weui-label">短信提醒手机号</label>
        </div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="text" placeholder="短信提醒手机号" name="mobile" maxlength="128"></div>
    </div>
    </div>

<div class="page">
    <div class="page__bd page__bd_spacing">
        <button class="weui-btn weui-btn_primary" type="button" onclick="saveForm()">保存</button>
        <a href="javascript:history.back(-1)" class="weui-btn weui-btn_default">返回</a>
    </div>
</div>
</form>
@endsection

@section('js')
<script type="text/javascript">
function saveForm(){
    var tpye=$('#card_type').val();
    if($('input[name=bank_name]').val()!='' && $('input[name=user_name]').val()!='' && $('input[name=count]').val()!=''){
            var reg_count = /^\d{19}$/g; 
            if(tpye==1){
                reg_count= /^\d{16}$/g; 
                console.log('选择了信用卡');
            }
            if(!reg_count.test($('input[name=count]').val())){
                  layer.open({
                    content: '银行卡格式不正确'
                    ,skin: 'msg'
                    ,time: 2 
                  });
                  return false;
            }
            // var reg_mobile = /^1[3|4|5|7|8][0-9]{9}$/;
            // if(!reg_mobile.test($('input[name=mobile]').val())){
            //           layer.open({
            //         content: '手机号格式不正确'
            //         ,skin: 'msg'
            //         ,time: 2 
            //       }); 
            //       return false; 
            // }
    $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
    $.ajax({
                url:'/api/bank_info/save',
                type:'post',
                data:$('form').serialize(),
                success:function(data){
                  if(data.code==0){
                        layer.open({
                    content: '保存成功'
                    ,skin: 'msg'
                    ,time: 2 
                  });
                  location.href=data.message;
                  }else{
                    layer.open({
                    content: '参数填写不完整'
                    ,skin: 'msg'
                    ,time: 2 
                  });
                  return false;
                  }
                }
              });
        }else{
                  layer.open({
                    content: '参数填写不完整'
                    ,skin: 'msg'
                    ,time: 2 
                  });
        }
}
</script>
@endsection