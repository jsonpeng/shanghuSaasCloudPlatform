@extends('front.default.layout.base')

@section('css')
    <style>
      .refund-type{display: inline-block; margin-right: 5px; padding: 3px 15px; box-sizing: border-box;}
      .refund-type.active{border: 1px solid red;}
      .upload_input{
        display: block;
        width: 0;
        height: 0;
        -webkit-opacity: 0.0;  
        /* Netscape and Older than Firefox 0.9 */  
        -moz-opacity: 0.0;  
        /* Safari 1.x (pre WebKit!) 老式khtml内核的Safari浏览器*/  
        -khtml-opacity: 0.0;  
        /* IE9 + etc...modern browsers */  
        opacity: .0;  
        /* IE 4-9 */  
        filter:alpha(opacity=0);  
        /*This works in IE 8 & 9 too*/  
        -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";  
        /*IE4-IE9*/  
        filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=0); 
      }
      .preview{display: none;}
    </style>
@endsection

@section('content')
  <div class="nav_tip">
    <div class="img">
      <a href="javascript:history.back(-1)"><i class="icon ion-ios-arrow-left"></i></a></div>
    <p class="titile">申请售后</p>
    <!--div class="userSet">
        <a href="javascript:;">
              <img src="{{ asset('images/default/more.png') }}" alt="">
        </a>
    </div-->
  </div>
  <div href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
    <div class="weui-media-box__hd">
        <img class="weui-media-box__thumb" src="{{ $item->pic }}" alt="">
    </div>
    <div class="weui-media-box__bd">
        <h4 class="weui-media-box__title">{{ $product->name }} @if(!empty($item->key_name))( {{ $item->key_name }} ) @endif</h4>
        <p class="weui-media-box__desc">价格: <span>{{ $item->price }}</span> &nbsp;&nbsp;&nbsp;&nbsp;数量: x{{ $item->count }}</p>
    </div>
  </div>
    <form method="POST" action="/postRefund/{{ $item->id }}" enctype="multipart/form-data">
      {!! csrf_field() !!}
      <div class="contnet-wrapper">
        <div class="servicetype">服务类型：</div>
        <div class="refund-types weui-cell">
          <div class="refund-type" type='0'>仅退款</div>
          <div class="refund-type" type='1'>退货退款</div>
          <div class="refund-type active" type='2'>换货</div>
          <input type="hidden" name="type" value="2">
        </div>
        <div class="applybox clearfloat">
            <div class="applynum">申请数量</div>
            <div class="choosebox">
              <div class="counter">
                <i class="fa fa-minus" style="float:left;" onclick="cartdel()"></i>
                <input type="number" name="count" value="1" readonly="readonly">
                <i class="fa fa-plus" style="float:left;" onclick="cartadd()"></i>
              </div>
            </div>
        </div>
      </div>
      <div class="weui-cell weui-cell-margin">
        <p class="goodsStatus">货物状态</p>
      </div>
      <div class="weui-cells weui-cells_checkbox ">
        <label class="weui-cell weui-check__label" for="x11">
            <div class="weui-cell__hd">
                <input type="radio" class="weui-check" name="is_receive" id="x11" value="1" checked="checked"/>
                <i class="weui-icon-checked"></i>
            </div>
            <div class="weui-cell__bd">
                <p>收到货.</p>
            </div>
        </label>
        <label class="weui-cell weui-check__label" for="x12">
            <div class="weui-cell__hd">
                <input type="radio" class="weui-check" name="is_receive" id="x12" value="0"/>
                <i class="weui-icon-checked"></i>
            </div>
            <div class="weui-cell__bd">
                <p>未收到货.</p>
            </div>
        </label>
      </div>
      <div class="contnet-wrapper">
      </div>
      <div class="weui-cell weui-cell_access reason">
        <div class="weui-cell__bd">提交原因</div>
        <div class="weui-cell__ft" onclick="showCancelReason()"><span id="cancelReason">请选择取消原因</span><img src="" alt=""><input type="hidden" name="reason" /></div>
      </div>
      <div class="vux-x-textarea section-margin">
        <div class="remark remark-dark">问题描述</div> 
        <div class="weui-cell__bd">
          <textarea autocomplete="off" autocapitalize="off" autocorrect="off" spellcheck="false" placeholder="" rows="3" cols="30" maxlength="200" class="weui-textarea" name="remark"></textarea> 
          <div class="weui-textarea-counter"><span>0</span>/200</div>
        </div>
      </div>
      <div class="weui-cells weui-cells_form">
          <div class="weui-cell">
            <div class="weui-cell__bd">
              <div class="weui-uploader">
                <div class="weui-uploader__hd">
                    <p class="weui-uploader__title">上传照片</p>
                </div>
                <div class="weio-uploader__bd">
                    <ul class="weui-uploader__files">
                        <li class="weui-uploader__file"  id="uploader0" data-status="0"></li>
                        <input name="file" type="file" class="upload_input" id="uploadfile1" onchange="change(this)" data-data="0" />
                        <li class="weui-uploader__file"  id="uploader1" data-status="0"></li>
                        <input name="file" type="file" class="upload_input" id="uploadfile2" onchange="change(this)" data-data="1" />
                        <li class="weui-uploader__file"  id="uploader2" data-status="0"></li>
                        <input name="file" type="file" class="upload_input" id="uploadfile3" onchange="change(this)" data-data="2" />
                        <li class="weui-uploader__file"  id="uploader3" data-status="0"></li>
                        <input name="file" type="file" class="upload_input" id="uploadfile4" onchange="change(this)" data-data="3" />
                        <li class="weui-uploader__file"  id="uploader4" data-status="0"></li>
                        <input name="file" type="file" class="upload_input" id="uploadfile5" onchange="change(this)" data-data="4" />
                    </ul>
                  {{--   <div class="weui-uploader__input-box">
                      <input type="file" id="uploaderInput" class="weui-uploader__input" onchange="changeType()">
                    </div> --}}
                </div>
              </div>
            </div>
          </div>
          <div class="weui-cell weui-cell-tips">
            <p>为帮助我们解决问题，请上传照片，最多5张，每张不超过5M</p>
          </div> 
      </div>

       <div>
    <div class="weui-mask" id="iosMaskCancel" style="display: none" ></div>
    <div class="weui-actionsheet" id="iosActionsheet2">
        <div class="weui-actionsheet__title">
            <p class="weui-actionsheet__title-text">取消原因</p>
        </div>
        <div class="weui-actionsheet__menu">
            <div class="weui-actionsheet__cell" onclick="cancelOrderConfirm('订单不能按时送达')">订单不能按时送达</div>
            <div class="weui-actionsheet__cell" onclick="cancelOrderConfirm('操作有误(商品，地址等)')">操作有误(商品，地址等)</div>
            <div class="weui-actionsheet__cell" onclick="cancelOrderConfirm('重复下单、误下单')">重复下单、误下单</div>
            <div class="weui-actionsheet__cell" onclick="cancelOrderConfirm('其他渠道价格更低')">其他渠道价格更低</div>
            <div class="weui-actionsheet__cell" onclick="cancelOrderConfirm('该商品降价了')">该商品降价了</div>
            <div class="weui-actionsheet__cell" onclick="cancelOrderConfirm('不想买了')">不想买了</div>
            <div class="weui-actionsheet__cell" onclick="cancelOrderConfirm('其他原因')">其他原因</div>
        </div>
        <div class="weui-actionsheet__action">
            <div class="weui-actionsheet__cell" id="iosActionsheet2Cancel">取消</div>
        </div>
    </div>
  </div>


      <div class="weui-cells submit">
        <input type="submit" name="提交" >
      </div>
    </form>


  
@endsection

@section('js')
  <script type="text/javascript">
    var refunds_id={{ $item->id }};
    var i=0;
    //切换退换货类型
    $('.refund-type').on('click', function(){
      $('input[name=type]').val($(this).attr('type'));
      $('.refund-type').removeClass('active');
      $(this).addClass('active');
    })

    var maxCount = {{ $item->count }};
    function cartdel() {
      var coutnNow = parseInt($('input[name=count]').val());
      if (coutnNow > 1) {
        $('input[name=count]').val(coutnNow - 1);
      }
    }
    $('.weui-uploader__file').click(function(){
      $(this).next().trigger("click");
    });

    function cartadd(){
      var coutnNow = parseInt($('input[name=count]').val());
      if (coutnNow < maxCount) {
        $('input[name=count]').val(coutnNow + 1);
      }
    }

  function change(objs){
    var type=$(objs).data('data');
    var uploader_obj=$(objs).parent().parent().find('#uploader'+type);
    var status=uploader_obj.data('status');
    console.log(uploader_obj.data('status'));
    if(!status){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajaxFileUpload({
      type: "POST",  
      url: '/api/refundUploadImage/'+refunds_id,
      secureuri: false,//异步
      async : false,  
      fileElementId: $(objs).attr('id'),//上传控件ID
      dataType: 'json',//返回的数据信息格式
      success: function(data, status) {
        if (data.code == 0) {
          uploader_obj.css('background-image','url('+data.msg.src+')');
          uploader_obj.data('status',1);
          uploader_obj.data('orid',data.msg.orimg_id);
          i=type+1;
        } else {
          layer.open({
            content: '上传失败'
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
          });
        }
      }, error: function(data, status, e) {
        layer.open({
          content: e
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
      }
    });
  }else{
    console.log(uploader_obj.data('orid'));
     $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajaxFileUpload({
      type: "POST",  
      url: '/api/switchRefundUploadImage/'+uploader_obj.data('orid'),
      secureuri: false,//异步
      async : false,  
      fileElementId: $(objs).attr('id'),//上传控件ID
      dataType: 'json',//返回的数据信息格式
      success: function(data, status) {
        if (data.code == 0) {
          uploader_obj.css('background-image','url('+data.msg.src+')');
          i=type+1;
        } else {
          layer.open({
            content: '上传失败'
            ,skin: 'msg'
            ,time: 2 //2秒后自动关闭
          });
        }
      }, error: function(data, status, e) {
        layer.open({
          content: e
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
      }
    });
  }
}
 //H5渲染
  function html5Reader(file,pic,addImg,deleteImg){
     var file = file.files[0];
     var reader = new FileReader();
     reader.readAsDataURL(file);
     reader.onload = function(e){
         pic.attr("src",this.result);
         pic.parent().parent().css('background-image','url('+this.result+')');
     }
     addImg.hide();
     deleteImg.show();
  }


  function cancelOrderConfirm(word){
      $('#cancelReason').text(word);
      $('input[name=reason]').val(word);
      hideCancelSheet();
  }

      /**
     * 取消理由选择框
     * @type {[type]}
     */
    var $iosActionsheetCancel = $('#iosActionsheet2');
    var $iosMaskCancel = $('#iosMaskCancel');
    function showCancelReason(){
      $iosActionsheetCancel.addClass('weui-actionsheet_toggle');
      $iosMaskCancel.fadeIn(200)
    }

    $iosMaskCancel.on('click', hideCancelSheet);
    $('#iosActionsheet2Cancel').on('click', hideCancelSheet);
    function hideCancelSheet() {
      $iosActionsheetCancel.removeClass('weui-actionsheet_toggle');
      $iosMaskCancel.fadeOut(200)
    }
  </script>
@endsection
