<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="renderer" content="webkit">
<meta name="referrer" content="always">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
<title id="js-meta-title">选择店铺</title>
<link rel="icon" href="http://www.yunlike.cn/favicon.ico">
<meta name="keywords" content="有赞,微信商城,粉丝营销,微信商城运营">
<meta name="description" content="有赞是帮助商家在微信上搭建微信商城的平台，提供店铺、商品、订单、物流、消息和客户的管理模块，同时还提供丰富的营销应用和活动插件。">
<!-- ▼ Common CSS -->
<link rel="stylesheet" href="https://b.yzcdn.cn/v2/wsc/build/css/base_b9ecfb34d1ac08f1a23731a563ed0a99.css" onerror="_cdnFallback(this)" crossorigin="anonymous">
<!-- ▲ Common CSS --><!-- ▼ App CSS -->
<link rel="stylesheet" href="https://b.yzcdn.cn/v2/wsc/build/css/shop_d81710860b3e7d7afa4b6926b591e8fc.css" onerror="_cdnFallback(this)" crossorigin="anonymous">
<!-- ▲ App CSS --><!-- ▼ Common config -->
<link rel="stylesheet" href="/css/admin.css">
<style type="text/css">
    .shop .blue_bg {
    border-top: 3px solid #38f !important;
    }
</style>
</head>
<body class="theme theme--blue theme-new-ui " youdao="bind">
<!-- ▼ Main sidebar --><!-- ▲ Main sidebar --><!-- ▼ Main container -->

<div id="js-react-container">

    <div data-reactroot="" class="shop">
        @if($admin_package['level'] == 0)
            <div class="hint">
                免费试用期还剩{{ $admin_package['time'] }}天，为了不影响使用，请尽快购买套餐哦。咨询电话：027-88888888 
            <!--    <a href="">立即续约</a> -->
            </div>
        @else
            <div class="hint">
                当前{{ $admin_package['package']['package_name'] }}套餐还剩{{ $admin_package['time'] }}天，咨询电话：027-88888888 
                <a href="javascript:;">立即续费</a>
            </div>
        @endif
        <div style="color:red;">
                @include('adminlte-templates::common.errors')
        </div>
        <div class="head">
            <a class="logon_link" href="http://www.yunlike.cn">
            <div class="logo" style="background-image: url('http://www.yunlike.cn/img/logo.png');    height: 33px;">
            </div>
            </a>
            <div class="sep">
            </div>
            <h2>选择店铺(当前最多可添加{!! tag($admin_package['package']['canuse_shop_num']) !!}个店铺,当前还能添加{!! tag($admin_package['package']['canuse_shop_num'] - count($admin_package['shops'])) !!}个店铺)</h2>
            <span class="right"><!-- react-text: 8 -->{{ admin()->nickname }}<!-- /react-text --><span class="sep">-</span><a href="{!! url('/zcjy/logout') !!}">退出</a></span>
        </div>
        <div class="select">
            <div class="infobar">
                <img alt="头像" class="avatar" src="https://img.yzcdn.cn/upload_files/no_pic.png?imageView2/2/w/280/h/280/q/75/format/webp">
                <h3>{{ admin()->nickname  }}</h3>
                <p>
                    <!-- react-text: 16 -->+86-{{ admin()->mobile  }}<!-- /react-text --><!-- <a class="info-setting" href="//www.youzan.com/v2/account/personal">设置</a> -->
                </p>
                @if($admin_package['package']['canuse_shop_num'] > count($admin_package['shops']))
                <div class="create-btn">
                    <a href="{!! route('storeShops.create') !!}" class="zent-btn-primary zent-btn"><span>创建店铺</span></a>
                </div>
                @endif
            </div>
            <div class="zent-loading-container zent-loading-container-static" style="height: initial;">
                <div class="box">
                    <div class="clearfix">
                        <ul class="f-fl clearfix sort">
                            <li class="f-fl active"><span>所有店铺</span></li>
                       
                        </ul>
                        <form action=""> 
                        <div class="zent-input-wrapper search-query f-fr">
                            <input type="text" class="zent-input" name="name" placeholder="搜索店铺" value="">
                        </div>
                        </form>
                    </div>
                    <div class="hide">
                        <span class="tag">企业</span><span class="tag">vip</span>
                    </div>

                    @if(count($storeShops))
                    <ul class="dp-list">
                        @foreach($storeShops as $shop)
                        <li class="dp-item blue_bg shop_item" title="2" data-url="/zcjy/selectShopRedirect/{{ $shop->id }}">
                        <div class="dp-title">
                            <span class="dp-text">{{ $shop->name }}</span>
                        </div>
                        <p>
                            <!-- react-text: 45 -->联系人<!-- /react-text --><!-- react-text: 46 -->{{ $shop->contact_man }}<!-- /react-text -->
                        </p>
                        <p>
                            <!-- react-text: 48 -->联系电话<!-- /react-text --><!-- react-text: 49 -->：<!-- /react-text --><!-- react-text: 50 -->{{ $shop->tel }}<!-- /react-text -->
                        </p>
                        <div>
                            <div class="operate-label">
                                <a href="{!! route('storeShops.edit', [$shop->id]) !!}">修改</a>
                                {!! Form::open(['route' => ['storeShops.destroy', $shop->id], 'method' => 'delete','style' => 'display:inline']) !!}
                                   {!! Form::button('删除', ['type' => 'submit','onclick' => "return confirm('确定删除吗?')",'style'=>'color:#38f;']) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <span class="type">美业</span></li>
                        @endforeach

                     

                        <li class="holder"></li>
                        <li class="holder"></li>
                    </ul>

                  
                    <div class="zent-pagination ">
                        <span class="zent-pagination__info"><span class="total each"><!-- react-text: 106 -->共 {{ $storeShops_num }} 条，<!-- /react-text --><!-- react-text: 107 -->每页 <!-- /react-text --><!-- react-text: 108 -->{{ defaultPage() }}<!-- /react-text --><!-- react-text: 109 --> 条<!-- /react-text --></span></span>
                    </div>

                    @else
                    <div style="text-align: center;margin-top: 80px;">
                        <h3>请先创建店铺</h3>
                    </div>
                    @endif

                </div>
            </div>
            <!-- react-empty: 110 -->
        </div>
        <div class="gener-ambas">
            <a href="http://www.yunlike.cn" target="_blank" alt="推广大使" class="gener-ambas-img"></a>
        </div>
        <div class="foot">
            <!-- react-text: 114 -->© 2016 - <!-- /react-text --><!-- react-text: 115 -->2018<!-- /react-text --><!-- react-text: 116 --> www.yunlike.cn 版权所有<!-- /react-text -->
        </div>
    </div>
</div>
<!-- ▲ Main container --><!-- ▼ Sentry wsc-pc -->
</div>
<!-- ▼ App CSS --><!-- ▲ App CSS -->
</body>

<!-- jQuery 2.1.4 -->
<script src="https://cdn.bootcss.com/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">
    $(function(){
        $('.shop_item').click(function(){
                location.href=$(this).data('url');
        });
        $('.hint a').click(function(){
            console.log($(this));
            var that =this;
            $('.item').find('a').each(function(){
                if($(that).text() == $(this).text() ){
                    location.href = $(this).attr('href');
                }
            })
        });
    });
</script>
</html>