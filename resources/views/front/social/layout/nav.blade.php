<div class="weui-tabbar reverse" id="weui-tabbar">
    <a href="/" class="weui-tabbar__item @if($tabIndex == 1) weui-bar__item_on @endif">
        <img src="{{ asset('images/social/t1.png') }}" alt="" class="weui-tabbar__icon">
        <img src="{{ asset('images/social/t7.png') }}" alt="" class="weui-tabbar__icon ">
        <p class="weui-tabbar__label">首页</p>
    </a>

<!--     <a href="/brands" class="weui-tabbar__item @if($tabIndex == 2) weui-bar__item_on @endif">
{{--         <img src="{{ asset('images/default/index/index.png') }}" alt="" class="weui-tabbar__icon">
    <img src="{{ asset('images/default/index/indexdefult.png') }}" alt="" class="weui-tabbar__icon "> --}}
    <i class="icon ion-bag"></i>
    <p class="weui-tabbar__label">活动</p>
</a> -->

    <a href="/found" class="weui-tabbar__item @if($tabIndex == 5) weui-bar__item_on @endif">
        <img src="{{ asset('images/social/t5.png') }}" alt="" class="weui-tabbar__icon">
        <img src="{{ asset('images/social/t2.png') }}" alt="" class="weui-tabbar__icon">
        <p class="weui-tabbar__label">发现</p>
    </a>
    <a href="/cart" class="weui-tabbar__item @if($tabIndex == 3) weui-bar__item_on @endif">
        <span style="display: inline-block;position: relative;">
            <img src="{{ asset('images/social/t3.png') }}" alt="" class="weui-tabbar__icon">
            <img src="{{ asset('images/social/t3.png') }}" alt="" class="weui-tabbar__icon">
            <span class="weui-badge" id="cart_num">0</span>
        </span>
        <p class="weui-tabbar__label">购物车</p>
    </a>
    <a href="/usercenter" class="weui-tabbar__item @if($tabIndex == 4) weui-bar__item_on @endif">
        <img src="{{ asset('images/social/t6.png') }}" alt="" class="weui-tabbar__icon">
        <img src="{{ asset('images/social/t4.png') }}" alt="" class="weui-tabbar__icon">
        <p class="weui-tabbar__label">个人中心</p>
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