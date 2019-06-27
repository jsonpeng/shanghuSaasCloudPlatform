@extends('front.default.layout.base')

@section('css')
    <style>
        .weui-grid{width: 25%;}
        .swipe-wrap{width: 100%;}
        a.swiper-slide{width: 100%; display: block;}
        a.swiper-slide img{width: 100%; display: block;}

        .search-box{height: 35px;position: relative;}
        .search-box input{height: 35px;line-height: 35px;width: 100%;border-radius: 10px;background-color: #ececec;border:1px solid #ececec;padding-left: 25px;box-sizing: border-box;}
        input::-ms-input-placeholder{text-align: center;font-size:12px;color: #a8a8a8;}
        input::-webkit-input-placeholder{text-align: center;font-size:12px;color: #a8a8a8;}
        .search-box .weui-cell__hd{z-index: 1000;margin-right: -25px;}
        .search-box .icon{position: absolute;left: 25px;color: #a8a8a8;font-size: 14px;}
        .index-function-grids p{color: #333;font-size: 16px;}
        .weui-grids:before{border-top: 0;}
        .theme-title{border-top: 0;}
        .theme-title .content{margin:0;}
    </style>
@endsection

@section('title')
@endsection

@section('content')
    <?php
        $banners = banners('index');
        $count = $banners->count();
    ?>

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

    <!-- 搜索框 -->
    <div class="weui-cells all_products">
        <a class="weui-cell search-box" href="javascript:;">
            <i class="icon ion-ios-search">
            </i>
            <div class="weui-cell__bd">
                <input type="text" placeholder="输入商品名称">
            </div>
        </a>  
    </div>


    <!-- 板块 -->
    <div class="weui-grids index-function-grids">
        <a href="/category" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/theme02/c1.jpg') }}" alt="">
            </div>
            <p class="weui-grid__label">全部分类</p>
        </a>
        <a href="/brands" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/theme02/c2.jpg') }}" alt="">
            </div>
            <p class="weui-grid__label">品牌街</p>
        </a>
        <a href="/product_promp" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/theme02/c3.jpg') }}" alt="">
            </div>
            <p class="weui-grid__label">优惠活动</p>
        </a>
        <a href="/team_sale" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/theme02/c4.jpg') }}" alt="">
            </div>
            <p class="weui-grid__label">团购</p>
        </a>
    </div>
    
    <!-- 新品推荐 -->
    <div style="background-color: #fff;padding: 15px 0; margin-top: 5px;">
        <div class="theme-title">
            <div class="content"><img src="{{ asset('images/default/index/sift.png') }}" style="vertical-align: middle; margin-right: 10px;">热销商品，精选推荐</div>
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