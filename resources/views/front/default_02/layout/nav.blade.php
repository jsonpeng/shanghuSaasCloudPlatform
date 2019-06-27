<div class="weui-tabbar" id="weui-tabbar">
    <a href="/" class="weui-tabbar__item @if($tabIndex == 1) weui-bar__item_on @endif">
{{--         <img src="{{ asset('images/default/index/index.png') }}" alt="" class="weui-tabbar__icon">
        <img src="{{ asset('images/default/index/indexdefult.png') }}" alt="" class="weui-tabbar__icon "> --}}
        <i class="icon ion-home"></i>
        <p class="weui-tabbar__label">首页</p>
    </a>
    <a href="/category" class="weui-tabbar__item @if($tabIndex == 2) weui-bar__item_on @endif">
{{--         <img src="{{ asset('images/default/index/start.png') }}" alt="" class="weui-tabbar__icon">
        <img src="{{ asset('images/default/index/startdefult.png') }}" alt="" class="weui-tabbar__icon"> --}}
        <i class="icon ion-android-star"></i>
        <p class="weui-tabbar__label">商品</p>
    </a>
    <a href="/cart" class="weui-tabbar__item @if($tabIndex == 3) weui-bar__item_on @endif">
{{--         <span style="display: inline-block;position: relative;">
            <img src="{{ asset('images/default/index/cart.png') }}" alt="" class="weui-tabbar__icon">
            <img src="{{ asset('images/default/index/cartdefult.png') }}" alt="" class="weui-tabbar__icon">
            <span class="weui-badge" id="cart_num"></span>
        </span> --}}
        <i class="icon ion-heart"></i>
        <p class="weui-tabbar__label">购物车</p>
    </a>
<!--     <a href="javascript:;" class="weui-tabbar__item @if($tabIndex == 4) weui-bar__item_on @endif">
{{--         <img src="{{ asset('images/default/index/user.png') }}" alt="" class="weui-tabbar__icon">
    <img src="{{ asset('images/default/index/userdefult.png') }}" alt="" class="weui-tabbar__icon"> --}}
    <i class="icon ion-ios-clock-outline"></i>
    <p class="weui-tabbar__label">预约</p>
</a> -->
    <a href="/usercenter" class="weui-tabbar__item @if($tabIndex == 4) weui-bar__item_on @endif">
{{--         <img src="{{ asset('images/default/index/user.png') }}" alt="" class="weui-tabbar__icon">
        <img src="{{ asset('images/default/index/userdefult.png') }}" alt="" class="weui-tabbar__icon"> --}}
        <i class="icon ion-android-person"></i>
        <p class="weui-tabbar__label">我的</p>
    </a>
</div>


<script type="text/javascript">
    $(document).ready(function() {
      updateCartNum();
    });

    function updateCartNum() {
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
          url:"/api/cart_num",
          type:"GET",
          data:'',
          success: function(data) {
              if (data.code) {
                $('#cart_num').text('0');
              } else {
                $('#cart_num').text(data.message);
              }
          },
          error: function(data) {
              //提示失败消息

          },
      });
    }
</script>