@extends('front.default.layout.base')

@section('css')
    <style>

    </style>
@endsection

@section('content')
  <div class="nav_tip">
    <div class="img">
      <a href="/usercenter"><i class="icon ion-ios-arrow-left"></i></a></div>
    <p class="titile">我的订单</p>
  </div>
  <div class="weui-tab">
    <div class="weui-navbar">
        <a class="weui-navbar__item @if($type == 1) weui-bar__item_on @endif" href="/orders/1">
            <span>全部</span>
        </a>
        <a class="weui-navbar__item @if($type == 2) weui-bar__item_on @endif" href="/orders/2">
            <span>待付款</span>
        </a>
        <a class="weui-navbar__item @if($type == 3) weui-bar__item_on @endif" href="/orders/3">
            <span>待发货</span>
        </a>
        <a class="weui-navbar__item @if($type == 4) weui-bar__item_on @endif" href="/orders/4">
            <span>待收货</span>
        </a>
        <a class="weui-navbar__item @if($type == 5) weui-bar__item_on @endif" href="/orders/5">
            <span>已完成</span>
        </a>
    </div>
    <div class="weui-tab__panel">

    </div>
  </div>
  <div class="flow-default scroll-container" id="order-box">
    @foreach($orders as $order)
      <div class="scroll-post">
        <a class="order-item" href="/order/{{$order->id}}">
          <div class="order-item-title">
            <span class="title">购买时间 {{$order->created_at}}</span> <span class="status">{{$order->status}}</span>
          </div>
          @foreach($order->items as $item)
            <div class="zcjy-product-check">
              <img src="{{ $item->pic }}" class="productImage" onerror="this.src= '/images/default.jpg' ">
              <div class="product-name">{{ $item->name }}</div>
              <div class="remark">{{ $item->unit}}</div>
              <div class="price"> <span style="float: left;">¥{{$item->price}}</span> <span style="float: right; margin-right: 0.75rem;">x{{ $item->count }}</span></div>
            </div>
          @endforeach
          <div class="total">共<span>{{$order->count}}</span>件商品，合计<span>￥{{$order->price}}</span>（含运费¥0.00）</div>
        </a>

        <!-- 待付款 -->
        @if($order->status == '待付款')
        <div class="operation weui-cell">
          <div class="weui-cell__bd"></div>
          <a class="weui-cell__ft" onclick="cancelOrder({{ $order->id }})">取消订单</a>
          <a class="weui-cell__ft" href="/order/{{ $order->id }}?show_pay=yes">去付款</a>
        </div>
        @endif

        <!-- 待发货 -->
        @if($order->status == '待发货' && funcOpenCache('FUNC_ORDER_CANCEL'))
        <div class="operation weui-cell">
          <div class="weui-cell__bd"></div>
          <a class="weui-cell__ft" onclick="cancelOrder({{ $order->id }})">取消订单</a>
        </div>
        @endif

        <!-- 待收货 -->
        @if($order->status == '待收货')
        <div class="operation weui-cell">
          <div class="weui-cell__bd"></div>      
          <div class="weui-cell__ft" onclick="confirmOrder({{ $order->id }})">确认收货</div>
        </div>
        @endif
      </div>
    @endforeach
  </div>

  @include(frontView('layout.nav'), ['tabIndex' => 4])

@endsection

@section('js')

  <script src="{{ asset('vendor/doT.min.js') }}"></script>

  <script type="text/template" id="template">
    @{{~it:value:index}}
      <div class="scroll-post">
        <a class="order-item" href="/order/@{{=value.id}}">
          <div class="order-item-title">
            <span class="title">购买时间 @{{=value.created_at}}</span> <span class="status">@{{=value.status}}</span>
          </div>

          @{{~value.items:value2:index2}}
            <div class="zcjy-product-check">
              <img src="@{{=value2.pic}}" class="productImage" onerror="this.src= '/images/default.jpg' ">
              <div class="product-name">@{{=value2.name}}</div>
              <div class="remark">@{{=value2.unit}}</div>
              <div class="price"> <span style="float: left;">¥@{{=value2.price}}</span> <span style="float: right; margin-right: 0.75rem;">x@{{=value2.count}}</span></div>
            </div>
          @{{~}}

          <div class="total">共<span>@{{=value.count}}</span>件商品，合计<span>￥@{{=value.price}}</span>（含运费¥0.00）</div>
        </a>

        <!-- 待付款 -->
        @{{? value.status == '待付款' }}
        <div class="operation weui-cell">
          <div class="weui-cell__bd"></div>      
          <a class="weui-cell__ft" onclick="cancelOrder(@{{=value.id}})">取消订单</a>
          <a class="weui-cell__ft" href="/order/@{{=value.id}}?show_pay=yes">去付款</a>
        </div>
        @{{?}}

        <!-- 待付款 -->
        @{{? value.status == '待发货' }}
        @if(funcOpenCache('FUNC_ORDER_CANCEL'))
          <div class="operation weui-cell">
            <div class="weui-cell__bd"></div>      
            <a class="weui-cell__ft" onclick="cancelOrder(@{{=value.id}})">取消订单</a>
          </div>
        @endif
        @{{?}}

        <!-- 待收货 -->
        @{{? value.status == '待收货' }}
        <div class="operation weui-cell">
          <div class="weui-cell__bd"></div>      
          <div class="weui-cell__ft" onclick="confirmOrder(@{{=value.id}})">确认收货</div>
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
                url:"/ajax/orders?skip=" + $('.scroll-post').length + "&take=18&type={{ $type }}",
                type:"GET",
                success:function(data){
                  if (data.status_code != 0) {
                    return;
                  }

                  var orders=data.data;
                  if (orders.length == 0) {
                    fireEvent = false;
                    $('#order-box').append("<div id='loading-tips' style='padding: 15px; color: #999; font-size: 14px; text-align: center;'>别再扯了，已经没有了</div>");
                    return;
                  }
                  if (data.data.length) {
                  // 编译模板函数
                  var tempFn = doT.template( $('#template').html() );

                  // 使用模板函数生成HTML文本
                  var resultHTML = tempFn(data.data);

                  // 否则，直接替换list中的内容
                  $('#order-box').append(resultHTML);
                } else {
                  
                }
                working = false;
                }
              });
            }
        });
    });

    // $('.scroll-container').infiniteScroll({
    //   // options
    //   path: "a[rel='next']",
    //   append: '.scroll-post',
    //   history: false,
    // });

    function cancelOrder(order_id) {
      layer.open({
        content: '确认取消订单吗？'
        ,btn: ['确认', '取消']
        ,yes: function(index){
          layer.close(index);
          window.location.href = '/order/'+order_id+'?cancel_order=yes';
        }
      });
    }

    function confirmOrder(order_id) {
      layer.open({
        content: '确认订单吗？'
        ,btn: ['确认', '取消']
        ,yes: function(index){
          layer.close(index);
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              url:"/confirm/order/"+order_id,
              type:"GET",
              data:'',
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
                  location.reload();
              },
          });
        }
      });
    }
  </script>
@endsection