@extends('front.default.layout.base')

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

    @include('front.common.search.html')

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

    <div class="weui-grids index-function-grids">
        <a href="/category" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/default/index/grid1.png') }}" alt="">
            </div>
            <p class="weui-grid__label">全部分类</p>
        </a>
        @if(funcOpen('FUNC_BRAND'))
        <a href="/brands" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/default/index/grid2.png') }}" alt="">
            </div>
            <p class="weui-grid__label">品牌街</p>
        </a>
        @endif

        @if(funcOpen('FUNC_PRODUCT_PROMP'))
        <a href="/product_promp" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/default/index/grid3.png') }}" alt="">
            </div>
            <p class="weui-grid__label">优惠活动</p>
        </a>
        @endif

        @if(funcOpen('FUNC_TEAMSALE'))
        <a href="/team_sale" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/default/index/grid4.png') }}" alt="">
            </div>
            <p class="weui-grid__label">团购</p>
        </a>
        @endif
        
        @if(funcOpen('FUNC_FLASHSALE'))
        <a href="/flash_sale" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/default/index/grid5.png') }}" alt="">
            </div>
            <p class="weui-grid__label">秒杀专场</p>
        </a>
        @endif
    
        @if(funcOpen('FUNC_COUPON'))
        <a href="/coupon" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/default/index/grid6.png') }}" alt="">
            </div>
            <p class="weui-grid__label">优惠券</p>
        </a>
        @endif
        
        <a href="/orders" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/default/index/grid7.png') }}" alt="">
            </div>
            <p class="weui-grid__label">我的订单</p>
        </a>
        <a href="/usercenter" class="weui-grid">
            <div class="weui-grid__icon">
                <img src="{{ asset('images/default/index/grid8.png') }}" alt="">
            </div>
            <p class="weui-grid__label">个人中心</p>
        </a>
    </div>

    <!-- 领券购物，没有则不显示 -->
    @if(funcOpen('FUNC_COUPON') && $coupons->count())
        <div class="weui-cells">
            <div class="weui-cell weui-cell_access">
                <div class="weui-cell__bd title-img">
                    <img src="{{ asset('images/default/index/free.png') }}" style="vertical-align: middle; margin-right: 10px;"><span style="vertical-align: middle">先领取再购物</span>
                </div>
            </div>
            <div class="weui-cell">
                <div id='coupon'>
                    <div class="coupon-warp">
                    @foreach ($coupons as $item)
                        <div class="swipe-item">
                            <div class="weui-cell-fl"></div>
                            <div class="weui-cell-fr"></div>
                            <div class="box">
                                @if($item->type == '打折')
                                    <div class="flex-item price-num"><span class="num">{!! $item->discount!!}</span><span class="price-symbol discount">折</span></div>
                                @endif

                                @if($item->type == '满减')
                                    <div class="flex-item price-num"><span class="price-symbol">¥</span><span class="num">{!! $item->given!!}</span></div>
                                @endif
                                <div class="flex-item price-info">
                                    <p class="price-name">{!! $item->name !!}</p>
                                    <p class="price-condition">满{!! $item->base !!}使用</p>
                                    <a class="price-btn" @if(getUsersWhetherHaveCoupons($item->id)) style="background-color:#ddd !important" @endif data-id="{!! $item->id !!}" data-status="{!! getUsersWhetherHaveCoupons($item->id) !!}">{!! getUsersWhetherHaveCoupons($item->id)?'已领取':'立即领取' !!}</a>
                                </div>
                            </div>
                            <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                        </div>
                     @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="weui-panel__bd index-recommend-cat">
        @foreach ($categories as $category)
            <a href="/category/level{{ $category->level }}/{{ $category->id }}" class="weui-media-box weui-media-box_appmsg">
                <div class="weui-media-box__hd">
                    <img class="weui-media-box__thumb" src="{{ $category->image }}" alt="">
                </div>
                <div class="weui-media-box__bd">
                    <h4 class="weui-media-box__title">{{ $category->name }}</h4>
                    <p class="weui-media-box__desc">{{ $category->brief }}</p>
                </div>
            </a>
        @endforeach
    </div>
    
    
    <?php
        $flashSaleProduct = flashSale(0, 3);
    ?>
    @if(funcOpen('FUNC_FLASHSALE') && $flashSaleProduct->count())
    <div class="weui-cells">
        <div class="weui-cell weui-cell_access">
            <div class="weui-cell__bd title-img">
                <img src="{{ asset('images/default/index/miaosha.png') }}" style="vertical-align: middle; margin-right: 10px;">
                <span style="vertical-align: middle">限时秒杀</span> 
            </div>
            <a class="weui-cell__ft" href="/flash_sale">更多</a>
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
    
    <?php
        $teamSaleProduct = teamSale(0, 3);
    ?>
    @if(funcOpen('FUNC_TEAMSALE') && $teamSaleProduct->count())
    <div class="weui-cells">
        <div class="weui-cell weui-cell_access">
            <div class="weui-cell__bd title-img">
                <img src="{{ asset('images/default/index/piece.png') }}" style="vertical-align: middle; margin-right: 10px;"><span style="vertical-align: middle">拼团专区</span>
            </div>
            <a class="weui-cell__ft" href="/team_sale">更多</a>
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

    <!-- 专题 -->
    <!--
    <div style="background-color: #fff;padding-top: 1.5rem;">
        <div class="theme-title">
            <div class="content"><img src="{{ asset('images/default/index/sift.png') }}" style="vertical-align: middle; margin-right: 10px;">精选专题</div>
        </div>
    </div>

    <div class="theme-item">
        <img src="{{ asset('images/default/index/sift1.jpg') }}">
        <div class="title oneline">一键接听，4.0蓝牙高清语音通话 <span>¥16.58</span></div>
        <div class="subtitle oneline">专题描述</div>
    </div>
    <div class="theme-item">
        <img src="{{ asset('images/default/index/sift2.jpg') }}">
        <div class="title oneline">一键接听，4.0蓝牙高清语音通话 <span>¥16.58</span></div>
        <div class="subtitle oneline">专题描述</div>
    </div>
    <div class="theme-item">
        <img src="{{ asset('images/default/index/sift3.jpg') }}">
        <div class="title oneline">一键接听，4.0蓝牙高清语音通话 <span>¥16.58</span></div>
        <div class="subtitle oneline">专题描述</div>
    </div>
    -->
    <!-- 新品推荐 -->
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
    
    <div style="display: none;" id="shopinfo">
        @include('front.'.theme()['name'].'.layout.shopinfo')
    </div>
    @include(frontView('layout.nav'), ['tabIndex' => 1])
@endsection


@section('js')

<script src="{{ asset('vendor/doT.min.js') }}"></script>
<script src="{{ asset('vendor/underscore-min.js') }}"></script>

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

    @include('front.common.search.js')
</script>
@endsection