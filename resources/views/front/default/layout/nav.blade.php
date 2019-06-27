<div class="weui-tabbar" id="weui-tabbar">
    <a href="/" class="weui-tabbar__item @if($tabIndex == 1) weui-bar__item_on @endif">
        <i class="icon ion-home"></i>
        <p class="weui-tabbar__label">首页</p>
    </a>
    <a href="/category" class="weui-tabbar__item @if($tabIndex == 2) weui-bar__item_on @endif">
        <i class="icon ion-android-star"></i>
        <p class="weui-tabbar__label">商品</p>
    </a>
    <a href="/found" class="weui-tabbar__item @if($tabIndex == 5) weui-bar__item_on @endif">
        <i class="icon ion-ios-eye"></i>
        <p class="weui-tabbar__label">发现</p>
    </a>
    <a href="/cart" class="weui-tabbar__item @if($tabIndex == 3) weui-bar__item_on @endif">
        <i class="icon ion-ios-cart"></i>
        <p class="weui-tabbar__label">购物车</p>
    </a>
    <a href="/usercenter" class="weui-tabbar__item @if($tabIndex == 4) weui-bar__item_on @endif">
        <i class="icon ion-android-person"></i>
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