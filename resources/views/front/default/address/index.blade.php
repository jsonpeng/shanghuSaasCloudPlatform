@extends('front.default.layout.base')

@section('css')
    <style>
      .weui-panel__bd{
        background-color: #fff;
      }
    </style>
@endsection

@section('content')
  <div class="nav_tip">
    <div class="img">
      <a href="/usercenter"><i class="icon ion-ios-arrow-left"></i></a></div>
    <p class="titile">收货地址</p>
  </div>
  @foreach($addresses as $address)
  <div>
    <a class="weui-panel__bd" href="/address/edit/{{$address->id}}">
      <div class="weui-media-box weui-media-box_text">
        <h4 class="weui-media-box__title">{{ $address->name }} {{ $address->phone }}</h4>
        <p class="weui-media-box__desc">{{ getCitiesNameById($address->province) }}{{ getCitiesNameById($address->city) }}{{ getCitiesNameById($address->district) }}{{ $address->detail }}</p>
      </div>
    </a>
      <div class="weui-cell addressAmend" data-id="{{ $address->id }}">
        <div class="weui-cell__bd address_items"  data-id="{{ $address->id }}" data-default="{{ $address->default=='true'?'true':'false' }}"><i class="{{ $address->default=='true'?'weui-icon-success':'weui-icon-circle' }}"></i>默认收货地址</div>
        <div class="weui-cell__ft">
          <a href="/address/edit/{{ $address->id }}">
            <img src="{{ asset('images/redact.png') }}" alt="">
            编辑
          </a>
          <a href="javascript:;" onclick="confirm_delete(this,{{ $address->id }})">
            <img src="{{ asset('images/dustbin.png') }}" alt="">
            删除
          </a>
        </div>
      </div>
    </div>
  @endforeach
  
  @if ($addresses->count() < 10)
    <div class="page weui-btn-bottom">
      <div class="page__bd page__bd_spacing">
        <a href="/address/add" class="weui-btn weui-btn_primary">+ 添加收货地址</a>
      </div>
    </div>
  @endif
  


{{--   @include('front.default.layout.nav', ['tabIndex' => 4]) --}}
@endsection


@section('js')
    <script>
      $('.address_items').click(function(){
        var id=$(this).data('id');
        var _self = $(this);
        var default_status=false

        if ($(this).attr('data-default') == 'false') {
          default_status = true;
        }

        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
            url:"/address/default/"+id+"/"+ default_status,
            type:"GET",
            success: function(data) {
                if (data.code==0) {
                  if (!default_status) {
                    //有默认改为不默认
                    _self.attr('data-default', false);
                    _self.find('i').attr('class', 'weui-icon-circle');
                  } else {
                    //不默认改为默认
                    //取消原来的默认
                    $('.address_items').attr('data-default', false);
                    $('.address_items').find('i').attr('class', 'weui-icon-circle');
                    //添加现在的
                    _self.attr('data-default', true);
                    _self.find('i').attr('class', 'weui-icon-success');
                  }
                }
            }
        });
      });
      



      function setDefault(id, default_status){
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
            url:"/address/default/"+id+"/"+default_status,
            type:"GET",
            data:'',
            success: function(data) {
                 if (data.code==0) {
                  console.log('success');
                }
            },
         
        });
      }


      function confirm_delete(obj,id) {
        layer.open({
          content: '确认删除吗？该操作不可恢复！'
          ,btn: ['删除', '取消']
          ,yes: function(index){
            deleteAddress(obj,id);
            layer.close(index);
          }
        });
      }

      function deleteAddress(obj,id) {
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
            url:"/address/delete/"+id,
            type:"GET",
            data:'',
            success: function(data) {
                if (data.code==0) {
                  //alert(data.message);
                  $(obj).parent().parent().parent().remove();
                  layer.open({
                    content: data.message
                    ,skin: 'msg'
                    ,time: 2 //2秒后自动关闭
                  });
                }else{
                  window.location.href = '/address';
                }
            },
            error: function(data) {
                //提示失败消息

            },
        });
      }
      /*
      $("input[type=checkbox]").on('change', function() {
        if ($(this).prop('checked')) {
          $("input[type=checkbox]").prop("checked",false);
          $(this).prop("checked",true);
          setDefault($(this).attr('id_attr'), 'true');
        }else{
          //取消默认
          setDefault($(this).attr('id_attr'), 'false');
        }
      });
      */
    </script>
@endsection

