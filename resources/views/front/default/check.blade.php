@extends('front.default.layout.base')

@section('css')
    <style>
      .weui-actionsheet__menu{max-height: 500px; overflow-y: auto;}
      .weui-actionsheet__menu::-webkit-scrollbar {display:none}
      .weui-icon-circle span, .weui-icon-success span{font-size: 16px;}
      .weui-icon-circle, .weui-icon-success{font-size: 18px;}
      .weui-cell__hd{display: flex;}
    </style>
@endsection

@section('content')
<div class="nav_tip">
  <div class="img">
    <a href="javascript:history.back(-1)"><i class="icon ion-ios-arrow-left"></i></a></div>
  <p class="titile">结算</p>
  <!--div class="userSet">
      <a href="javascript:;">
            <img src="{{ asset('images/default/more.png') }}" alt="">
      </a>
  </div-->
</div>
<form method="POST" action="/check">
  {{ csrf_field() }}
  @if (!empty($address))
    <input type="hidden" value="{{ $address->name}}" name="customer_name">
    <input type="hidden" value="{{ $address->phone}}" name="customer_phone">
    <input type="hidden" value="{{ getCitiesNameById($address->province) }}{{ getCitiesNameById($address->city) }}{{ getCitiesNameById($address->district) }}{{ $address->detail }}" name="customer_address">
  @endif
  
  <input type="hidden" value="{{ $freight }}" name="freight">
  <div id="check">

    @if (!empty($address))
      <!--div class="weui-panel weui-panel_access">
        <div class="weui-panel__hd tabList">
            <div class="tabItem active">物流配送</div>
            <div class="tabItem">门店自提</div>
        </div>
      </div-->
      <div class="user-address">
        <img src="{{ asset('images/default/location.png') }}" class="address-icon">
        <div class="address-content">
            <h4 class="name">{{ $address->name }} {{ $address->phone }}</h4>
            <p class="address">{{ getCitiesNameById($address->province) }}{{ getCitiesNameById($address->city) }}{{ getCitiesNameById($address->district) }}{{ $address->detail }}</p>
        </div>
        <a class="select" href="/address/change?backupcheck=1">修改</a>
      </div>
      <div class="postline">
      </div>
      <input type="hidden" name="address_id" value="{{ $address->id }}">
    @else
      <div class="js_dialog" id="iosDialog2">
          <div class="weui-mask"></div>
          <div class="weui-dialog">
              <div class="weui-dialog__bd">您还未设置收货地址</div>
              <div class="weui-dialog__ft">
                  <a href="/address/add?backupcheck=1" class="weui-dialog__btn weui-dialog__btn_primary">现在去设置</a>
              </div>
          </div>
      </div>
    @endif
    
    <div class="check-products">
      @foreach($items as $item)
        @if ($item['type'] == 0)
          <div class="zcjy-product-check">
            <img src="{{ $item->product->image }}" class="productImage">
            <div class="product-name">{{ $item->product->name }}</div>
            <div class="remark"></div>
            <div class="price"> <span style="float: left;">¥{{ $item->realPrice }}</span> <span style="float: right; margin-right: 0.75rem;">x{{ $item->qty }}</span></div>
          </div>
        @else
          <div class="zcjy-product-check">
            <img src="{{ $item->spec->image }}" class="productImage">
            <div class="product-name">{{ $item->product->name }}</div>
            <div class="remark">规格：{{ $item->spec->key_name }}</div>
            <div class="price"> <span style="" class="ft-l">¥{{ $item->realPrice }}</span> <span style="float: right; margin-right: 0.75rem;" class="ft-r">x{{ $item->qty }}</span></div>
          </div>
        @endif

      @endforeach
    </div>

    <!--div class="weui-cells section-margin">
        <a class="weui-cell weui-cell_access" href="javascript:;">
            <div class="weui-cell__bd">
                <p>网上支付</p>
            </div>
            <div class="weui-cell__ft">
            </div>
        </a>
    </div-->

    @if(funcOpen('FUNC_MEMBER_LEVEL'))
      @if(!empty($user_level) && $user_level->discount < 100)
      <div class="page__bd section-margin">
        <div class="weui-form-preview">
          <div class="weui-form-preview__hd" style="padding: 0 15px;">
              <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label" style="color: #333;">{{ $user_level->name }}</label>
                  <em class="weui-form-preview__value ">@if($user_level->discount == 100) 不享受优惠 @else 购物享受{{ $user_level->discount }}折优惠 @endif</em>
              </div>
          </div>
          @if($preference)
          <div class="weui-form-preview__bd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">会员优惠金额</label>
                <span class="weui-form-preview__value">-¥{{ $preference }}</span>
            </div>
          </div>
          @endif
        </div>
      </div>
      @endif
    @endif

    @if(funcOpen('FUNC_COUPON'))
    <div class="weui-cells section-margin" onclick="openCouponSelector()">
        <a class="weui-cell weui-cell_access" href="javascript:;">
            <div class="weui-cell__bd">
                <p id="coupon_name">优惠券</p>
            </div>
            <div class="weui-cell__ft">
            </div>
        </a>
    </div>
    @endif

    <input type="hidden" name="coupon_id" value="0">
    <input type="hidden" name="credits" value="0">
    <input type="hidden" name="user_money_pay" value="0">
    <input type="hidden" name="prom_type" value="{{$prom_type}}">
    <input type="hidden" name="prom_id" value="{{$prom_id}}">

    
    @if(funcOpen('FUNC_CREDITS') && getSettingValueByKeyCache('credits_switch') == '是' && $user->credits)
    <div class="page__bd section-margin">
      <div class="weui-form-preview">
        <div class="weui-form-preview__hd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label" style="color: #333;">{{ getSettingValueByKeyCache('credits_alias') }}抵扣({{ $user->credits }}{{ getSettingValueByKeyCache('credits_alias') }})</label>
                <em class="weui-form-preview__value price_final credit_money"></em>
            </div>
        </div>
        <div class="weui-form-preview__bd">
          @if ($user->credits < getSettingValueByKeyCache('credits_min') )
            <div class="weui-form-preview__item">
              <label class="weui-form-preview__label">满{{ getSettingValueByKeyCache('credits_min') }}{{ getSettingValueByKeyCache('credits_alias') }}可用</label>
            </div>
          @else
            <div class="weui-form-preview__item">
              <label class="weui-form-preview__label">使用积分(本次最多可用<span id="max_use_credits"></span>{{ getSettingValueByKeyCache('credits_alias') }})</label>
              <div>
                <div class="counter">
                  <i class="fa fa-minus" style="float:left;" onclick="creditDel()"></i>
                  <input type="number" name="count" value="0" readonly="readonly">
                  <i class="fa fa-plus" style="float:left;" onclick="creditAdd()"></i>
                </div>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
    @endif
    
    @if(funcOpen('FUNC_FAPIAO'))
    <div class="page__bd section-margin bill">
        <div class="weui-cells weui-cells_form">
            <div class="weui-cell weui-cell_switch">
              <div class="weui-cell__bd">开具发票</div>
              <div class="weui-cell__ft">
                  <input type="checkbox" class="weui-switch" id="invoice" name="invoice">
              </div>
            </div>
            <div id="invoice_detail" style="display: none;">
              <div class="weui-cell">
                  <div class="fistname">开票信息</div>
              </div>
              <div class="weui-cell">
                  <div class="weui-cell__hd weui-icon-circle" title="个人">
                      <span>个人</span>
                  </div>
                  <div class="weui-cell__hd weui-icon-success" title="公司">
                      <span>公司</span>
                  </div>
              </div>
              <input type="hidden" name="invoice_type" value="公司">
              <div id="invoice_info" style="margin-top: 15px;">
                <div class="weui-cell unit">
                  <input type="text" placeholder="请填写单位名称" name="invoice_title">
                </div>
                <div class="weui-cell num">
                  <input type="text" placeholder="请在此填写纳税人识别号" name="tax_no">
                </div>
              </div>
            </div>
        </div>
    </div>
    @endif

    @if(funcOpen('FUNC_FUNDS') && $user->user_money >= 1)
    <div class="page__bd section-margin">
      <div class="weui-form-preview">
        <div class="weui-form-preview__hd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label" style="color: #333;">账户余额({{ $user->user_money }}元)</label>
            </div>
        </div>
        <div class="weui-form-preview__bd">
            <div class="weui-form-preview__item">
              <label class="weui-form-preview__label">使用</label>
              <div>
                <div class="counter">
                  <i class="fa fa-minus" style="float:left;" onclick="moneyDel()"></i>
                  <input type="number" name="user_money" value="0" readonly="readonly">
                  <i class="fa fa-plus" style="float:left;" onclick="moneyAdd()"></i>
                </div>
                <div onclick="userAllMoney()">全部使用</div>
              </div>
            </div>
          
        </div>
      </div>
    </div>
    @endif

    @if(funcOpen('FUNC_ORDER_PROMP'))
      @if(!empty($order_promp))<div class="promp-tips">已自动享受优惠: 全场{{$order_promp}}</div>@endif
    @endif
    <div class="page__bd section-margin">
      <div class="weui-form-preview">
          <div class="weui-form-preview__hd">
              <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label" style="color: #333;">付款金额</label>
                  <em class="weui-form-preview__value price_final">¥<span>{{ $needPay }}</span></em>
              </div>
          </div>

          <div class="weui-form-preview__bd">
              <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label">商品总金额</label>
                  <span class="weui-form-preview__value">{{ $total }}</span>
              </div>

            
              <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label">使用余额</label>
                  <span class="weui-form-preview__value" id="yue_preference">0</span>
              </div>
             
              
          
              <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label">订单优惠({{ $order_promp }})</label>
                  <span class="weui-form-preview__value" id="order_preference">-{{ $order_promp_money }}</span>
              </div>
           
              
            
              <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label">优惠券减免</label>
                  <span class="weui-form-preview__value" id="coupon_preference">0</span>
              </div>
       
              
            
              <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label">积分抵扣</label>
                  <span class="weui-form-preview__value credit_money" id="credit_preference">0</span>
              </div>
           

        
                <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label">会员折扣</label>
                  <span class="weui-form-preview__value" id="member_preference">-{{ $preference }}</span>
                </div>
            
              
              <div class="weui-form-preview__item">
                  <label class="weui-form-preview__label">运费</label>
                  <span class="weui-form-preview__value" id="freight">{{ $freight }}</span>
              </div>
          </div>

      </div>
      <div class="vux-x-textarea section-margin">
        <div class="remark">备注信息</div> 
        <div class="weui-cell__bd">
          <textarea autocomplete="off" autocapitalize="off" autocorrect="off" spellcheck="false" placeholder="" rows="5" cols="30" maxlength="200" class="weui-textarea" name="remark"></textarea> 
          <div class="weui-textarea-counter"><span class="surplus">0</span>/200</div>
        </div>
      </div>
    </div>
  </div>
  </form>

  <div class="checkwrapper product-checker">
    <span style="margin-left: 0.75rem; font-size: 14px;">实付款：  </span> <span class="price_final" id="total"> ¥ <span>{{ $needPay }}</span></span>
    <a class="right-botton02" href="javascript:;" onclick="">继续购物</a>
    <a class="right-botton01" href="javascript:;" onclick="submit()">立即支付</a>
  </div>

  @if(funcOpen('FUNC_COUPON'))
  <!--div id="coupon-list">
    <div class="content-scroller">
      <div class="content-wrapper">
        
      </div>
    </div>
  </div-->

  <div>
      <div class="weui-mask" id="iosMask" style="display: none"></div>
      <div class="weui-actionsheet" id="iosActionsheet">
          <div class="weui-actionsheet__title">
              <p class="weui-actionsheet__title-text">请选择优惠券</p>
          </div>
          <div class="weui-actionsheet__menu" id="weui-actionsheet__menu">
          </div>
          <div class="weui-actionsheet__action">
              <div class="weui-actionsheet__cell" id="iosActionsheetCancel">取消</div>
          </div>
      </div>
  </div>
  @endif
@endsection

@section('js')
  <script>


    var $iosActionsheet = $('#iosActionsheet');
    var $iosMask = $('#iosMask');

    function hideActionSheet() {
        $iosActionsheet.removeClass('weui-actionsheet_toggle');
        $iosMask.fadeOut(200);
    }

    function showActionSheet() {
        $iosActionsheet.addClass('weui-actionsheet_toggle');
        $iosMask.fadeIn(200);
    }

    $iosMask.on('click', hideActionSheet);
    $('#iosActionsheetCancel').on('click', hideActionSheet);
    /*
    $("#showIOSActionSheet").on("click", function(){
        $iosActionsheet.addClass('weui-actionsheet_toggle');
        $iosMask.fadeIn(200);
    });
    */

    var needInvoice = false;
    //设置是否需要发票
    $("#invoice").on('change', function() {
      if ($(this).prop('checked')) {
        $(this).prop("checked",true);
        $("#invoice_detail").show();
        needInvoice = true;
      }else{
        //取消默认
        $("#invoice_detail").hide();
        needInvoice = false;
      }
    });

    //开票是单位还是个人
    $("#invoice_detail .weui-cell__hd").on('click', function() {
      $("#invoice_detail .weui-cell__hd").removeClass('weui-icon-success');
      $("#invoice_detail .weui-cell__hd").addClass('weui-icon-circle');
      $(this).removeClass('weui-icon-circle');
      $(this).addClass('weui-icon-success');

      $('input[name=invoice_type]').val($(this).attr('title'));
      if ($(this).attr('title') == '个人') {
        $("#invoice_info").hide();
      } else {
        $("#invoice_info").show();
      }
    });

    

    function submit() {
      //发票信息
      if (needInvoice && $('input[name=invoice_type]').val() == '公司') {
        if ($('input[name=invoice_title]').val() == '') {
          layer.open({
            content: '请填写单位名称'
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
          });
          return;
        }
        if ($('input[name=tax_no]').val() == '') {
          layer.open({
            content: '请填写税号'
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
          });
          return;
        }

      }
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url:"/check",
        type:"POST",
        data:$('form').serialize(),
        success: function(data) {
          if (data.code) {
            layer.open({
              content: data.message
              ,skin: 'msg'
              ,time: 2 //2秒后自动关闭
            });
          }else{
            window.location.href = '/order/'+data.message+'?show_pay=yes';
          }
        }
      });
    }

    function openCouponSelector() {
      $('#weui-actionsheet__menu').empty();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url:"/ajax/coupons",
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
            if (data.message.length == 0) {
              layer.open({
                content: '无可用优惠券'
                ,skin: 'msg'
                ,time: 2 //2秒后自动关闭
              });
            }
            

            console.log(data.message);
            for (var i = data.message.length - 1; i >= 0; i--) {
              var priceText = '';
              if (data.message[i].coupon.type == '满减') {
                priceText = data.message[i].coupon.given + '元';
              } else {
                priceText = data.message[i].coupon.discount + '折';
              }
              var desText = '';
              if (data.message[i].coupon.range == 0) {desText = '满'+data.message[i].coupon.base+'元可使用, 全场通用'}
              if (data.message[i].coupon.range == 1) {desText = '满'+data.message[i].coupon.base+'元可使用, 指定分类商品使用'}
              if (data.message[i].coupon.range == 2) {desText = '满'+data.message[i].coupon.base+'元可使用, 指定分类商品使用'}
              var timeText =  data.message[i].time_begin.substring(0,10) + ' - ' + data.message[i].time_end.substring(0,10);

              $('#weui-actionsheet__menu').append("\
                  <div class='weui-actionsheet__cell coupon-cell'>\
                    <div class='price'>"+priceText+"</div>\
                    <div class='des'>"+desText+"</div>\
                    <div class='time-range'>使用有效期："+timeText+"</div>\
                    <div class='usecoupon' onclick='chooseCoupon(" + data.message[i].id + ")'>使用</div>\
                  </div>\
              ");
            }
            showActionSheet();
          }
        },
        error: function(data) {
            //提示失败消息

        },
      });
    }

    //用户选择优惠券
    function chooseCoupon(coupon_id) {
      //$('#coupon-list').fadeOut(200);

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        url:"/api/coupon_choose/" + coupon_id,
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
            $("input[name='coupon_id']").val(data.message.coupon_id);
            $("#coupon_preference").text(-data.message.discount);
            $("#coupon_name").text('优惠券(' + data.message.name + ')');
            hideActionSheet();

            coupon_money = data.message.discount;
            setNeedPay();
          }
        },
        error: function(data) {
            //提示失败消息

        },
      });
    }

    var total = {{ $total }};
    var order_promp = {{ $order_promp_money }};
    var coupon_money = 0;
    var creditMoney = 0;
    var member_money = {{ $preference }};
    var freigth = {{ $freight }};
    var user_money = {{ $user->user_money }};
    var money_use = 0;
    //积分操作
    //用户积分
    var maxCount = {{ $user->credits }};
    //积分现金兑换比例
    var creditRate = {{ getSettingValueByKeyCache('credits_rate') }};
    //积分最多可抵用金额比例
    var maxTotalRate = {{ getSettingValueByKeyCache('credits_max') }};
    var origianlPrice = {{ $total }};
    var maxCancel = origianlPrice*maxTotalRate/100;
    maxCount = parseInt(maxCount > maxCancel ? maxCancel : maxCount)*creditRate;
    $('#max_use_credits').text(maxCount);

    function creditDel() {
      var coutnNow = parseInt($('input[name=count]').val());
      if (coutnNow >= creditRate) {
        $('input[name=count]').val(coutnNow - creditRate);
        calPrice()
      }
    }

    function creditAdd() {
      var coutnNow = parseInt($('input[name=count]').val());
      if (coutnNow <= maxCount - creditRate) {
        $('input[name=count]').val(coutnNow + creditRate);
        calPrice()
      }
    }

    function moneyDel() {
      var coutnNow = parseInt($('input[name=user_money]').val());
      if (coutnNow > 0) {
        money_use = coutnNow - 1;
        $('input[name=user_money]').val(money_use);
        $('input[name=user_money_pay]').val(money_use);
        $('#yue_preference').text(-money_use);
        setNeedPay();
      }
    }

    function moneyAdd() {
      var coutnNow = parseInt($('input[name=user_money]').val());
      money_use = coutnNow + 1;
      if (money_use <= user_money) {
        if ( total - order_promp - coupon_money - creditMoney - member_money - money_use + freigth < 0) {
          //不能用太多，导致成负数
          money_use = total - order_promp - coupon_money - creditMoney - member_money + freigth;
        }
        $('input[name=user_money]').val(money_use);
        $('input[name=user_money_pay]').val(money_use);
        $('#yue_preference').text(-money_use);
        setNeedPay();
      }
    }

    function userAllMoney() {
      var calPrice  = total - order_promp - coupon_money - creditMoney - member_money + freigth;
      if (calPrice > user_money) {
        calPrice = user_money;
      }
      var allMoney = money_use = calPrice;
      $('input[name=user_money]').val(allMoney);
      $('input[name=user_money_pay]').val(allMoney);
      setNeedPay();
    }

    function calPrice() {
      var credits = $('input[name=count]').val();
      creditMoney = (credits/creditRate).toFixed(2);
      $('.credit_money').text('-'+ creditMoney);
      setNeedPay();
      $('input[name=credits]').val(credits);
    }

    function setNeedPay() {
      var money = (total-order_promp-coupon_money-creditMoney-member_money-money_use+freigth).toFixed(2);
      money = money < 0 ? 0 : money;
      $(".price_final span").text(money);
    }

    // 备注信息可输入字数
       $('.vux-x-textarea textarea').on('input',function(){ 
            setInterval(function(){
                 var txtval = $('.vux-x-textarea textarea').val().length;   
                 console.log(txtval);   
                var str = parseInt(200-txtval);   
                console.log(str);   
                  if(str > 0 ){   
                    $('.surplus').html(str);   
                }else{   
                    $('.surplus').html('0');   
                    $('.surplus').val($('.surplus').val().substring(0,200)); //这里意思是当里面的文字小于等于0的时候，那么字数不能再增加，只能是600个字   
                  }   
                  //console.log($('#num_txt').html(str));  
            },300)  
    }); 
  </script>
@endsection
