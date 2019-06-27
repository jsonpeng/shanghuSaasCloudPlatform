<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ getSettingValueByKeyCache('name') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/select2/4.0.3/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.bootcss.com/iCheck/1.0.2/skins/all.css">
    
    <link rel="stylesheet" href="{{ asset('vendor/adminLTE/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminLTE/css/skins/skin-blue.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert/lib/sweet-alert.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/multisel/css/bootstrap-multiselect.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/daterangepicker/daterangepicker-bs3.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datepicke/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css">

    @yield('css')
</head>

<body class="skin-blue sidebar-mini">
@if (auth('admin')->check())
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="http://www.yunlike.cn" class="logo">
                <b>芸来到店系统</b>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>

        

                <a href="/zcjy/settings/setting" class="sidebar-toggle fourset">
                    <span>系统</span>
                </a>

                <a href="{!! route('products.index') !!}" class="sidebar-toggle fourset">
                    <span>产品</span>
                </a>
                
              {{--   @if(funcOpen('FUNC_DISTRIBUTION')) --}}
                <a href="{!! route('distributions.lists') !!}" class="sidebar-toggle fourset active">
                    <span>分销</span>
                </a>
             {{--    @endif --}}
                
          {{--       @if(funcOpen('FUNC_PRODUCT_PROMP') || funcOpen('FUNC_ORDER_PROMP') || funcOpen('FUNC_FLASHSALE') || funcOpen('FUNC_TEAMSALE') || funcOpen('FUNC_COUPON')) --}}
                <a href="{!! route('coupons.index') !!}" class="sidebar-toggle fourset">
                    <span>促销</span>
                </a>
              {{--   @endif --}}
                
                <!-- Navbar Right Menu -->
                @include('admin.layouts.right_menu')
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        @include('admin.layouts.sidebar_distribution')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Main Footer 
        <footer class="main-footer" style="max-height: 100px;text-align: center">
            <strong>Copyright 2015-2017 <a href="#">智琛佳源科技有限公司</a>.</strong> All rights reserved.
        </footer>-->
        @include('admin.layouts.notice')
    </div>
@else
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="http://www.wiswebs.com">
                    武汉智琛佳源科技有限公司
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="http://www.wiswebs.com">武汉智琛佳源科技有限公司</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li><a href="{!! url('/auth/login') !!}">登录</a></li>
                </ul>
            </div>
        </div>
    </nav>

@endif

    <!-- jQuery 2.1.4 -->
    <script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdn.bootcss.com/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://cdn.bootcss.com/iCheck/1.0.2/icheck.min.js"></script>
    <script src="https://cdn.bootcss.com/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdn.bootcss.com/moment.js/2.18.1/locale/zh-cn.js"></script>

    <!-- AdminLTE App -->
    <!--script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.3/js/app.min.js"></script-->
    <script type="text/javascript" src="{{ asset('vendor/adminLTE/js/app.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/sweetalert/lib/sweet-alert.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/tinymce/jquery.tinymce.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/multisel/js/bootstrap-multiselect.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/daterangepicker/daterangepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/datepicke/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/datepicke/locales/bootstrap-datepicker.zh-CN.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/select/js/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/layer/layer.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin.js') }}"></script>
    @yield('scripts')
</body>
</html>