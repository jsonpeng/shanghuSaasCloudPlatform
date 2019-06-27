@extends('front.social.layout.base')

@section('css')

@endsection

@section('title')
@endsection

@section('content')

    @include('front.common.search.html')

    <!-- 商品分类 -->
    <div class="all_products">
        <div class="slide-box nav-scroll">
            <div class="slide-warp">
                <a class="slide-item active" href="javascript:;">首页</a>
                <?php 
                    $rootCats = cat_level01();
                ?>
             @foreach($rootCats as $element)
                <a class="slide-item" href="/category/level1/{{ $element->id }}">
                    {{ $element->name }}
                </a>
             @endforeach
            </div>
        </div>
    </div>
    
    <?php
        $banners = banners('index');
        $count = $banners->count();
    ?>
    @if ($count)

        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach ($banners as $element)
                <!-- Lazy image -->
                <a class="swiper-slide" @if($element->link) href="{{ $element->link }}" @else href="javascript:;" @endif>
                    <img data-src="{{ $element->image }}" class="swiper-lazy">
                    <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                </a>
                @endforeach
            </div>
        </div>

    @endif
    
    <!-- 资讯 -->
    <?php
        $notices = notices();
    ?>
    @if ($notices->count())
        <div class="weui-cell notice">
            <div class="weui-cell__hd">
                <p>NOTICE</p>
            </div>
            <div class="weui-cell__bd txtScroll-top">
                <div class="swiper-container1">
                  <div class="swiper-wrapper infoList">
                    @foreach ($notices as $element)
                        <a class="swiper-slide" href="/notices/{{ $element->id }}">
                            <span class="title">{{ getSettingValueByKeyCache('name') }}</span>
                            <span class="content">{{ $element->name }}</span>
                        </a>
                    @endforeach
                  </div>
                </div>
            </div>
            
        </div>
    @endif


    
    
    <!-- 标题 -->
    <div class="top-title">
        <p>精选好货</p>
    </div>
    <!-- 精选分类 -->
    <div class="index-recommend-cat weui-cell" style="">
        <a href="/product_of_type/1" class="left_content" style="">
                <img src="{{ getSettingValueByKeyCache('image_new') }}" alt="">
        </a>
        <div class="right_content">
            <a href="/product_promp" {{-- class="weui-media-box__bd" --}} style="">
                <img src="{{ getSettingValueByKeyCache('image_prmop') }}" alt="">
            </a>
            <a href="/product_of_type/2" {{-- class="weui-media-box__bd" --}} >
                <img src="{{ getSettingValueByKeyCache('image_sales_count') }}" alt="">
            </a>
        </div>
    </div>
 
    <!-- 限时秒杀 -->
    {{-- @if(funcOpen('FUNC_FLASHSALE') && $flashSaleProduct->count())
    <div class="weui-cells">
        <div class="weui-cell weui-cell_access">
            <div class="weui-cell__bd title-img" id="count_timer">
                <img src="{{ asset('images/default/index/miaosha.png') }}" style="vertical-align: middle; margin-right: 10px;">
                <span style="vertical-align: middle">限时秒杀</span> 
                <span style="vertical-align: middle"> 
                    <i class="time time-hour">01</i>:<i class="time time-minute">15</i>:<i class="time time-second">25</i> 
                </span>
            </div>
            <a class="weui-cell__ft" href="/flash_sale">查看更多</a>
        </div>
    </div>
    
    <div class="product-wrapper">
        @foreach ($flashSaleProduct as $element)
            <a class="product-item3" href="/product/{{ $element->product_id }}">
                <div class="img">
                    <img class="lazy" data-original="{{ $element->image }}">
                </div> 
                <div class="title">{{ $element->product_name }}</div>
                <div class="price">¥{{ $element->price }} <span class="cross">¥{{ $element->origin_price }}</span></div>
            </a>
        @endforeach
    </div>
    @endif --}}

    <!-- 环球国家馆 -->
    <?php
        $countries = countries();
    ?>

    @if ($countries->count())
        <div class="top-title">
            <p>环球国家馆</p>
        </div>
        
        <div class="product-wrapper country-sum">
            <div class="slide-box">
                <div class="slide-warp">
                    @foreach ($countries as $element)
                        <a class="slide-item" href="/product_of_type/3?country_id={{ $element->id }}">
                            <img src="{{ $element->image }}" alt="">
                            <p class="intr">{{ $element->name }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    
    <!-- 首页广告 -->
    <?php
        $banners = banners('ad-index');
        $count = $banners->count();
    ?>
    @if ($count)
        {{-- <div id='ad-index' class='swipe'>
            <div class='swipe-wrap'>
                @foreach ($banners as $banner)
                    <div class="swiper-slide">
                        <a @if($banner->link) href="{{ $banner->link }}" @else href="javascript:;" @endif><img src="{{ $banner->image }}" class="swiper-lazy"></a> 
                    </div>
                @endforeach

            </div>
        </div>

        <script>
          window.mySwipe = new Swipe(document.getElementById('ad-index'), {
              startSlide: 0,
              speed: 400,
              auto: 3000,
              continuous: true,
              disableScroll: false,
              stopPropagation: false,
              callback: function(index, elem) {},
              transitionEnd: function(index, elem) {}
          });
        </script> --}}
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach ($banners as $element)
                <!-- Lazy image -->
                <a class="swiper-slide" @if($element->link) href="{{ $element->link }}" @else href="javascript:;" @endif>
                    <img data-src="{{ $element->image }}" class="swiper-lazy">
                    <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                </a>
                @endforeach
            </div>
        </div>

    @endif

    <!-- 今日限量秒杀 -->
    <?php
        $flashSaleProduct = flashSale(0, 8);
    ?>
    @if(funcOpen('FUNC_FLASHSALE') && $flashSaleProduct->count())
    <div class="top-title theme-flash_sale">
        <p>今日限量秒杀</p>
    </div>
    <div class="product-wrapper theme-flash_sale">
        <div class="slide-box">
            <div class="slide-warp">
                @foreach ($flashSaleProduct as $element)
                    <div class="slide-item">
                        <a class="product-item3" href="/product/{{ $element->product_id }}">
                            <div class="img">
                                <img class="lazy" data-original="{{ $element->image }}">
                            </div> 
                            <div class="title">{{ $element->product_name }}</div>
                            <div class="price">¥{{ $element->price }} <span class="cross">¥{{ $element->origin_price }}</span></div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- 拼团 -->
    <?php
        $teamSaleProducts = teamSale(0, 3);
    ?>
    @if(funcOpen('FUNC_TEAMSALE') && $teamSaleProducts->count())
        <div class="top-title theme-team_sale">
            <p>拼团专区</p>
        </div>

        <div class="product-wrapper theme-team_sale">
            <div class="slide-box">
                <div class="slide-warp">
                    @foreach ($teamSaleProducts as $element)
                        <div class="slide-item">
                            <a class="product-item3" href="/product/{{ $element->id }}">
                                <div class="img">
                                    <img class="lazy" src="{{asset('images/social/p5.jpg')}}">
                                </div> 
                                <div class="title">1</div>
                                <div class="price">¥2 <span class="cross">¥1</span></div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    
    <!-- 精选专题 -->
    {{-- <div class="top-title">
        <p>精选专题</p>
    </div>
    <div class="weui-cell subject">
        <div class="product-show">
            <div class="show-item"">
                <img src="{{ asset('images/social/j1.jpg') }}" alt="">
            </div>
        </div>
    </div>
    <div class="weui-cell subject">
        <div class="product-show">
            <div class="show-item">
                <img src="{{ asset('images/social/j2.jpg') }}" alt="">
            </div>
        </div>
    </div>
    <div class="weui-cell subject">
        <div class="product-show">
            <div class="show-item">
                <img src="{{ asset('images/social/j3.jpg') }}" alt="">
            </div>
        </div>
    </div>
    <div class="weui-cell subject">
        <div class="product-show">
            <div class="show-item">
                <img src="{{ asset('images/social/j4.jpg') }}" alt="">
            </div>
        </div>
    </div> --}}
    
    <!-- 更多商品 -->
    <?php
        $products = products(0, 18);
    ?>
    <div class="top-title more-goods">
        <p>更多商品</p>
    </div>
    
    <div class="product-wrapper more-goods scroll-container" id="more-goods">
        @foreach ($products as $element)
            <a class="product-item3 scroll-post" href="/product/{{ $element->id }}">
                <div class="img">
                    <img class="lazy" data-original="{{ $element->image }}">
                </div> 
                <div class="title">{{ $element->name }}</div>
                @if ($element->realPrice)
                    <div class="price">¥{{ $element->realPrice }} <span class="cross">¥{{ $element->price }}</span></div>
                @else
                    <div class="price">¥{{ $element->price }} </div>
                @endif
            </a>
        @endforeach

    </div>

    <div id="shopinfo" style="display: none;">
        @include('front.'.theme()['name'].'.layout.shopinfo')
    </div>

    @include(frontView('layout.nav'), ['tabIndex' => 1])
@endsection


@section('js')

<script src="{{ asset('vendor/doT.min.js') }}"></script>
<script src="{{ asset('vendor/underscore-min.js') }}"></script>

<script type="text/template" id="template">
    @{{~it:value:index}}
        <a class="product-item3 scroll-post" href="/product/@{{=value.id}}">
            <div class="img">
                <img class="lazy" data-original="@{{=value.image}}">
            </div> 
            <div class="title">@{{=value.name}}</div>
            @{{? value.realPrice }}
                <div class="price">¥@{{=value.realPrice}} <span class="cross">¥@{{=value.price}}</span></div>
            @{{??}}
                <div class="price">¥@{{=value.price}} </div>
            @{{?}}
        </a>
    @{{~}}
</script>

<script type="text/template" id="template-search">
    @{{~it:value:index}}
        <a class="weui-cell weui-cell_access" href="/product/@{{=value.id}}">
            <div class="weui-cell__bd weui-cell_primary">
                <p>@{{=value.name}}</p>
            </div>
        </a>
    @{{~}}
</script>


<script type="text/javascript">
    $(document).ready(function(){

        //秒杀倒计时
        @if(funcOpen('FUNC_FLASHSALE') && $flashSaleProduct->count())
            var end_time='{!! $time !!}';
            startShowCountDown(end_time,'#count_timer','flashsale_index');
        @endif

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
                url:"/api/products?skip=" + $('.scroll-post').length + "&take=18",
                type:"GET",
                success:function(data){
                    working = false;
                    var all_product=data.data;
                    if (all_product.length == 0) {
                        fireEvent = false;
                        $('#shopinfo').show();
                        return;
                    }

                  // 编译模板函数
                  var tempFn = doT.template( $('#template').html() );

                  // 使用模板函数生成HTML文本
                  var resultHTML = tempFn(all_product);

                  // 否则，直接替换list中的内容
                  $('.scroll-container').append(resultHTML);

                  $("img.lazy").lazyload({effect: "fadeIn"});

                }

              });
            }
        });
    });


    $('.price-btn').click(function(){
        var id=$(this).data('id');
        var status=$(this).data('status');
        var that=this;
        if(!status){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'/api/userGetCoupons/'+id,
                type:'post',
                success:function(data){
                    if(data.code==0){
                        layer.open({
                        content:data.message
                        ,skin: 'msg'
                        ,time: 2 
                      });
                    $(that).text('已领取');
                    $(that).data('status',true);
                    $(that).attr("style","background-color:#ddd !important;");
                    }else{
                    layer.open({
                        content:data.message
                        ,skin: 'msg'
                        ,time: 2 
                      });
                    }
                }
            });
        }else{
            return false;
        }

    });

    @include('front.common.search.js')

</script>

{{-- 资讯信息 --}}
<script>
    var mySwiper1 = new Swiper('.swiper-container1', {
        direction : 'vertical',
        loop : true,
        speed: 1000,
        // autoplay: {
        //   delay: 3000,//1秒切换一次
        // },
    })
</script>

@endsection