@extends('front.default.layout.base')

@section('css')
    <style>
      body{background-color: #fff;}
    </style>
@endsection

@section('content')
<form method="POST" action="/check">
  {{ csrf_field() }}
  @if (!empty($address))
    <input type="hidden" value="{{ $address->name}}" name="customer_name">
    <input type="hidden" value="{{ $address->phone}}" name="customer_phone">
    <input type="hidden" value="{{ getCitiesNameById($address->province) }}{{ getCitiesNameById($address->city) }}{{ getCitiesNameById($address->district) }}{{ $address->detail }}" name="customer_address">
  @endif
  
  <input type="hidden" value="{{ $freight }}" name="freight">
  <div id="check">
    @if (!empty($address))
      <div class="weui-panel weui-panel_access">
        <div class="weui-panel__hd">邮寄地址</div>
      </div>
      <div class="user-address">
        <img src="{{ asset('images/default/location.png') }}" class="address-icon">
        <div class="address-content">
            <h4 class="name">{{ $address->name }} {{ $address->phone }}</h4>
            <p class="address">{{ getCitiesNameById($address->province) }}{{ getCitiesNameById($address->city) }}{{ getCitiesNameById($address->district) }}{{ $address->detail }}</p>
        </div>
        <a class="select" href="/address/change?backupcheck=1">修改</a>
      </div>
      <input type="hidden" name="address_id" value="{{ $address->id }}">
    @else
      <div class="js_dialog" id="iosDialog2">
          <div class="weui-mask"></div>
          <div class="weui-dialog">
              <div class="weui-dialog__bd">您还未设置收货地址</div>
              <div class="weui-dialog__ft">
                  <a href="/address/add?backupcheck=2" class="weui-dialog__btn weui-dialog__btn_primary">现在去设置</a>
              </div>
          </div>
      </div>
    @endif
    
    <div class="check-products">
      @foreach($items as $item)
        @if ($item['type'] == 0)
          <div class="zcjy-product-check">
            <img src="{{ $item['product']->image }}" class="productImage">
            <div class="product-name">{{ $item['product']->name }}</div>
            <div class="remark"></div>
            <div class="price"> <span style="float: left;">¥{{ $item['realPrice'] }}</span> <span style="float: right; margin-right: 0.75rem;">x{{ $item['qty'] }}</span></div>
          </div>
        @else
          <div class="zcjy-product-check">
            <img src="{{ $item['spec']->image }}" class="productImage">
            <div class="product-name">{{ $item['product']->name }}</div>
            <div class="remark">规格：{{ $item['spec']->key_name }}</div>
            <div class="price"> <span style="float: left;">¥{{ $item['realPrice'] }}</span> <span style="float: right; margin-right: 0.75rem;">x{{ $item['qty']  }}</span></div>
          </div>
        @endif
      @endforeach
    </div>

    <input type="hidden" name="coupon_id" value="0">
    

    <div class="page__bd section-margin">
      <div class="weui-form-preview">
          <div class="weui-form-preview__hd">
              <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label">付款金额</label>
                  <em class="weui-form-preview__value">¥{{ $total }}</em>
              </div>
          </div>
      </div>
      <div class="weui-cell vux-x-textarea section-margin">
        <div class="weui-cell__hd"><!----> <!----> <!----></div> 
        <div class="weui-cell__bd">
          <textarea autocomplete="off" autocapitalize="off" autocorrect="off" spellcheck="false" placeholder="备注信息" rows="3" cols="30" maxlength="200" class="weui-textarea" name="remark"></textarea> 
          <!--div class="weui-textarea-counter"><span>0</span>/200</div-->
        </div>
      </div>
    </div>
  </div>
</form>

<div class="checkwrapper product-checker">
  <span style="margin-left: 0.75rem; font-size: 0.6rem;">实付款</span> <span class="price_final" id="total"> ¥ {{ $total }}</span>
  <a class="right-botton01" href="javascript:;" onclick="submit()">立即支付</a>
</div>

@endsection

@section('js')
  <script>
    function submit() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url:"/checknow?specPriceItemId={{ $item['spec'] == null ? 0 : $item['spec']->id }}&count={{ $item['qty'] }}&product_id={{ $item['product']->id }}&prom_type={{ $item['product']->prom_type }}&prom_id={{ $prom_id }}&join_team={{ $join_team }}&start_or_Join={{ $start_or_Join }}",
        type:"POST",
        data:$('form').serialize(),
        success: function(data) {
          if (data.code) {
            layer.open({
              content: data.message
              ,skin: 'msg'
              ,time: 2 //2秒后自动关闭
            });
          }else{
            window.location.href = '/order/'+data.message+'?show_pay=yes';
          }
        },
        error: function(data) {
            //提示失败消息

        },
      });
    }
  </script>
@endsection

