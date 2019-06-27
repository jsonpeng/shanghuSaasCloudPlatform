<!DOCTYPE html>
<html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('title')

    <!-- WEUI -->
    <link rel="stylesheet" href="{{ asset('vendor/weui.min.css') }}">

    <!-- 图标字体 -->
    <link rel="stylesheet" href="{{ asset('ionicons.min.css') }}">

    <!-- 默认样式 -->
    <link rel="stylesheet" href="{{ asset('css/default/app.css') }}">

    <!-- 主题样式 -->
    <link rel="stylesheet" href="{{ asset('css/'.theme()['name'].'/app.css') }}">

    <!-- LAYER UI -->
    <link rel="stylesheet" href="{{ asset('vendor/layui/css/layui.css') }}"  media="all">

    <!-- SWIPER 幻灯片 -->
    <link rel="stylesheet" href="{{ asset('vendor/swiper4.22/css/swiper.min.css') }}">


    @yield('css')

    <?php $theme_main_color = themeMainColor(); ?>
    
    @include('front.common.color', ['theme_main_color' => $theme_main_color])

    <style type="text/css">
        #coupon .weui-cell-fl{  background-color: {{ $theme_main_color}};border: 1px dotted {{ $theme_main_color }};}
        .weui-tabbar .weui-bar__item_on p{color: #fff;}
        .weui-tabbar .weui-bar__item_on .icon{  color:#fff;}
        .discount .weui-tab .weui-navbar .weui-bar__item_on{  color: {{ $theme_main_color }};  border-bottom: 1px solid {{ $theme_main_color }};}
        .weui-tabbar.reverse  .weui-tabbar__item.weui-bar__item_on .weui-tabbar__label{color: #fff;}
        .weui-navbar__item.weui-bar__item_on{  border-bottom: 1px solid {{ $theme_main_color }};}
    </style>
    {{-- <style>
        .weui-dialog__btn_primary {color: {{ themeMainColor() }};}
        .product-wrapper .price {color: #ff4e44;}
        .product-wrapper .product-item2 .hot{background-color: {{themeMainColor() }};}
        i.time {  background-color: {{ themeMainColor()}};}
        .point-wrap .index-point-item .point-btn{  background-color:{{ themeMainColor()}};}
        #coupon .swipe-item{  border: 1px dotted {{ themeMainColor()}};}
        #coupon .weui-cell-fl{  background-color: {{ themeMainColor()}};border: 1px dotted {{ themeMainColor()}};}
        #coupon .weui-cell-fr{  border: 1px dotted {{ themeMainColor()}};}
        #coupon .box .price-symbol{color: {{ themeMainColor()}};}
        #coupon .box .price-num{  color: {{ themeMainColor()}};}
        #coupon .box .price-info .price-btn{  background-color: {{ themeMainColor()}};}
        .theme-item .title span{  color: {{ themeMainColor()}};}
        .weui-icon-success{  color:{{ themeMainColor()}};}
        .weui-tabbar .weui-bar__item_on p{color: #fff;}
        .weui-tabbar .weui-bar__item_on .icon{  color:#fff;}
        .cat-left .cat-row .active{  color: {{ themeMainColor()}};}
        .cat-row.active{ color: {{ themeMainColor()}};}
        .cat-selector li.active a{  color: {{ themeMainColor()}};}
        #product_detail .product-price{  color:#ff4e44;}
        .pin-team .qupin{  background-color: {{ themeMainColor()}};}
        .chooseDimension .Dimension-item.active{  background-color: {{ themeMainColor()}};}
        .chooseDimension .addcart{  border-top: 1px solid {{ themeMainColor()}};}
        .chooseDimension .buynow{  background-color: {{ themeMainColor()}};}
        #product_price{  color: #ff4e44;}
        .choicsel .choic-sel a.red{  background-color:{{ themeMainColor()}};}
        .switcher .active{  color: {{ themeMainColor()}};}
        .weui-cell.rollTip{  background-color: {{ themeMainColor()}};}
        .zcjy-product-cart .price{  color: #ff4e44;}
        .checkwrapper .right-botton01{  background-color: {{ themeMainColor()}};}
        .zcjy-product-check .price span:nth-child(1){  color: #ff4e44;}
        .zcjy-product-check .price .ft-l{  color: {{ themeMainColor()}};}
        #check .price_final{  color: #ff4e44;}
        #check .weui-panel__hd.tabList{  background-color: {{ themeMainColor()}};}
        #check .weui-panel__hd.tabList .active{  color: {{ themeMainColor()}};}
        .price_final{  color:#ff4e44;}
        .promp-tips{  color: {{ themeMainColor()}};}
        .user-address .select{  border: 1px solid {{ themeMainColor()}};  color: {{ themeMainColor()}};}
        .weui-actionsheet__cell.coupon-cell .price{  color: {{ themeMainColor()}};}
        .weui-actionsheet__cell.coupon-cell .usecoupon{  color: {{ themeMainColor()}};}
        .order-item-title .status{  color: {{ themeMainColor()}};}
        .order-item .userlist span{  color: {{ themeMainColor()}};}
        .order-status{  background-color: {{ themeMainColor()}};}
        .order-user-list .invite-button{  background-color: {{ themeMainColor()}};}
        .app-wrapper .weui-media-box .weui-media-box__desc span{  color: {{ themeMainColor()}};}
        .app-wrapper .contnet-wrapper .refund-types .refund-type.active{
            color: {{ themeMainColor()}};
            border: 1px solid {{ themeMainColor()}};
        }
        .app-wrapper .submit input {  background-color:{{ themeMainColor()}};}
        .refundstatus{  color: {{ themeMainColor()}};}
        .total span {  color: {{ themeMainColor()}};}
        .weui-navbar__item.weui-bar__item_on{  color: {{ themeMainColor()}};}
        .weui-grid.active-flashsale{  background-color: {{ themeMainColor()}};}
        a.flash-sale-item .go{  background-color: {{ themeMainColor()}};}
        .discount .weui-tab .weui-navbar .weui-bar__item_on{  color: {{ themeMainColor()}};  border-bottom: 1px solid {{ themeMainColor()}};}
        .discount .weui-tab__panel .weui-media-box_hd .type{  color: {{ themeMainColor()}};  border: 1px solid {{ themeMainColor()}};}
        .discount .weui-tab__panel .weui-media-box_hd .sum {  color: {{ themeMainColor()}};}
        .bankcard .bc-1{  background: linear-gradient(30deg, {{ themeMainColor()}}, #ff9140);}
        .bankcard .add-card a{  background-color: {{ themeMainColor()}};}
        .credit .head{  background-color: {{ themeMainColor()}};}
        .collect .order-item .weui-meida-box_bd .weui-media-box__desc .price{  color: {{ themeMainColor()}};}
        .weui-cells.withdraw .withdraw-body .ft-l{  color: {{ themeMainColor()}};}
        .withdraw-apply a{  background-color: {{ themeMainColor()}};}
        .withdraw-sum .money-num{  color: {{ themeMainColor()}};}
        .withdraw-sum .money-num input{  color: {{ themeMainColor()}};}
        .withdraw-sum .withdraw-apply-info .weui-cell__bd{  color: {{ themeMainColor()}};}
        .withdraw-sum .weui-btn{  background-color: {{ themeMainColor()}};}
        .weui-badge{  background-color:#ff4e44;}
        .weui-tabbar__item.weui-bar__item_on .weui-tabbar__icon,
        .weui-tabbar__item.weui-bar__item_on .weui-tabbar__icon > i
        {  color: {{ themeMainColor()}};}
        .weui-tabbar.reverse  .weui-tabbar__item.weui-bar__item_on .weui-tabbar__label{color: #fff;}
        .weui-switch-cp__input:checked ~ .weui-switch-cp__box,
        .weui-switch:checked {  border-color: {{ themeMainColor()}};background-color: {{ themeMainColor()}};}
        .weui-btn_primary{  background-color: {{ themeMainColor()}};}
        .weui-navbar__item.weui-bar__item_on{  border-bottom: 1px solid {{ themeMainColor()}};}
        .weui-icon-success-circle,.weui-icon-success-no-circle{  color: {{ themeMainColor()}};}
        .order-user-list .img-circle{border: 2px solid {{ themeMainColor()}};}
        .order-user-list .img-circle.pin:after{ background-color: {{ themeMainColor()}};}
        
        
        .checkwrapper .right-botton02{background-color: {{ themeSecondColor() }};}
        .shareCode .cut_line .weui-cell-fl{  background-color: {{ themeSecondColor() }};}
        .shareCode .cut_line .weui-cell-fr{  background-color: {{ themeSecondColor() }};}
        .userInfo{background-color:{{ themeMainColor()}};}
        .layui-m-layerbtn span[yes]{ color: {{ themeMainColor()}};}
        .weui-tabbar.reverse{background-color: {{ themeMainColor()}};}
        .discount .weui-tab__panel .link a{color:{{ themeMainColor()}} }
    </style> --}}

    <!-- jquery -->
    <script src="{{asset('vendor/jquery-1.12.4.min.js')}}"></script>
</head>
<body>
    @include('front.common.layer', ['theme_main_color' => $theme_main_color])

    <div class="app-wrapper">
        @yield('content')
    </div>
</body>

<!-- 弹出提示 -->
<script src="{{ asset('vendor/layer/mobile/layer.js') }}"></script>

<!-- 滚动 -->
<script src="{{ asset('vendor/swiper4.22/js/swiper.min.js') }}"></script>

<!-- 倒数计时 -->
<script src="{{ asset('js/default/timer.js') }}"></script>

<!-- 无限加载 -->
<script src="{{ asset('vendor/jquery.endless-scroll-1.3.js') }}"></script>

<!-- 图片缓加载 -->
<script src="{{ asset('vendor/jquery.lazyload.js') }}"></script>

<!-- 自定义代码 -->
<script src="{{ asset('js/default/main.js') }}"></script>





{{-- <script src="{{ asset('vendor/jweixin-1.0.0.js') }}"></script>
<script src="{{ asset('vendor/jquery.scroll.floor.js') }}"></script>
<script src="{{ asset('vendor/layer/mobile/layer.js') }}"></script>
<script src="{{ asset('js/default/main.js') }}"></script>
<script src="{{ asset('js/social/main.js') }}"></script>
<script src="{{ asset('js/default/timer.js') }}"></script>
<script src="{{ asset('js/default/ajaxfileupload.js') }}"></script>
<script src="{{ asset('vendor/layui/layui.js') }}"></script>
 --}}
@yield('js')

<script type="text/javascript">
    $("img.lazy").lazyload({effect: "fadeIn"});

    new Swiper('.swiper-container', {
        speed: 300,
        spaceBetween: 0,
        // Disable preloading of all images
        preloadImages: false,
        // Enable lazy loading
        lazy: true
    });
</script>


</html>