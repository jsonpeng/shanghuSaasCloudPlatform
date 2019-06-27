@extends('front.default.layout.base')

@section('css')
    <style>
        .weui-grid{width: 25%;}
        .swipe-wrap{width: 100%;}
        a.swiper-slide{width: 100%; display: block;}
        a.swiper-slide img{width: 100%; display: block;}
        .index-recommend-cat{display: flex;justify-content: space-between;align-items:stretch;}
        .index-recommend-cat .left_content{width: 49%;background-color: #fff;text-align: center;}
        .index-recommend-cat .left_content img{width: 100%;}
        .index-recommend-cat h4{font-size: 15px;}
        .index-recommend-cat  p{font-size: 8px;}
        .index-recommend-cat .right_content{width: 49%;}
        .index-recommend-cat .right_content a{width: 100%;margin-bottom: 0;}
        .index-recommend-cat .right_content a:nth-child(1){width: 100%;margin-bottom:5px;}
        .all_products{margin-top:5px;}
        .all_products .weui-cell__hd{width:20px;height:24px;margin-right: 10px;}
        .all_products .weui-cell__hd img{width: 100%;}
        .theme-title .content{margin-left: 0;margin-right: 0;}
    </style>
@endsection

@section('title')
@endsection

@section('content')
    {{-- <div id='slider' class='swipe'>
        <div class='swipe-wrap'>
            @foreach ($banners as $banner)
                <div class="swiper-slide">
                    <a @if($banner->link) href="{{ $banner->link }}" @else href="javascript:;" @endif><img src="{{ $banner->image }}" class="swiper-lazy"></a> 
                    <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                </div>
            @endforeach

        </div>
    </div>
    <script>
        window.mySwipe = new Swipe(document.getElementById('slider'), {
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

    <?php
        $banners = banners('index');
        $count = $banners->count();
    ?>
    @if($count)
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @foreach ($banners as $banner)
            <!-- Lazy image -->
            <a class="swiper-slide" @if($banner->link) href="{{ $banner->link }}" @else href="javascript:;" @endif>
                <img data-src="{{ $banner->image }}" class="swiper-lazy">
                <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <div class="weui-panel__bd index-recommend-cat" style="">
        <a class="left_content" style="" href="/post_cat">
            <div class="weui-media-box__bd">
                <div class="img" style="">
                    <img src="{{ asset('images/default_01/index/th1_board.jpg') }}" alt="">
                </div>
                <h4 class="weui-media-box__title">最新资讯</h4>
                <p class="weui-media-box__desc">INFORMATION</p>
            </div>
        </a>
        <div class="right_content">
            <a href="tel:{{ getSettingValueByKeyCache('service_tel') }}" class="weui-media-box weui-media-box_appmsg" style="">
                <div class="weui-media-box__hd">
                    <img class="weui-media-box__thumb" src="{{asset('images/default_01/index/th1_kefu.png')}}" alt="">
                </div>
                <div class="weui-media-box__bd">
                    <h4 class="weui-media-box__title">客服电话</h4>
                    <p class="weui-media-box__desc">CUSTOMER SERVICE</p>
                </div>
            </a>
            <a href="/page/weixin" class="weui-media-box weui-media-box_appmsg" >
                <div class="weui-media-box__hd">
                    <img class="weui-media-box__thumb" src="{{asset('images/default_01/index/th1_coupon.png')}}" alt="">
                </div>
                <div class="weui-media-box__bd">
                    <h4 class="weui-media-box__title">关注我们</h4>
                    <p class="weui-media-box__desc">FOLLOW US</p>
                </div>
            </a>
        </div>
    </div>
    <div class="weui-cells all_products">
        <a class="weui-cell weui-cell_access" href="/category">
            <div class="weui-cell__hd">
                <img src="{{ asset('images/default_01/index/tips.png') }}" alt="">
            </div>
            <div class="weui-cell__bd">
                <p>全部商品</p>
            </div>
            <div class="weui-cell__ft"></div>
        </a>  
    </div>
    <!-- 新品推荐 -->
    <div style="background-color: #fff;padding-top: 1.5rem; margin-top: 5px;">
        <div class="theme-title">
            <div class="content"><img src="{{ asset('images/default_01/index/hot_symbol.png') }}" style="vertical-align: middle; margin-right: 10px;">热销商品，精选推荐</div>
        </div>
    </div>
    
    <?php
        $products = products(0, 20);
    ?>
    <div class="product-wrapper scroll-container">
        @foreach ($products as $product)
            <a class="product-item2 scroll-post" href="/product/{{ $product->id }}">
                <div class="img">
                    <img src="{{ $product->image }}">
                    @if($product->is_hot)<p class="hot">HOT</p>@endif
                </div> 
                <div class="title">{{ $product->name }}</div>
                <div class="price">¥{{ $product->price }} <span>{{ $product->sales_count }}人购买</span></div>
            </a>
        @endforeach
    </div>
    
    <div id="shopinfo">
        @include('front.'.theme()['name'].'.layout.shopinfo')
    </div>

    @include(frontView('layout.nav'), ['tabIndex' => 1])
@endsection


@section('js')
<script type="text/javascript">
    $(document).ready(function(){

        //秒杀倒计时
        @if(funcOpen('FUNC_FLASHSALE') && isset($flashSaleProduct) && $flashSaleProduct->count())
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
                  for (var i = all_product.length - 1; i >= 0; i--) {
                    $('.scroll-container').append(
                      "<a class='product-item2 scroll-post' href='/product/" + all_product[i].id + "'>\
                          <div class='img'>\
                              <img src='" + all_product[i].image + "'>\
                          </div>\
                          <div class='title'>" + all_product[i].name + "</div>\
                          <div class='price'>¥" + all_product[i].price + " <span class='buynum'> " + all_product[i].sales_count + "人购买</span></div>\
                      </a>"
                    );
                  }
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

    /**
     * 没有活动提示
     * @return {[type]} [description]
     */
     function noHuodong(){
        layer.open({
          content: '当前没有优惠活动'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
     }
</script>
@endsection