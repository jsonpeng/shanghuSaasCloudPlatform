@extends('front.default.layout.base')

@section('css')
    <style>
        .weui-grid{width: 25%;}
    </style>
@endsection

@section('content')
    <div class="nav_tip">
      <div class="img">
        <a href="javascript:history.back(-1)"><i class="icon ion-ios-arrow-left"></i></a></div>
      <p class="titile">合伙人</p>
    </div>
    <div id="scroll-container">
        @foreach ($fellows as $fellow)
            <div class="weui-cell partner scroll-post">
                <div class="weui-cell__hd partner-img">
                    <img src="{{ $fellow->head_image }}" alt="">
                </div>
                <div class="weui-cell__bd partner-name">{{ $fellow->nickname }}</div>
                <div class="weui-cell__ft join-time">加入时间：{{ $fellow->created_at->format('Y-m-d') }}</div>
            </div>
        @endforeach
    </div>
@endsection


@section('js')

    <script src="{{ asset('vendor/doT.min.js') }}"></script>

    <script type="text/template" id="template">
        @{{~it:value:index}}
            <div class="weui-cell partner scroll-post">
                <div class="weui-cell__hd partner-img">
                    <img src="@{{=value.head_image }}" alt="">
                </div>
                <div class="weui-cell__bd partner-name">@{{=value.nickname }}</div>
                <div class="weui-cell__ft join-time">加入时间：@{{=value.created_at.subString(0, 10)}} </div>
            </div>
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
                    url:"/ajax/fellow?skip=" + $('.scroll-post').length + "&take=18",
                    type:"GET",
                    success:function(data){
                      if (data.code != 0) {
                        return;
                      }

                      var coupons=data.message;

                      if (coupons.length == 0) {
                        fireEvent = false;
                        $('#scroll-container').append("<div id='loading-tips' style='padding: 15px; color: #999; font-size: 14px; text-align: center;'>别再扯了，已经没有了</div>");
                        return;
                      }
                      if (data.message.length) {
                      // 编译模板函数
                      var tempFn = doT.template( $('#template').html() );

                      // 使用模板函数生成HTML文本
                      var resultHTML = tempFn(data.message);

                      // 否则，直接替换list中的内容
                      $('#scroll-container').append(resultHTML);
                    } else {
                      
                    }
                    working = false;
                    }
                  });
                }
            });
        });
    </script>

@endsection