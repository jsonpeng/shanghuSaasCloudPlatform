@extends('front.default.layout.base')

@section('css')
    <style>
      .btn-no{display: none;}
    </style>
@endsection

@section('content')
  <div class="nav_tip">
    <div class="img">
      <a href="javascript:history.back(-1)"><i class="icon ion-ios-arrow-left"></i></a></div>
    <p class="titile">购物车</p>
    <!--div class="userSet">
        <a href="javascript:;">
              <img src="{{ asset('images/dustbin.png') }}" alt="">
        </a>
    </div-->
  </div>
  <?php 
    $userLevel = $user->level;
  ?>
  @if (!empty($userLevel) && $userLevel->discount < 100)
    <div class="weui-cell rollTip">
      <img src="{{ asset('images/tips.png') }}" alt=""><span>尊敬的白银会员您好！现在购物您可享受{{ $userLevel->discount }}折优惠！</span>
    </div>
  @endif
  
  @if (getSettingValueByKeyCache('freight_free_limit'))
    <div class="weui-cell rollTip">
      <img src="{{ asset('images/tips.png') }}" alt=""><span>现全场购物满{{ getSettingValueByKeyCache('freight_free_limit') }}元，享受免邮费优惠</span>
    </div>
  @endif
  
  <div id="cart">
    @if ($items->count())
      <div style="padding-bottom: 2rem; height: 100%; position: relative;">
        @foreach($items as $item)
          <?php
            $product = $item->product;
          ?>
          @if ($item['type'] == 0)
            <div class="zcjy-product-cart">
              <div class="productImage">
                  <img  src="{{ $product->image }}">
              </div>
              <i class="weui-icon-success checkingbutton2" id="cancel_{{ $item->id }}" onclick="cancel('{{ $item->id }}')"></i>
              <i class="weui-icon-circle checkingbutton2" style="display: none;" id="select_{{ $item->id }}" onclick="select({{ $product->id }}, 0, '{{ $item->id }}')"></i>
              <div class="proudct-info-wrapper">
                <div class="product-name">{{ $product->name }}</div>
                <!--div class="remark oneline">规格: {{ $item->name }}</div-->
                <div class="price oneline" >¥{{ $item->realPrice }}</div>
                <div class="tr cart-item">
                  <div class="counter">
                    <i class="fa fa-minus" style="float:left;" onclick="cartdel({{ $product->id }}, 0, '{{$item->id}}')"></i>
                    <input type="number" id="value_{{$product->id}}_0" value="{{$item->qty}}">
                    <i class="fa fa-plus" style="float:left;" onclick="cartadd({{ $product->id }}, 0, '{{ $item->id }}')"></i>
                  </div>
                </div>
              </div>
            </div>
          @else
            <?php
              $spec = $item->spec;
            ?>
            <div class="zcjy-product-cart">
              <div class="productImage">
                  <img  src="{{ $spec->image }}">
              </div>
              <i class="weui-icon-success checkingbutton2" id="cancel_{{ $item->id }}" onclick="cancel('{{ $item->id }}')"></i>
              <i class="weui-icon-circle checkingbutton2" style="display: none;" id="select_{{ $item->id }}" onclick="select({{ $product->id }}, {{ $item->spec->id }}, '{{ $item->id }}')"></i>

              <div class="proudct-info-wrapper">
                <div class="product-name ">{{ $product->name }}</div>
                <div class="remark oneline">规格: {{ $spec->key_name }}</div>
                <div class="price oneline" >价格: {{ $item->realPrice }}</div>
                <div class="tr cart-item">
                  <div class="counter">
                    <i class="fa fa-minus" style="float:left;" onclick="cartdel({{ $product->id }}, {{ $spec->id }}, '{{$item->id}}')"></i>
                    <input type="number" id="value_{{ $product->id }}_{{ $spec->id }}" value="{{$item->qty}}">
                    <i class="fa fa-plus" style="float:left;" onclick="cartadd({{ $product->id }}, {{ $spec->id }}, '{{ $item->id }}')"></i>
                  </div>
                </div>
              </div>
            </div>
          @endif
        @endforeach
        
        <div class="checkwrapper product-checker">
          <span style="width: 0.5rem; display: inline-block;"></span><span id="count">{{ $count }}</span> 件商品, 总计 <span class="price_final" id="total"> ¥ {{ $total }}元</span>
          <a class="right-botton01" href="/check">结算<span></span></a>
        </div>
      </div>
    @else
      <div class="empty">
          <div class="no-shoppingcart">
            <img src="{{ asset('images/emptycart.png') }}">
            <div class="title">购物车是空的~</div>
            <div class="des">赶快去选购商品吧！</div>
          </div>
          

          <div class="checkwrapper product-checker">
            <a class="right-botton01"  style="width: 100%;" href="/category">马上选购</a>
          </div>
      </div>
    @endif
    
    
  </div>
@endsection


@section('js')
    <script src="{{ asset('vendor/underscore-min.js') }}"></script>
    <script>

      var submit = _.debounce(updateCart, 300);

      function cartdel(productId, specPriceId, id) {
        inputEle = $('#value_'+productId+'_'+specPriceId);
        count = inputEle.val();
        --count;
        if (count < 1) {count = 1; return;}
        inputEle.val(count);
        submit(id, count);
      }
      function cartadd(productId, specPriceId, id) {
        inputEle = $('#value_'+productId+'_'+specPriceId);
        count = inputEle.val();
        ++count;
        if (count > 99) {count = 99; return;}
        inputEle.val(count);
        submit(id, count);
      }
      function cancel(id) {
        $('#cancel_'+id).hide();
        $('#select_'+id).show();
        deleteCart(id);
      }
      function select(productId, specPriceId, id) {
        $('#cancel_'+id).show();
        $('#select_'+id).hide();
        inputEle = $('#value_'+productId+'_'+specPriceId);
        addCart(productId, specPriceId, inputEle.val());
      }

      function updateCart(id, count) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"/api/cart/update",
            type:"GET",
            data:'cart_id='+id+'&count='+count,
            success: function(data) {
              if (data.code) {
                layer.open({
                  content: data.message
                  ,skin: 'msg'
                  ,time: 2 //2秒后自动关闭
                });
              }else{
                $('#count').text(data.message.count);
                $('#total').text('¥ ' + data.message.total + '元');
                $('#value_'+id).val(data.message.qty);
                if (data.message.qty < count) {
                  layer.open({
                    content: '库存不足'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                  });
                }
              }
            },
            error: function(data) {
                //提示失败消息

            },
        });
        
      }

      function addCart(productId, specPriceId, count) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"/api/cart/add",
            type:"GET",
            data:'product_id='+productId+'&specPriceItemId='+specPriceId+'&count='+count,
            success: function(data) {
              if (data.code) {
                layer.open({
                  content: data.message
                  ,skin: 'msg'
                  ,time: 2 //2秒后自动关闭
                });
              }else{
                $('#value_'+productId+'_'+specPriceId).val(data.message.qty);
                $('#count').text(data.message.count);
                $('#total').text('¥ ' + data.message.total + '元');
              }
            },
            error: function(data) {
                //提示失败消息

            },
        });
        
      }

      function deleteCart(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url:"/api/cart/delete",
            type:"GET",
            data:'cart_id='+id,
            success: function(data) {
              if (data.code) {
                layer.open({
                  content: data.message
                  ,skin: 'msg'
                  ,time: 2 //2秒后自动关闭
                });
              }else{
                $('#count').text(data.message.count);
                $('#total').text('¥ ' + data.message.total + '元');
              }
            },
            error: function(data) {
                //提示失败消息

            },
        });
        
      }
    </script>
@endsection

