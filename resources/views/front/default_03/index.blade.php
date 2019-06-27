@extends('front.default.layout.base')

@section('css')
    <style>
        .weui-grid{width: 25%;}
        .swipe-wrap{width: 100%;}
        a.swiper-slide{width: 100%; display: block;}
        a.swiper-slide img{width: 100%; display: block;}

        .search-box{height: 50px;position: relative;}
        .search-box input{height: 50px;line-height: 50px;width: 100%;border-radius: 7px;background-color: #ececec;border:1px solid #ececec;padding-left: 25px;box-sizing: border-box;}
        input::-ms-input-placeholder{font-size:12px;color: #a8a8a8;}
        input::-webkit-input-placeholder{font-size:12px;color: #a8a8a8;}
        .search-box .weui-cell__hd{z-index: 1000;margin-right: -25px;}
        .search-box .find-icon{position: absolute;left: 25px;color: #a8a8a8;font-size: 14px;}
        .search-box .weui-cell__ft{margin-left:10px;padding: 0 10px;}
        .search-box .weui-cell__ft .icon{font-size: 28px;color:#919191;}
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
            <i class="icon ion-ios-search  find-icon">
            </i>
            <div class="weui-cell__bd">
                <input type="text" placeholder="输入商品名称">
            </div>
            <div class="weui-cell__ft">
                <i class="icon ion-ios-cart-outline"></i>
            </div>
        </a>  
    </div>


    <!-- 板块 -->
    <div class="weui-grids index-function-grids">
        @if(funcOpen('FUNC_FLASHSALE'))
        <a href="/flash_sale" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/default_03/g1.png') }}" alt="">
            </div>
            <p class="weui-grid__label">秒杀专场</p>
        </a>
        @endif
        
        @if(funcOpen('FUNC_TEAMSALE'))
        <a href="/team_sale" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/default_03/g2.png') }}" alt="">
            </div>
            <p class="weui-grid__label">拼团</p>
        </a>
        @endif
        
        @if(funcOpen('FUNC_PRODUCT_PROMP'))
        <a href="/product_promp" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/default_03/g3.png') }}" alt="">
            </div>
            <p class="weui-grid__label">优惠活动</p>
        </a>
        @endif
        
        @if(funcOpen('FUNC_COUPON'))
        <a href="/coupon" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/default_03/g4.png') }}" alt="">
            </div>
            <p class="weui-grid__label">优惠券</p>
        </a>
        @endif

        <a href="/category" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/default_03/g5.png') }}" alt="">
            </div>
            <p class="weui-grid__label">全部分类</p>
        </a>

        @if(funcOpen('FUNC_BRAND'))
        <a href="/brands" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/default_03/g6.png') }}" alt="">
            </div>
            <p class="weui-grid__label">品牌街</p>
        </a>
        @endif
    

        
        <a href="/orders" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/default_03/g7.png') }}" alt="">
            </div>
            <p class="weui-grid__label">我的订单</p>
        </a>

        <a href="/usercenter" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/default_03/g8.png') }}" alt="">
            </div>
            <p class="weui-grid__label">个人中心</p>
        </a>
    </div>
    
    <!-- 限时秒杀 -->
    <?php
        $flashSaleProduct = flashSale(0, 3);
    ?>
    @if(funcOpen('FUNC_FLASHSALE') && $flashSaleProduct->count())
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
    @endif

    <!-- 拼团专区 -->
    <?php
        $teamSaleProduct = teamSale(0, 3);
    ?>
    @if(funcOpen('FUNC_TEAMSALE') && $teamSaleProduct->count())
    <div class="weui-cells">
        <div class="weui-cell weui-cell_access">
            <div class="weui-cell__bd title-img">
                <img src="{{ asset('images/default/index/piece.png') }}" style="vertical-align: middle; margin-right: 10px;"><span style="vertical-align: middle">拼团专区</span>
            </div>
            <a class="weui-cell__ft" href="/team_sale">去拼团</a>
        </div>
    </div>
    <div class="product-wrapper">
        @foreach ($teamSaleProduct as $element)
            <a class="product-item3" href="/product/{{ $element->product_id }}">
                <div class="img">
                    <img class="lazy" data-original="{{ $element->share_img }}">
                </div> 
                <div class="title">{{ $element->product_name }}</div>
                <div class="price">¥{{ $element->price }} <span>已拼{{ $element->sales_sum + $element->sales_sum_base }}件</span></div>
            </a>
        @endforeach
    </div>
    @endif

    <?php
        $newProducts = newProducts(0, 8);
    ?>
    @if(funcOpen('FUNC_PRODUCT_PROMP') && $newProducts->count())
        <div style="background-color: #fff;padding-top: 1.5rem; margin-top: 5px;">
            <div class="theme-title">
                <div class="content"><img src="{{ asset('images/default/index/like.png') }}" style="vertical-align: middle; margin-right: 10px;">新品推荐</div>
            </div>
        </div>
        
        
        <div class="product-wrapper">
            @foreach ($newProducts as $product)
                <a class="product-item2" href="/product/{{ $product->id }}">
                    <div class="img">
                        <img class="lazy" data-original="{{ $product->image }}">
                        @if($product->is_hot)<p class="hot">HOT</p>@endif
                    </div> 
                    <div class="title">{{ $product->name }}</div>
                    @if(empty($product->realPrice))
                        <div class="price">¥{{ $product->price }} <span>{{ $product->sales_count }}人购买</span></div>
                    @else
                        <div class="price">¥{{ $product->realPrice }} <span style="float: none; text-decoration: line-through;">¥{{ $product->price }}</span> <span>{{ $product->sales_count }}人购买</span></div>
                    @endif
                    
                </a>
            @endforeach
        </div>
    @endif

    
    <?php
        $prompProducts = prompProducts(0, 8);
    ?>

    @if(funcOpen('FUNC_PRODUCT_PROMP') && $prompProducts->count())
    <div style="background-color: #fff;padding-top: 1.5rem;">
        <div class="theme-title">
            <div class="content"><img src="{{ asset('images/default/index/promotion.png') }}" style="vertical-align: middle; margin-right: 10px;">促销活动</div>
        </div>
    </div>

    <div class="product-wrapper">
        @foreach ($prompProducts as $product)
            <a class="product-item2" href="/product/{{ $product->id }}">
                <div class="img">
                    <img class="lazy" data-original = "{{ $product->image }}">
                    @if($product->is_hot)<p class="hot">HOT</p>@endif
                </div> 
                <div class="title">{{ $product->name }}</div>
                @if(empty($product->realPrice))
                    <div class="price">¥{{ $product->price }} <span>{{ $product->sales_count }}人购买</span></div>
                @else
                    <div class="price">¥{{ $product->realPrice }} <span style="float: none; text-decoration: line-through;">¥{{ $product->price }}</span> <span>{{ $product->sales_count }}人购买</span></div>
                @endif

            </a>
        @endforeach
    </div>
    @endif

    <?php
        $products = products(0, 20);
    ?>
    <div style="background-color: #fff;padding-top: 1.5rem;">
        <div class="theme-title">
            <div class="content"><img src="{{ asset('images/default/index/all.png') }}">全部产品</div>
        </div>
    </div>

    <div class="product-wrapper scroll-container"  id="product-box">
        @foreach ($products as $product)
        <a class="product-item2 scroll-post" href="/product/{{ $product->id }}">
            <div class="img">
                <img class="lazy" data-original="{{ $product->image }}">
            </div> 
            <div class="title">{{ $product->name }}</div>
            @if(empty($product->realPrice))
                <div class="price">¥{{ $product->price }} <span>{{ $product->sales_count }}人购买</span></div>
            @else
                <div class="price">¥{{ $product->realPrice }} <span style="float: none; text-decoration: line-through;">¥{{ $product->price }}</span> <span>{{ $product->sales_count }}人购买</span></div>
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