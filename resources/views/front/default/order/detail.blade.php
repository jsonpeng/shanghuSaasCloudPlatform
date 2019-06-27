@extends('front.default.layout.base')

@section('css')
    <style>
      .pay-selector .close{
            background-image: url({{ asset('images/close-product.png') }}); 

        }
        .pay-weixin{background-image: url({{ asset('images/pay-weixin.png') }})}
        .pay-ali{background-image: url({{ asset('images/pay-alipay.png') }})}
        .pay-union{background-image: url({{ asset('images/pay-union.png') }})}
        .pay{display: none;}

        .app-wrapper{padding-bottom: 50px;}

        #iosActionsheet{z-index: 666666;}
    </style>
@endsection

@section('content')
  <div class="nav_tip">
    <div class="img">
      <a href="/orders"><i class="icon ion-ios-arrow-left"></i></a></div>
    <p class="titile">订单详情</p>
  </div>
  <div>
    
    @if($order->order_status == '无效')
      <div class="order-status weui-cell">
        <div class="weui-cell__hd">
          <div class="title">无效订单</div>
          <div class="tips"></div>
        </div>
        <div class="weui-cell__ft">
          <img src="{{ asset('images/default/fail.png') }}" alt="">
        </div>
      </div>
    @elseif($order->order_status == '已取消')
      <div class="order-status weui-cell">
        <div class="weui-cell__hd">
          <div class="title">订单已取消</div>
          <div class="tips"></div>
        </div>
        <div class="weui-cell__ft">
          <img src="{{ asset('images/default/fail.png') }}" alt="">
        </div>
      </div>
    @else
      @if ($order->order_pay == '未支付')
        <div class="order-status weui-cell">
          <div class="weui-cell__hd">
            <div class="title">等待买家付款</div>
            <div class="tips">
              剩余时间 :
              <span style="padding-left: 20px;" id="left-time" addtime="{{$order->created_at}}" auto_order_cancel="0.01" data-order="{{$order->id}}"></span>
            </div>
          </div>
          <div class="weui-cell__ft">
            <img src="{{ asset('images/default/clock.png') }}" alt="">
          </div>
        </div>
      @else
        @if($order->order_delivery == '未发货')
          <div class="order-status weui-cell">
            <div class="weui-cell__hd">
              <div class="title">待商家发货</div>
              <div class="tips"></div>
            </div>
            <div class="weui-cell__ft">
              <img src="{{ asset('images/default/clock.png') }}" alt="">
            </div>
          </div>
        @endif

        @if($order->order_delivery == '已发货')
          <div class="order-status weui-cell">
            <div class="weui-cell__hd">
              <div class="title">商家已发货，待用户确认</div>
              <div class="tips"></div>
            </div>
            <div class="weui-cell__ft">
              <img src="{{ asset('images/default/clock.png') }}" alt="">
            </div>
          </div>
        @endif

        @if($order->order_delivery == '已收货')
          <div class="order-status weui-cell">
            <div class="weui-cell__hd">
                <div class="title">已完成</div>
                <div class="tips"></div>
            </div>
            <div class="weui-cell__ft">
                <img src="{{ asset('images/default/done.png') }}" alt="">
            </div>
          </div>
        @endif

        @if($order->order_delivery == '退换货')
          <div class="order-status weui-cell">
            <div class="weui-cell__hd">
                <div class="title">退换货</div>
                <div class="tips"></div>
            </div>
            <div class="weui-cell__ft">
                <img src="{{ asset('images/default/clock.png') }}" alt="">
            </div>
          </div>
        @endif        
      @endif
    @endif
    
    
    <div class="user-address no-border">
      <img src="{{ asset('images/default/location.png') }}" class="address-icon">
      <div class="address-content">
          <h4 class="name">{{$order->customer_name}} {{$order->customer_phone}}</h4>
          <p class="address">{{$order->customer_address}}</p>
      </div>
      <a class="select" href="/address/change?backupcheck=1">修改</a>
    </div>

    @if(funcOpen('FUNC_TEAMSALE') && $order->prom_type == 5 && $order->order_pay == '已支付')
      <?php
          $teamFound = $order->teamFound;
          $teamFollow = $order->teamFollow()->take(3)->get();
      ?>
      @if ($teamFound->need_mem > $teamFound->join_num)
      <div class="team-status" style="font-size: 14px;">待分享，还差 {{ $teamFound->need_mem - $teamFound->join_num }}人，<span id="teamsale_timer" data-endtime="{{ $teamFound->time_end }}" style="font-size: 14px;">剩余</span></div>
      @endif
      
      <div class="order-user-list" style="overflow: hidden;">
      
        <div class="img-circle pin"><img src="{{$teamFound->head_pic}}" onerror="this.src= '/images/default.jpg' "></div>
        @foreach ($teamFollow as $element)
          <div class="img-circle"><img src="{{$element->head_pic}}" onerror="this.src= '/images/default.jpg' "></div>
        @endforeach
        
        @if ($teamFound->need_mem > $teamFound->join_num)
          <div class="invite-button" onclick="invite()">邀请好友</div>
        @endif
      </div>
      
    @endif

    <div class="no-mt">
      <div class="order-item mb0">
        @foreach($order->items as $item)
          <div class="zcjy-product-check">
            <img src="{{ $item->pic }}" class="productImage" onerror="this.src= '/images/default.jpg' ">
            <div class="product-name">{{ $item->name }}</div>
            <div class="remark">{{ $item->unit}}</div>
            <div class="price" style="overflow: hidden;"> <span style="float: left;color:#333;">¥{{$item->price}}</span> <span style="float: right; margin-right: 0.75rem;">x{{ $item->count }}</span></div>
          </div>
          @if(funcOpen('FUNC_AFTERSALE'))
            <!-- 未确认收货 -->
            @if ($order->order_pay == '已支付' && $order->order_status != '已取消' && $order->order_delivery != '已收货')
            <div class="returnback weui-cell">
              <div class="weui-cell__bd"></div>
              <div onclick="refundItem({{ $item->id}})" class="weui-cell__ft">退换货</div>
            </div>
            @endif
            
            <!-- 已确认收货 -->
            @if ($order->order_pay == '已支付' && $order->afterSale)
              <div class="aftersale weui-cell">
                  <div class="weui-cell__bd"></div>
                  <div onclick="refundItem({{ $item->id}})" class="weui-cell__ft">申请售后</div>
                </div>
            @endif
          @endif
          
        @endforeach
      </div>
    </div>
    <div class="practical-payment">
      实付 ：<span style="font-weight: bold;">¥ {{$order->price}}.00</span>&nbsp;
      <span>(免运费)</span>
    </div>
    <div class="order-contact">
      <a class="contact" href="/kefu" style="box-sizing: border-box;"><img src="{{ asset('images/default/leave.png') }}">联系卖家</a>
      <a class="phone" href="tel:18717160163"><img src="{{ asset('images/default/phone.png') }}">拨打电话</a>
    </div>
    <div class="weui-form-preview">       
        <div class="weui-form-preview__bd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">订单编号：</label>
                <span class="weui-form-preview__value">{{$order->snumber}}</span>
            </div>
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">支付方式：</label>
                <span class="weui-form-preview__value">微信</span>
            </div>
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">下单时间：</label>
                <span class="weui-form-preview__value">{{$order->created_at}}</span>
            </div>
            
            @if($order->prom_type != 1 && $order->prom_type != 5)
              <!-- <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label">商品金额：</label>
                  <span class="weui-form-preview__value">{{$order->origin_price}}</span>
              </div> -->
              @if($order->user_level_money)
              <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label">会员减免：</label>
                  <span class="weui-form-preview__value">{{$order->user_level_money}}</span>
              </div>
              @endif
              @if($order->coupon_money)
              <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label">优惠减免：</label>
                  <span class="weui-form-preview__value">-{{$order->coupon_money}}</span>
              </div>
              @endif
              @if($order->preferential)
              <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label">订单优惠：</label>
                  <span class="weui-form-preview__value">-{{$order->preferential}}</span>
              </div>
              @endif
              @if($order->credits_money)
              <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label">积分抵扣：</label>
                  <span class="weui-form-preview__value">-{{$order->credits_money}}</span>
              </div>
              @endif
              @if($order->user_money_pay)
              <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label">余额支付：</label>
                  <span class="weui-form-preview__value">-{{$order->user_money_pay}}</span>
              </div>
              @endif
              <!-- <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label">邮费：</label>
                  <span class="weui-form-preview__value">{{$order->freight}}</span>
              </div> -->
            @endif
            
            <!-- <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">备注：</label>
                <span class="weui-form-preview__value">{{$order->remark}}</span>
            </div> -->
        </div>
    </div>
    @if ('要' == $order->invoice)
      <div class="weui-form-preview">       
        <div class="weui-form-preview__bd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">开票类型：</label>
                <span class="weui-form-preview__value">{{$order->invoice_type}}</span>
            </div>
            @if ('公司' == $order->invoice_type)
              <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label">单位名称：</label>
                  <span class="weui-form-preview__value">{{$order->invoice_title}}</span>
              </div>
              <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label">税号：</label>
                  <span class="weui-form-preview__value">{{$order->tax_no}}</span>
              </div>
            @endif
        </div>
    </div>
    @endif

    @if (!empty($cancelStatus) && $cancelStatus->count() &&  $order->order_status == '已取消')
      <div>订单取消原因:　{{ $cancelStatus[0]->reason }}</div>
      <div>审核状态: @if($cancelStatus[0]->auth == 0) 待处理 @elseif($cancelStatus[0]->auth == 1) 通过 @else 不通过 @endif</div>
      @if($cancelStatus[0]->auth == 1)
        <div>退还金额: {{ $cancelStatus[0]->money }}</div>
        <div>资金返还: @if($cancelStatus[0]->refound == 0) 原路返回 @else 返回到余额 @endif</div>
      @endif
      <div>备注:　{{ $cancelStatus[0]->remark }}</div>
    @endif

    <div>
        <div class="weui-mask" id="iosMask" @if($show_pay && $order->order_pay == '未支付') style="display: block;" @else style="display: none" @endif ></div>
        <div class="weui-actionsheet @if($show_pay && $order->order_pay == '未支付') weui-actionsheet_toggle @endif" id="iosActionsheet">
            <div class="weui-actionsheet__title">
                <p class="weui-actionsheet__title-text">请选择支付方式</p>
            </div>
            <div class="weui-actionsheet__menu">

                @if (funcOpen('FUNC_WECHATPAY'))
                  <div class="weui-actionsheet__cell" onclick="wechatPay()"><img src="{{ asset('images/pay-weixin.png') }}">微信支付</div>
                @endif
                
                @if (funcOpen('FUNC_PAYSAPI'))
                  <div class="weui-actionsheet__cell" onclick="paysApi()"><img src="{{ asset('images/pay-paysapi.png') }}">微信支付</div>
                @endif

                <!--div class="weui-actionsheet__cell" onclick="aliPay()"><img src="{{ asset('images/pay-alipay.png') }}">支付宝支付</div-->
            </div>
            <div class="weui-actionsheet__action">
                <div class="weui-actionsheet__cell" id="iosActionsheetCancel">取消</div>
            </div>
        </div>
    </div>
  
    @if($order->order_status == '无效')

    @elseif($order->order_status == '已取消')

    @else
      @if ($order->order_pay == '未支付')
        <div class="checkwrapper product-checker">
          <span style="margin-left: 0.75rem; font-size: 0.6rem;">实付款 : </span> 
          <span class="price_final" id="total" style="padding-left: 0.5rem; font-weight: bold;"> ¥ {{$order->price}}.00</span>
          <a class="right-botton01" href="javascript:;" id="showIOSActionSheet">立即支付</a>
          <a class="right-botton02" href="javascript:;" onclick="cancelOrder()">取消订单</a>
        </div>
      @else
        @if($order->order_delivery == '未发货' && $order->prom_type != 5)
          @if(funcOpenCache('FUNC_ORDER_CANCEL'))
          <div class="checkwrapper product-checker">
            <a class="right-botton01" href="javascript:;" onclick="cancelOrder()">取消订单</a>
          </div>
          @endif
        @endif

        @if($order->order_delivery == '已发货')
          <div class="checkwrapper product-checker">
            <a class="right-botton01" href="javascript:;" onclick="confirmOrder({{$order->id}})">确认收货</a>
          </div>
        @endif

        @if($order->order_delivery == '已收货')
          <div class="checkwrapper product-checker">
            <a class="right-botton01" href="/buy_again/order/{{$order->id}}">再次购买</a>
          </div>
        @endif

        @if($order->order_delivery == '退换货')
        @endif        
      @endif
    @endif
  </div>

  <div>
    <div class="weui-mask" id="iosMaskCancel" @if(!$cancel_order) style="display: none" @endif ></div>
    <div @if($cancel_order) class="weui-actionsheet  weui-actionsheet_toggle " @else class="weui-actionsheet" @endif id="iosActionsheet2">
        <div class="weui-actionsheet__title">
            <p class="weui-actionsheet__title-text">取消原因</p>
        </div>
        <div class="weui-actionsheet__menu">
            <div class="weui-actionsheet__cell" onclick="cancelOrderConfirm({{$order->id}}, '订单不能按时送达')">订单不能按时送达</div>
            <div class="weui-actionsheet__cell" onclick="cancelOrderConfirm({{$order->id}}, '操作有误(商品，地址等)')">操作有误(商品，地址等)</div>
            <div class="weui-actionsheet__cell" onclick="cancelOrderConfirm({{$order->id}}, '重复下单、误下单')">重复下单、误下单</div>
            <div class="weui-actionsheet__cell" onclick="cancelOrderConfirm({{$order->id}}, '其他渠道价格更低')">其他渠道价格更低</div>
            <div class="weui-actionsheet__cell" onclick="cancelOrderConfirm({{$order->id}}, '该商品降价了')">该商品降价了</div>
            <div class="weui-actionsheet__cell" onclick="cancelOrderConfirm({{$order->id}}, '不想买了')">不想买了</div>
            <div class="weui-actionsheet__cell" onclick="cancelOrderConfirm({{$order->id}}, '其他原因')">其他原因</div>
        </div>
        <div class="weui-actionsheet__action">
            <div class="weui-actionsheet__cell" id="iosActionsheet2Cancel">取消</div>
        </div>
    </div>
  </div>

  <form style='display:none;' id='formpay' name='formpay' method='post' action='https://pay.paysapi.com'>
        <input name='goodsname' id='goodsname' type='text' value='' />
        <input name='istype' id='istype' type='text' value='' />
        <input name='key' id='key' type='text' value=''/>
        <input name='notify_url' id='notify_url' type='text' value=''/>
        <input name='orderid' id='orderid' type='text' value=''/>
        <input name='orderuid' id='orderuid' type='text' value=''/>
        <input name='price' id='price' type='text' value=''/>
        <input name='return_url' id='return_url' type='text' value=''/>
        <input name='uid' id='uid' type='text' value=''/>
        <input type='submit' id='submitdemo1'>
    </form>

@endsection

@section('js')

  @if(funcOpen('FUNC_TEAMSALE') 
    && $order->prom_type == 5 
    && $order->order_pay == '已支付' 
    && !empty($teamSale) 
    && !empty($teamFound)
    && Config::get('web.app_env') == 'product')

  <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript" charset="utf-8">
      wx.config({!! $app->jssdk->buildConfig(array('onMenuShareTimeline', 'onMenuShareAppMessage'), true) !!});

      wx.ready(function(){
        wx.onMenuShareTimeline({
          title: {{ $teamSale->share_title }}, // 分享标题
          link: document.domain + '/team_share/{{ $teamFound->id }}', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
          imgUrl: {{ $teamSale->share_img }}, // 分享图标
          success: function () {
          // 用户确认分享后执行的回调函数
          },
          cancel: function () {
          // 用户取消分享后执行的回调函数
          }
        };
        wx.onMenuShareAppMessage({
          title: {{ $teamSale->share_title }}, // 分享标题
          desc: {{ $teamSale->share_des }}, // 分享描述
          link: document.domain + '/team_share/{{ $teamFound->id }}', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
          imgUrl: {{ $teamSale->share_img }}, // 分享图标
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
  <script type="text/javascript">

    /*倒计时*/
    function _fresh(){
      var orderId=$('#left-time').data('order');
      var addtime=new Date($('#left-time').attr('addtime'))//订单开始时间
      
      var newDate=new Date();//当前时间
      var auto_order_cancel=$('#left-time').attr('auto_order_cancel');//订单有效时长
      var auto_totalS=parseInt(auto_order_cancel*60*60);
      var ad_totalS  = parseInt((addtime.getTime()/1000)+auto_totalS);//下单总秒数
      var totalS   = parseInt(ad_totalS-(newDate.getTime()/ 1000));///支付时长

      var _hour   = parseInt((totalS / 3600) % 24);
      var _minute = parseInt((totalS / 60) % 60);
      var _second = parseInt(totalS % 60);
      if(_hour<10){
        _hour='0'+_hour
      }
      if(_minute<10){
        _minute='0'+_minute
      }
      if(_second<10){
        _second='0'+_second
      }
      if(totalS>0){
        $('#left-time').html(_hour+' : '+_minute+' : '+_second);  
      }else{
        $('#left-time').parent().hide();
        clearInterval(sh);
        cancelOrderConfirm(orderId,'自动取消');
        alert('当前订单已超时,将自动取消');
        location.href="/orders";
      }
    }
    var sh = setInterval(_fresh,1000);
    /**
     * 取消确认弹出框
     * @type {[type]}
     */
    var $iosActionsheet = $('#iosActionsheet');
    var $iosMask = $('#iosMask');

    function hideActionSheet() {
        $iosActionsheet.removeClass('weui-actionsheet_toggle');
        $iosMask.fadeOut(200);
    }

    $iosMask.on('click', hideActionSheet);
    $('#iosActionsheetCancel').on('click', hideActionSheet);
    $("#showIOSActionSheet").on("click", function(){
        $iosActionsheet.addClass('weui-actionsheet_toggle');
        $iosMask.fadeIn(200);
    });


    /**
     * 取消理由选择框
     * @type {[type]}
     */
    var $iosActionsheetCancel = $('#iosActionsheet2');
    var $iosMaskCancel = $('#iosMaskCancel');
    function showCancelReason() {
      $iosActionsheetCancel.addClass('weui-actionsheet_toggle');
      $iosMaskCancel.fadeIn(200)
    }

    $iosMaskCancel.on('click', hideCancelSheet);
    $('#iosActionsheet2Cancel').on('click', hideCancelSheet);
    function hideCancelSheet() {
      $iosActionsheetCancel.removeClass('weui-actionsheet_toggle');
      $iosMaskCancel.fadeOut(200)
    }
    
    /**
     * 申请售后
     * @param  {[integer]} id [订单商品ID item]
     * @return {[type]}    [description]
     */
    function refundItem(id) {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      })
      $.ajax({
          url:"/canRefund/"+id,
          type:"GET",
          data:'',
          success: function(data) {
              if (data.code) {
                layer.open({
                  content: data.message
                  ,skin: 'msg'
                  ,time: 2 //2秒后自动关闭
                });
              }else{
                window.location.href="/refund/"+id;
              }
          },
          error: function(data) {
              //提示失败消息

          },
      });
    }

    /**
     * 关闭支付界面
     * @return {[type]} [description]
     */
    function closePay() {
      $('.pay').fadeOut(200);
    }
    /**
     * 显示支付界面
     * @return {[type]} [description]
     */
    function showPay() {
      $('.pay').fadeIn(200);
    }

    /**
     * 打开取消订单提示页面
     * @return {[type]} [description]
     */
    function cancelOrder(){
      layer.open({
        content: '确认取消订单吗？'
        ,btn: ['确认', '取消']
        ,yes: function(index){
          showCancelReason();
          layer.close(index);
        }
      });
    }

    /**
     * 确认取消订单
     * @param  {[type]} order_id [description]
     * @param  {[type]} reason   [description]
     * @return {[type]}          [description]
     */
    function cancelOrderConfirm(order_id, reason) {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          url:"/cancel/order/"+order_id+'?reason='+reason,
          type:"GET",
          data:'',
          success: function(data) {
              if (data.code) {
                layer.open({
                  content: data.message
                  ,skin: 'msg'
                  ,time: 2 //2秒后自动关闭
                });
              }else{
                window.location.href="/orders";
              }
          },
          error: function(data) {
              //提示失败消息

          },
      });
    }

    /**
     * 确认订单
     * @param  {[type]} order_id [description]
     * @return {[type]}          [description]
     */
    function confirmOrder(order_id) {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          url:"/confirm/order/"+order_id,
          type:"GET",
          data:'',
          success: function(data) {
              if (data.code) {
                layer.open({
                  content: data.message
                  ,skin: 'msg'
                  ,time: 2 //2秒后自动关闭
                });
              }else{
                location.reload();
              }
          },
          error: function(data) {
              //提示失败消息

          },
      });
    }

    function onBridgeReady(data) {
      data = JSON.parse(data)
      var that = this
      /* global WeixinJSBridge:true */
      WeixinJSBridge.invoke(
        'getBrandWCPayRequest', {
          'appId': data.appId, // 公众号名称，由商户传入
          'timeStamp': data.timeStamp, // 时间戳，自1970年以来的秒数
          'nonceStr': data.nonceStr, // 随机串
          'package': data.package,
          'signType': data.signType, // 微信签名方式：
          'paySign': data.paySign // 微信签名
        },
        function (res) {
          // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回ok，但并不保证它绝对可靠。
          if (res.err_msg === 'get_brand_wcpay_request:ok') {
            layer.open({
              content: '支付成功'
              ,skin: 'msg'
              ,time: 2 //2秒后自动关闭
            });
          } else {
            layer.open({
              content: '支付失败,错误信息: ' + res.err_msg
              ,skin: 'msg'
              ,time: 2 //2秒后自动关闭
            });
          }
        }
      )
    }

    /**
     * 微信支付
     * @return {[type]} [description]
     */
    function wechatPay() {
      event.preventDefault();
      hideActionSheet();
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          url:"/pay_weixin/{{$order->id}}",
          type:"GET",
          data:'',
          success: function(data) {
            if (data.code) {
        
            }else {
              if (typeof WeixinJSBridge === 'undefined') { // 微信浏览器内置对象。参考微信官方文档
                if (document.addEventListener) {
                  document.addEventListener('WeixinJSBridgeReady', onBridgeReady(data.message), false)
                } else if (document.attachEvent) {
                  document.attachEvent('WeixinJSBridgeReady', onBridgeReady(data.message))
                  document.attachEvent('onWeixinJSBridgeReady', onBridgeReady(data.message))
                }
              } else {
                onBridgeReady(data.message)
              }
            }
          },
          error: function(data) {
              //提示失败消息
          },
      });
    }

    /**
     * PAYS API 微信支付
     * @Author   yangyujiazi
     * @DateTime 2018-03-16
     * @return   {[type]}    [description]
     */
    function paysApi() {
      event.preventDefault();
      hideActionSheet();
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          url:"/pays_api/{{$order->id}}?type=2",
          type:"GET",
          data:'',
          success: function(data) {
            if (data.code) {
        
            }else {
              $("#goodsname").val(data.message.goodsname);
              $("#istype").val(data.message.istype);
              $('#key').val(data.message.key);
              $('#notify_url').val(data.message.notify_url);
              $('#orderid').val(data.message.orderid);
              $('#orderuid').val(data.message.orderuid);
              $('#price').val(data.message.price);
              $('#return_url').val(data.message.return_url);
              $('#uid').val(data.message.uid);
              $('#submitdemo1').click();
            }
          },
          error: function(data) {
              //提示失败消息
          },
      });
    }

    /**
     * 支付宝支付
     * @return {[type]} [description]
     */
    function aliPay() {
      event.preventDefault();
      hideActionSheet();

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
          url:"/pay_alipay/{{$order->id}}",
          type:"GET",
          data:'',
          success: function(data) {
            //提示成功消息
            if (data.code == 0) {
                _AP.pay(data.message);
            }else{
              layer.open({
                content: data.message
                ,skin: 'msg'
                ,time: 2 //2秒后自动关闭
              });
            }
          },
          error: function(data) {
              //提示失败消息
          },
      });

  }

  function onBridgeReady(message) {
    data = JSON.parse(message);
    /* global WeixinJSBridge:true */
    WeixinJSBridge.invoke(
      'getBrandWCPayRequest', {
        'appId': data.appId, // 公众号名称，由商户传入
        'timeStamp': data.timeStamp, // 时间戳，自1970年以来的秒数
        'nonceStr': data.nonceStr, // 随机串
        'package': data.package,
        'signType': data.signType, // 微信签名方式：
        'paySign': data.paySign // 微信签名
      },
      function (res) {
        // 使用以上方式判断前端返回,微信团队郑重提示：res.err_msg将在用户支付成功后返回ok，但并不保证它绝对可靠。
        if (res.err_msg === 'get_brand_wcpay_request:ok') {
            var $toast = $('#toast');
            $('#toast-info').text('支付成功');
            $toast.fadeIn(100);
            setTimeout(function () {
                $toast.fadeOut();
                window.location.href = '/order/{{$order->id}}';
            }, 1000);
            
        } else {
          layer.open({
            content: '支付失败,错误信息: ' + res.err_msg
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
          });
        }
      }
    );
  }

  // function contactKefu() {
  //   $.ajaxSetup({
  //         headers: {
  //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //         }
  //     });
  //     $.ajax({
  //         url:"/wechat/contact_kefu",
  //         type:"GET",
  //         data:'',
  //         success: function(data) {
            
  //         },
  //         error: function(data) {
  //             //提示失败消息
  //         },
  //     });
  // }

  /**
   * 拼团显示倒计时
   * @type {[type]}
   */
  @if ($order->prom_type == 5 && $order->order_pay == '已支付' && $teamFound->need_mem > $teamFound->join_num)
  $(function(){
    var end_time=$('#teamsale_timer').data('endtime');
      startShowCountDown(end_time,'#teamsale_timer','teamsale');
  });
  @endif
  </script>
@endsection
