@extends('front.default.layout.base')

@section('css')
    <style>
      .item-mask{
        display: none;
      }
      .product-title .icon{font-size:20px;}
      .icon.select-color{color:#ff4a44;}
      #iosDialog3{display: none;}
      #iosDialog3 .weui-dialog{background-color: #fff;padding:20px;text-align: center;border-radius: 7.5px;overflow: visible;}
      #iosDialog3 .close{position: absolute;top:-15.5px;right: -15.5px;display:block;width: 33px;height: 33px;border-radius: 50%;background-color: #e0e0e0;font-size: 30px;font-weight: normal;line-height: 1em;opacity: 1;color: #999;}
      #teamsale_user{font-size: 0.7rem; margin-top: 1rem;}
      #teamsale_timer{font-size: 0.6rem; margin-top: 15px;}
      #teamsale_num{color: red;}
      #menbers_list{text-align: center; margin-top: 1rem; margin-bottom: 0.75rem;}
      #menbers_list .img{display: inline-block;border-radius: 50%; width: 2rem; height: 2rem; border: 2px solid #fdb221;margin-right: 15px;}
      #menbers_list .img img{width: 100%;}
      #menbers_list .img:nth-child(1){}
      .canyu {height: 1.5rem; line-height: 1.5rem; background: red; color: #fff; margin-bottom: 0.75rem; margin-left: 1rem; margin-right: 1rem; font-size: 0.55rem;}

      .app-wrapper {
        padding-bottom: 50px;
      }

      /*#wrapper {
        width: 100%;
        position: absolute;
        left: 0;
        top: 46px;
        bottom: 0;
        z-index: 1;
      }*/

      .more {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px;
        color: #999
      }
      .more .flip {
          transform: rotate(180deg);
      }
      .pull_icon {
        transition: all .5s;
        font-size: 18px;
          /*width: 25px;
          height: 25px;
           background-image: url('http://www.jq22.com/demo/iscroll201803092307/images/pull.png');
          background-repeat: no-repeat;
          background-position: center;
          background-size: 25px;
          
          */
      }
      .more span {
          padding-left: .5rem;
      }

      .he_sustain{
        position: fixed;
        z-index: 55;
        left: 0;
        right: 0;
        top: 0;
      }

      #wrapper{
        overflow-y: auto;
      }
      /*#product-detail{
        display: none;
      }*/
    </style>
@endsection

@section('content')
  
  <!--  内容切换 -->
  <div class="he_sustain">
    <div class="classreturn loginsignup detail">
        <div class="content">
            <div class="ds-in-bl return">
                <a href="javascript:history.back(-1)"><i class="icon ion-ios-arrow-left"></i></a>
            </div>
            <div class="ds-in-bl search center" id="topcenter">
                <span class="tag_product active" onclick="anchorProduct()">商品</span>
                <span class="tag_detail" onclick="anchorDetail()">详情</span>
                <!--span>评论</span-->
            </div>
        </div>
    </div>
  </div>
  <div style="height: 46px;" id="topper"></div>
  <div class="content0" id="wrapper">
  {{-- <div class="scroller" id="scroller"> --}}
    @if($productImages->count())
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @foreach ($productImages as $element)
            <!-- Lazy image -->
            <a class="swiper-slide" @if($element->link) href="{{ $element->link }}" @else href="javascript:;" @endif>
                <img data-src="{{ $element->url }}" class="swiper-lazy">
                <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
            </a>
            @endforeach
        </div>
    </div>
    @else
      <img src="{{ $product->image }}" style="width: 100%;">
    @endif
    <!-- banner end -->

    <div id="product_detail">
      <!-- 标题价格 end  -->
      <div class="product-section-wrapper">
        <!-- 标题  -->
        <div class="product-header product-title weui-cell">
          <div class="product-name weui-cell__bd">{{ $product->name }}</div>
          <img src="{{ asset('images/default/dotted.png') }}" class='dotted-line' style='display:block;width:1px;height:35px;'>
          @if(funcOpen('FUNC_COLLECT'))
          <span class="collection weui-cell__ft" data-id="{!! $product->id !!}">
            <div><i class="icon {!! getCollectionStatus($product->id)?'ion-android-star select-color':'ion-android-star ' !!}"></i></div>
            <span>{!! getCollectionStatus($product->id)?'已收藏':'未收藏' !!}</span>
          </span>
          @endif
        </div>
        <!-- 标题 end -->

        <!-- 价格  -->
        <div class="product-price">

          @if($product->prom_type == 1 && $promp->status == '进行中')
          抢购价格:
          @endif

          @if($product->prom_type == 5)
          拼团价格:
          @endif

          @if($product->prom_type == 3 && $promp->status == '进行中')
          促销价:
          @endif

          ¥{{$product->realPrice}}

          @if($product->prom_type == 5 || ($product->prom_type == 1 && $promp->status == '进行中') || ($product->prom_type == 3 && $promp->status == '进行中'))
            <span class="original-price">原价：¥{{$product->price}}</span>
          @endif
        </div>
        
        <div class="second-price">
          @if ($product->prom_type == 0 && $product->market_price)
            <div>市场价: <span>¥{{$product->market_price}}</span></div>
          @endif

          <div>已售: {{ $product->sales_count }}</div>

          @if($product->inventory != -1)
              <div>库存: <span>{{$product->inventory}}</span></div>
          @endif
        </div>
        <!-- 价格 end  -->
      </div>
      <!-- 标题价格 end  -->

      <div class="line"></div>
      
      <!-- 选择规格  -->
      <div class="product-section-wrapper" id="guige-selector">
        <div class="weui-cells" style="margin-top: 0;">
          <a class="weui-cell weui-cell_access" onclick="chooseItem(0, 0)">
            <div class="weui-cell__bd">
                <p>选择规格</p>
            </div>
            <div class="weui-cell__ft">
            </div>
          </a>
        </div>
      </div>
      <!-- 选择规格 end  -->
      
      <!-- 服务承诺  -->
      <div class="promise">
        @foreach ($words as $word)
          <div class="promise-item"><i class="icon ion-ios-checkmark-outline"></i>{{ $word->name }}</div>
        @endforeach
      </div>
      <!-- 服务承诺 end  -->

      <!-- 拼团信息  -->
      @if($teamFounders->count())
        <div class="product-section-wrapper">
          <div class="weui-cells" style="margin-top: 3px;">
              <a class="weui-cell">
                  <div class="weui-cell__bd">
                      <p>{{ $teamFounders->count() }}人正在拼单，可直接参与</p>
                  </div>
              </a>
          </div>
          @foreach($teamFounders as $teamFounder)
            <div class="pin-team"  data-id="{{ $teamFounder->id }}" data-teamuser="{{ $teamFounder->nickname }}" data-haicha="{{ $teamFounder->need_mem - $teamFounder->join_num }}" data-endtime="{{ $teamFounder->time_end }}">
              <img src="{{ $teamFounder->head_pic }}" alt="">
              <div style="display: inline-block;">{{ $teamFounder->nickname }}</div>
              <div class="qupin">去拼单</div>
              <div class="time">
                <div class="haicha">还差{{ $teamFounder->need_mem - $teamFounder->join_num }}人拼成</div>
                <div class="haisheng" data-time="{{ $teamFounder->time_end }}">剩余{{ $teamFounder->time_end }}</div>
              </div>
            </div>
          @endforeach
        </div>
      @endif
      
      <div id="product-detail">
        <!-- 产品参数 -->
        @if ($attrs->count())
          <div class="product-paras">
            <table>
              @foreach($attrs as $attr)
              <tr>
                <td class="attr-name">{{ $attr->name }}</td>
                <td>{{ $attr->value }}</td>
              </tr>
              @endforeach
            </table>
          </div>
        @endif
        <!-- 产品参数 end -->
        
        <!-- 产品详情 -->
        <div class="product-intro" id="product-intro">
          <?php
            $content = $product->intro;
            $resultStr =  preg_replace('/img src=/', 'img class="lazy" data-original=', $content);
          ?>
          {!! $resultStr !!}
        </div>
        <!-- 产品详情 end -->

        <!-- 底部信息 -->
        <div id="shopinfo">
          @include('front.'.theme()['name'].'.layout.shopinfo')
        </div>
        <!-- 底部信息 end -->
      </div>
    </div>
  {{-- </div> --}}
</div>

<!-- 商品详情
<div class="content1" style="display: none;">
  <div class="switcher">
    <div class="intro active" onclick="showIntro()">商品详情</div>
    <div class="paras" onclick="showPara()">规格参数</div>
  </div>
</div>
 -->
  <!-- 弹出商品规格选择框 -->
  <div class="item-mask" style="z-index: 9999999;">
    <div class="item-mark2" onclick="closeChoose()"></div>
    <div class="chooseDimension">
      <!-- 商品基本信息展示 -->
      <div class="header" id="header">
        <div class="image"><img src="{{$product->image}}" alt="" id="product_image"></div>
        <div id="product_price">¥{{$product->realPrice}} </div>
        <div style="overflow: hidden;">
          <div id="product_name">{{$product->name}}</div>
          @if($product->inventory != -1)<div id="product_inventor">库存: {{$product->inventory}}</div>@endif
        </div>
      </div>
      <!-- 商品基本信息展示 end -->

      <!-- 商品规格列表 -->
      <div class="maleri30">
        @if(!empty($filter_spec))
            @foreach ($filter_spec as $key => $spec)
              <div class="shulges p choicsel">
                  <p>{{$key}}</p>
                  <!--商品属性值-s-->
                  @foreach ($spec as $k2 => $v2)
                      <div class="plus choic-sel">
                          <a id="goods_spec_a_{{$v2['item_id']}}" title="{{$v2['item']}}"
                             onclick="switch_spec(this);">
                      <input id="goods_spec_{{$v2['item_id']}}" type="radio" style="display:none;" name="goods_spec[{{$key}}]" value="{{$v2['item_id']}}"/>{{$v2['item']}}</a>
                  </div>
                  @endforeach
              </div>
            @endforeach
          @endif
      </div>
      <!-- 商品规格列表 end -->

      <!-- 设置购买数量 -->
      <div class="counter-wrapper product-cell">
        <span>购买数量</span>
        <div class="counter">
          <div class="fa fa-minus" style="float:left;" onclick="cartdel()"></div>
          <input type="number" value="1" id="shop_count" oninput="changeVale(this.value)" onpropertychange="changeVale(this.value)">
          <div class="fa fa-plus" style="float:left;" onclick="cartadd()"></div>
        </div>
      </div>
      <!-- 设置购买数量 end -->

      <!-- 底部按钮 -->
      <div>
        <!-- 秒杀进行时，或者是团购 只能立即购买，不能先加入购物车再结算 -->
        @if( ($product->prom_type == 1 && $promp->status == '进行中') || $product->prom_type == 5 )

          <style type="text/css">
            .chooseDimension .buynow{width: 100%;}
            .chooseDimension .addcart{display: none;}
          </style>
        @endif

        <!-- 处理商品规格为0时，不能购物 -->
        <input type="button" value="加入购物车" class="addcart" onclick="gouwuche()"></input>
        <input type="button" value="立即购买" class="buynow" onclick="buynow()"></input>
      </div>
      <!-- 底部按钮 end -->
    </div>
  </div>
  <!-- 弹出商品规格选择框 end -->

  <!-- 底部购买按钮 -->
  <div class="checkwrapper product-checker">
    <a class="home checker-left-item" href="/">
      <div class="image"><i class="icon ion-home"></i></div>
      <div class="name">首页</div>
    </a>
    <a class="home checker-left-item" href="/cart">
      <div class="image"><i class="icon ion-ios-cart"></i></div>
      <div class="name">购物车</div>
    </a>
    <a class="home checker-left-item" href="/kefu">
      <div class="image"><i class="icon ion-android-chat"></i></div>
      <div class="name">客服</div>
    </a>
    
    <!-- 无促销或者商品促销 -->
    @if (empty($product->prom_type) || $product->prom_type == 3)
      <div class="right-botton01" onclick="chooseItem({{ $product->prom_type }}, 0)">加入购物车</div>
    @endif

    <!-- 拼团 -->
    @if ($product->prom_type == 5)
      <div class="right-botton01" onclick="startTeam()">
        <div class="floor">¥{{ $promp->price }}</div>
        <div class="floor">发起拼单</div>
      </div>
      <div class="right-botton02" onclick="chooseItem(0, 0)">
        <div class="floor">¥{{ $product->price }}</div>
        <div class="floor">单独购买</div>
      </div>
    @endif

    <!-- 秒杀 -->
    @if ($product->prom_type == 1)
      @if($promp->status == '进行中')
        <div class="right-botton01" onclick="chooseItem(0, 0)">加入购物车</div>
      @else
        <div class="right-botton01" onclick="chooseItem(1, {{ $product->prom_id }})">立刻抢购</div>
      @endif 
    @endif
  </div>
  
  <!-- 参与拼单提示 -->
  <div class="js_dialog product-pintuan-team" id="iosDialog3">
      <div class="weui-mask"></div>
      <div class="weui-dialog">
          <div class="close" onclick="closeTeam()">x</div>
          <div id="teamsale_user">参与某某的拼单</div>
          <div >仅剩<span id="teamsale_num">1</span><span id="teamsale_timer">剩余</span></div>
          <div id="menbers_list">
            <div id="founder-header" class="img active">
              <img src="http://temp.im/80x80/333/EEE" alt="">
            </div>
          </div>
          <div class="canyu" onclick="joinTeamConfirm()">参与拼单</div>
      </div>
  </div>

@endsection

@section('js')

  <!-- 下拉刷新 
  <script src="{{ asset('vendor/iscroll.js') }}"></script>-->

  <script src="{{ asset('vendor/jquery.scrollTo.min.js') }}"></script>
  
  <script type="text/javascript">

    //将正文图片缓加载
    

    // var myscroll = new iScroll("wrapper",{
    //   onScrollMove:function(){
    //     //(this.maxScrollY)
    //     console.log((this.y + 35));
    //     if ((this.y + 35) < 0) {
    //       $('.pull_icon').addClass('flip');
    //       $('#more span').text('可以松开了...');
    //     }else{
    //       $('.pull_icon').removeClass('flip loading');
    //     }

    //   },
    //   onScrollEnd:function(){
    //     if ($('.pull_icon').hasClass('flip')) {
    //       $('#more').hide();
    //       $('#product-detail').fadeIn(200);
    //       $('#wrapper').css('overflow', 'auto');
    //       myscroll.destroy();
    //       location.href = "#product-detail";
          
    //     }
    //   },

    //   onRefresh:function(){
    //     $('.more').removeClass('flip');
    //   }
      
    // });

    function anchorDetail(){
      $('#topcenter span').removeClass('active');
      $('.tag_detail').addClass('active');
      //显示详情区域
      // $('.more').hide();
      // $('#product-detail').show();

      //$('#wrapper').scrollTo('#product-detail', 500); 
      $.scrollTo('#guige-selector',500);
    }

    function anchorProduct(){
      $('#topcenter span').removeClass('active');
      $('.tag_product').addClass('active');
      //显示详情区域
      $.scrollTo('#topper', 500); 
    }

    //页面顶部切换样式
      // $('#topcenter span').on('click', function(){
      //   $('#topcenter span').removeClass('active');
      //   $(this).addClass('active');
      //   $('.content0, .content1').hide();
      //   $('.content' + $(this).index()).show();
      //   console.log('.content' + $(this).index());
      // });
    
    // if ($('.scroller').height()<$('#wrapper').height()) {
    //   $('.more').hide();
    //   myscroll.destroy();
    // }

  
  </script>

  @if(Config::get('web.app_env') == 'product')
  <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript" charset="utf-8">
      wx.config({!! $app->jssdk->buildConfig(array('onMenuShareTimeline', 'onMenuShareAppMessage'), false) !!});
      wx.ready(function(){
        wx.onMenuShareTimeline({
          title: '{{ $product->name }}', // 分享标题
          link: window.location.href, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
          imgUrl: '{{ $product->image }}', // 分享图标
          success: function () {
          // 用户确认分享后执行的回调函数
          },
          cancel: function () {
          // 用户取消分享后执行的回调函数
          }
        });
        wx.onMenuShareAppMessage({
          title: '{{ $product->name }}', // 分享标题
          desc: '{{ $product->remark }}', // 分享描述
          link: window.location.href, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
          imgUrl: '{{ $product->image }}', // 分享图标
          success: function () {
          // 用户确认分享后执行的回调函数
          },
          cancel: function () {
          // 用户取消分享后执行的回调函数
          }
        });
      });
  </script>
  @endif
  <script>
    //商品购买数量
    var count = 1;
    //商品规格ID
    var specPriceItemId = 0;
    //商品规格
    var specPriceItem = null;
    //商品ID
    var product_id = {{$product->id}};
    //商品价格
    var product_price = {{$product->price}};
    // 商品库存
    var product_inventory = {{$product->inventory}};
    //规格价格
    var spec_goods_prices = {!!$spec_goods_price!!};
    //促销活动类型
    var prom_type = 0;
    //促销活动id
    var prom_id = 0;
    //优惠购买，还是原价购买，主要针对拼团是否单独购买，false是单独购买 true是拼团
    var buyType = true;
    //用户想参与的团
    var join_team = {{ $join_team }};
    //开团还是参团 0开团 1参团
    var startOrJoin = {{ $start_or_Join }};

    function showProductDetail(offset_top = 650){
      if(($(window).scrollTop() > (offset_top + $('#product-intro').outerHeight()))||(($(window).scrollTop() + $(window).height()) < offset_top)){
          console.log('out');
        }else{
          console.log('in');
          $('#product-intro').show();
        }
    }

    $(document).ready(function () {

      //是否显示商品详情
      // setTimeout(showProductDetail, 2000);
      // document.querySelector('body').onscroll = function(e) { 
      //   showProductDetail( $('#product-intro').offset().top );
      // };

      //默认选择第一个规格
      if (spec_goods_prices.length) {
        specPriceItem = spec_goods_prices[0];
        specPriceItemId = specPriceItem.id;
      }

      //初始化选择第一个规格
      initFirstSpec();

      //检查商品的库存，如果库存不够，则不能购买
      checkInventory();   

      //如果是用户参与拼团，则自动打开规格选择
      if (startOrJoin ==1 && join_team > 0) {
        joinTeamConfirm();
      }
    });

    function checkInventory() {
      if (spec_goods_prices.length) {
        //有规格信息，购买按钮的状态在initGoodsPrice中设置
      }else{
        //没有规格信息
        if (product_inventory == 0) {
          $('.buynow, .addcart').attr('disabled', 'disabled');
        }
      }
    }

    function initFirstSpec(){
        $('.choicsel').each(function (i, o) {
            var firstSpecRadio = $(this).find("input[type='radio']").eq(0);
            firstSpecRadio.attr('checked','checked');
            firstSpecRadio.parents('.choic-sel').find('a').eq(0).addClass('red');
        })
        initGoodsPrice();
    }

    function switch_spec(spec) {
        $(spec).parent().parent().find('a').removeClass('red');
        $(spec).addClass('red');
        $(spec).parent().parent().find('input').removeAttr('checked');
        $(spec).children('input').attr('checked', 'checked');
        //商品价格库存显示
        initGoodsPrice();
    }

    function sortNumber(a,b)
    {
        return a - b;
    }

    function getSpecPriceByKey(key) {
      for (var i = 0; i < spec_goods_prices.length; i++) {
        if (spec_goods_prices[i].key == key) {
          return spec_goods_prices[i];
        }
      }
    }

    function initGoodsPrice() {
      //购买商品数量
      var goods_num = count;

      if (!$.isEmptyObject(spec_goods_prices)) {
        var goods_spec_arr = [];
        //被选中的规格
        $("input[name^='goods_spec']").each(function () {
            if($(this).attr('checked') == 'checked'){
                goods_spec_arr.push($(this).val());
            }
        });
        //组合成spec_price key
        var spec_key = goods_spec_arr.sort(sortNumber).join('_');  //排序后组合成 key
        //获取spec_price_item
        specPriceItem = getSpecPriceByKey(spec_key);

        //规格信息不存在
        if (specPriceItem) {
          specPriceItemId = specPriceItem.id;
          $('#product_image').attr('src', specPriceItem.image);
          if (buyType) {
            $('#product_price').text('¥' + specPriceItem.realPrice);
          } else {
            $('#product_price').text('¥' + specPriceItem.price);
          }
          $('#product_name').text(specPriceItem.key_name);
          $('#product_inventor').text('库存: ' + specPriceItem.inventory);

          //没有库存不能购买
          if (parseInt(specPriceItem.inventory) <= 0) {
            $('.buynow, .addcart').attr('disabled', 'disabled');
            $('.buynow, .addcart').addClass('noinventory')
            $('.chooseDimension .buynow').val('没有库存');
            $('.chooseDimension .addcart').val('没有库存');
            
          }else{
            $('.buynow, .addcart').removeAttr('disabled');
            $('.buynow, .addcart').removeClass('noinventory')
            $('.chooseDimension .buynow').val('立即购买');
            $('.chooseDimension .addcart').val('加入购物车');
          }
          //是否促销或者拼团
          if (specPriceItem.prom_type == null) {
            prom_type = 0;
            prom_id = 0;
          }else{
            prom_type = specPriceItem.prom_type;
            prom_id = specPriceItem.prom_id;
          }
        }else{
          $('.buynow, .addcart').attr('disabled', 'disabled');
          $('.buynow, .addcart').addClass('noinventory')
          $('.chooseDimension .buynow').val('没有库存');
          $('.chooseDimension .addcart').val('没有库存');
        }
        
        resetButton();
      }
    }

    //打开购买弹窗
    function chooseItem(promp_type, id) {
      //团购时，选择单独购买则按原价购买
      if (spec_goods_prices.length == 0) {
        //无规格的商品
        if (promp_type) {
          buyType = true;
          $('#product_price').text('¥{{ $product->realPrice }}');
        }
        else {
          buyType = false;
          $('#product_price').text('¥{{ $product->price }}');
        }
      }else{
        if (promp_type) {
          buyType = true;
        }
        else {
          buyType = false;
        }
        initGoodsPrice();
      }
      prom_type = promp_type;
      prom_id = id;
      resetButton();
      $('.item-mask').fadeIn(300);
    }
    //关闭购买弹窗
    function closeChoose() {
      $('.item-mask').fadeOut(300);
    }
    //重置购物按钮显示
    function resetButton () {
      if ( prom_type == 1 && (!specPriceItem || (specPriceItem && specPriceItem.prom_type == 1)) ) {
        $('.chooseDimension .buynow').css('width', '100%');
        $('.chooseDimension .addcart').hide();
        $('.chooseDimension .buynow').text('立即抢购');
      }else if(prom_type == 5 && buyType && (!specPriceItem || (specPriceItem && specPriceItem.prom_type == 5)) ){
        $('.chooseDimension .buynow').css('width', '100%');
        $('.chooseDimension .addcart').hide();
        if (startOrJoin == 0) {
          $('.chooseDimension .buynow').text('发起拼单');
        } else {
          $('.chooseDimension .buynow').text('参与拼单');
        }
        
      }else{
        $('.chooseDimension .buynow').css('width', '50%');
        $('.chooseDimension .addcart').show();
        $('.chooseDimension .buynow').text('立即购买');
      }
    }
    //修改购买数量
    function cartdel() {
      --count;
      if (count < 1) {count = 1;}
      $('#shop_count').val(count);
    }
    //修改购买数量
    function cartadd() {
      ++count;
      if (count > 99) {count = 99;}
      $('#shop_count').val(count);
    }
    //修改购买数量
    function changeVale(value) {
      count = value;
      if (count < 1) {count = 1;}
      if (count > 99) {count = 99;}
      $('#shop_count').val(count);
    }

    //立即购买
    function buynow() {
      if (buyType) {
        if (prom_type == 1 || prom_type == 5) {
          //立即购买，不加入购物车
          buyImmediate();
        } else {
          //加入购物车后购买
          gouwucheThenCart();
        }
      } else {
        gouwucheThenCart();
      }
      
    }
    //秒杀和拼团的立即购买
    function buyImmediate() {
      window.location.href="/checknow?specPriceItemId="+specPriceItemId+'&count='+count+'&product_id='+product_id+'&prom_type='+prom_type+'&prom_id='+prom_id+'&join_team='+join_team+'&start_or_Join='+startOrJoin;
    }

    //立即购买
    function gouwucheThenCart() {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          url:"/api/cart/add",
          type:"GET",
          data:'specPriceItemId='+specPriceItemId+'&count='+count+'&product_id='+product_id,
          success: function(data) {
              if (data.code) {
                layer.open({
                  content: data.message
                  ,skin: 'msg'
                  ,time: 2 //2秒后自动关闭
                });
                // $('#iosDialog2 .weui-dialog__bd').text(data.message);
                // $('#iosDialog2').fadeIn(200);
              }else{
                if (data.message.qty < count) {
                  layer.open({
                    content: '库存不足'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                  });
                } else {
                  window.location.href="/cart";
                }
                
              }
          },
          error: function(data) {
              //提示失败消息

          },
      });
    }

    //加入购物车
    function gouwuche() {

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          url:"/api/cart/add",
          type:"GET",
          data:'specPriceItemId='+specPriceItemId+'&count='+count+'&product_id='+product_id,
          success: function(data) {
              if (data.code) {
                layer.open({
                  content: data.message
                  ,skin: 'msg'
                  ,time: 2 //2秒后自动关闭
                });
              }else{
                if (data.message.qty < count) {
                  layer.open({
                    content: '库存不足'
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                  });
                } else {
                  //$('#iosDialog1').fadeIn(200);
                  layer.open({
                    content: '已为您添加到购物车'
                    ,btn: ['去购物车结算', '继续购物']
                    ,yes: function(index){
                      window.location.href = '/cart';
                      layer.close(index);
                    }
                    ,no: function(index){
                      $('.item-mask').fadeOut();
                    }
                  });
                }
                
              }

          },
          error: function(data) {
              //提示失败消息

          },
      });
      
    }

    //显示商品详情
    function showIntro(){
      $('.product-intro').show();
      $('.intro').addClass('active');
      $('.product-paras').hide();
      $('.paras').removeClass('active');
    }
    //显示参数
    function showPara() {
      $('.product-intro').hide();
      $('.intro').removeClass('active');
      $('.product-paras').show();
      $('.paras').addClass('active');
    }
    //加入拼团
    function joinTeam(team_id) {
      $('#iosDialog3').fadeIn(200);
      join_team = team_id;
      startOrJoin = 1;
    }
    //开团
    function startTeam() {
      startOrJoin = 0;
      chooseItem(5, {{ $product->prom_id }});
    }
    function closeTeam() {
      $('#iosDialog3').fadeOut(200);
    }
    function joinTeamConfirm() {
      $('#iosDialog3').fadeOut(200);
      if (specPriceItem == null) {
        chooseItem(5, {{ $product->prom_id }});
      } else {
        chooseItem(5, specPriceItem.id)
      }
    }
    var timer_kongzhi;
    var timer_start=false;
    //倒计时
    $(function(){
      $('.haisheng').each(function(){
          var end_time=$(this).data('time');
          startShowCountDown(end_time,this,'teamsale');
      });

      $('.pin-team').click(function(){
        var team_id = $(this).data('id');
        var team_user = $(this).data('teamuser');
        var haicha = $(this).data('haicha');
        var end_time = $(this).data('endtime')
        var img_src = $(this).find('img').attr('src');
        $('#teamsale_user').text('参与'+team_user+'的拼单');
        $('#teamsale_num').text(haicha);
        if(timer_start){
          window.clearTimeout(timer_kongzhi);
        }
        timer_kongzhi=startShowCountDown(end_time,'#teamsale_timer','teamsale');
        timer_start=true;

        $('#founder-header').attr('src', img_src);
        joinTeam(team_id);
      });

      //收藏商品
      $('.collection').click(function(){
          var product_id=$(this).data('id');
          var that=this;
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          $.ajax({
              url:"/ajax/collect_or_cancel/"+product_id,
              type:"POST",
              success:function(data){
                console.log(data);
                if(data.code == 0){
                    layer.open({
                      content: '已收藏'
                      ,skin: 'msg'
                      ,time: 2 
                    });
                    $(that).children('span').text('已收藏');
                    $(that).find('i').attr('class','icon ion-android-star select-color');
                }else if(data.code == 3){
                    layer.open({
                      content: '未收藏'
                      ,skin: 'msg'
                      ,time: 2 
                    });
                    $(that).children('span').text('未收藏');
                    $(that).find('i').attr('class','icon  ion-android-star');
                }else{
                  layer.open({
                    content:data.message
                    ,skin: 'msg'
                    ,time: 2 
                  });
                }
              }

          });
        });
    });
  </script>
@endsection