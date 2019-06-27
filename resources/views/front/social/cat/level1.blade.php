@extends('front.social.layout.base')

@section('css')
    <style>
        .weui-grid{width: 25%;}
        .swipe-wrap{width: 100%;}
        a.swiper-slide{width: 100%; display: block;}
        a.swiper-slide img{width: 100%; display: block;}
       
    </style>
@endsection

@section('title')
@endsection

@section('content')

    <!-- 搜索框 -->
    @include('front.common.search.html')

    <div class="all_products">
      <div class="slide-box nav-scroll" id="nav-scroll">
          <div class="slide-warp">
              <a class="slide-item" href="/">首页</a>
              <?php 
                  $rootCats = cat_level01();
              ?>
           @foreach($rootCats as $element)
              <a class="slide-item @if($id == $element->id) active @endif" href="/category/level1/{{ $element->id }}">
                  {{ $element->name }}
              </a>
           @endforeach
          </div>
      </div>
    </div>
    <!-- 广告 -->
    <?php
        $banners = banners($category->slug);
        $count = $banners->count();
    ?>
    @if ($count)
        {{-- <div id='{{ $category->slug }}' class='swipe'>
            <div class='swipe-wrap'>
                @foreach ($banners as $banner)
                    <div class="swiper-slide">
                        <a @if($banner->link) href="{{ $banner->link }}" @else href="{{ $banner->link }}" @endif><img src="{{ $banner->image }}" class="swiper-lazy"></a> 
                    </div>
                @endforeach

            </div>
        </div>

        <script>
          window.mySwipe = new Swipe(document.getElementById('{{ $category->slug }}'), {
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
    
    <!-- 板块 -->
    <div class="weui-grids index-function-grids">
      <?php
        $cat_level02 = cat_level02($id);
      ?>
      @foreach ($cat_level02 as $element)
        <a href="/category/level2/{{ $element->id }}" class="weui-grid">
           <div class="weui-grid__icon">
               <img src="{{ $element->image }}" alt="">
           </div>
           <p class="weui-grid__label">{{ $element->name }}</p>
        </a>
      @endforeach

   </div>
    
    <!-- 今日限量秒杀 
    <div class="top-title flash_sale">
        <p>今日限量秒杀</p>
    </div>
    <div class="product-wrapper flash_sale">
      <a class="product-item3" href="javascript:;">
          <div class="img">
              <img class="lazy" src="{{asset('images/social/p2.jpg')}}">
          </div> 
          <div class="title">1</div>
          <div class="price">¥2 <span class="cross">¥1</span></div>
      </a>
      <a class="product-item3" href="javascript:;">
          <div class="img">
              <img class="lazy" src="{{asset('images/social/p3.jpg')}}">
          </div> 
          <div class="title">1</div>
          <div class="price">¥2 <span class="cross">¥1</span></div>
      </a>
      <a class="product-item3" href="javascript:;">
          <div class="img">
              <img class="lazy" src="{{asset('images/social/p4.jpg')}}">
          </div> 
          <div class="title">1</div>
          <div class="price">¥2 <span class="cross">¥1</span></div>
      </a>
    </div>-->

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


    <!-- 精选分类 -->
    <div class="index-recommend-cat weui-cell" style="">
        <a href="/product_of_type/1" class="left_content" style="">
                <img src="{{ getSettingValueByKeyCache('image_new') }}" alt="">
{{--                 <div class="img" style="">新品橱窗</div>
                <h4 class="weui-media-box__title">每日新款大推荐</h4>
                <p class="weui-media-box__desc">GO ＞</p> --}}
            {{-- </div> --}}
        </a>
        <div class="right_content">
            <a href="/product_promp" {{-- class="weui-media-box__bd" --}} style="">
                <img src="{{ getSettingValueByKeyCache('image_prmop') }}" alt="">
{{--                 <div class="img" style="">优惠活动</div>
                <h4 class="weui-media-box__title">每日优惠大推荐</h4>
                <p class="weui-media-box__desc">GO ＞</p> --}}
            </a>
            <a href="/product_of_type/2" {{-- class="weui-media-box__bd" --}} >
                <img src="{{ getSettingValueByKeyCache('image_sales_count') }}" alt="">
{{--                 <div class="img" style="">销量榜</div>
                <h4 class="weui-media-box__title">偷看达人购物车</h4>
                <p class="weui-media-box__desc">GO ＞</p> --}}
            </a>
        </div>
    </div>

    <!-- 限时秒杀 -->
{{--     @if(funcOpen('FUNC_FLASHSALE') && $flashSaleProduct->count())
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

    <!-- 国家馆 -->
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
    

    <div class="product-wrapper more-goods scroll-container">

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

    <div id="shopinfo">
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

  @include('front.common.search.js')

  $(document).ready(function(){
    //导航条
    var w1=$('.nav-scroll .slide-item').width()+20;
    var index=$('.nav-scroll .active').index()-2;
    var left=w1*index;
    $('.nav-scroll').scrollLeft(left);

    //秒杀倒计时
   
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
            url:"/ajax/category/level1/{{ $id }}?skip=" + $('.scroll-post').length + "&take=18",
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

     // // 搜索框中是否有内容输入
     // $(".search-box .weui-cell__bd input").focus(function(){
     //        var len = $('.search-box .weui-cell__bd input').val();
     //        console.log(len);
     //        if(len == ''){
     //            $('.search-box .find-icon').show();
     //        }else{
     //            $('.search-box .find-icon').hide();
     //        }
     // });
     // $(this).on('click', '.selector', function(event) {
     //   event.preventDefault();
     //   /* Act on the event */
     // });
    // var mySwiper = new Swiper('.swiper-container', {
    //   // autoplay: 1000,//可选选项，自动滑动
    //   resistanceRatio : 0,
    //   slidesPerView : 'auto',//'auto'
    //   // centeredSlides : true,//设定为true时，active slide会居中，而不是默认状态下的居左
    //   slideToClickedSlide: false,
    //   onClick: function(swiper){
    //             /* Act on the event */
    //             $(this).siblings().removeClass('swiper-slide-active').removeClass('active');
    //             $(this).addClass('swiper-slide-active').addClass('active');
    //   }
    // })
    // mySwiper.slideTo($('.swiper-slide.active').index(), 1, false);
  /* Act on the event */
  // 导航项目保持居中

  // var wid1=$('.slide-item').parents('.slide-box').parent().width();
  // var wid2=wid1/3;
  // $('.country-sum .slide-item,.flash_sale .slide-item,.team_sale .slide-item').width(wid2);

  // $(document).resize(function(event) {
  //     /* Act on the event */
  //     var wid1=$('.slide-item').parents('.slide-box').width();
  //     var wid2=wid1/3;

  //     $('.country-sum .slide-item,.flash_sale .slide-item,.team_sale .slide-item').width(wid2);
  // });

</script>
@endsection