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

<!-- 文件上传 -->
<!--script src="{{ asset('js/default/ajaxfileupload.js') }}"></script-->
<!--script src="{{ asset('vendor/jweixin-1.0.0.js') }}"></script-->

@yield('js')
<script>
    $("img.lazy").lazyload({effect: "fadeIn"});

    new Swiper('.swiper-container', {
        speed: 2000,
        spaceBetween: 0,
        // Disable preloading of all images
        preloadImages: false,
        // Enable lazy loading
        lazy: true
    });
</script>
</html>