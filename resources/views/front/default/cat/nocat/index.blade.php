@extends('front.default.layout.base')

@section('css')
    <style>
      ul li{
        display: inline-block; height: 40px; line-height: 40px; padding: 0 10px;
      }
    </style>
@endsection

@section('content')
    <div class="product-wrapper" id="scroll-container">
      @foreach ($products as $element)
        <a class="product-item2 scroll-post" href="/product/{{$element->id}}">
            <div class="img">
                <img class="lazy" data-original="{{ $element->image }}">
            </div>
            <div class="title">{{$element->name}}</div>
            <div class="price">¥{{$element->price}} <span class="buynum">{{ $element->sales_count }}人购买</span></div>
        </a>
      @endforeach
    </div>

    <div style="display: none;" id="shopinfo">
        @include('front.'.theme()['name'].'.layout.shopinfo')
    </div>

    @include(frontView('layout.nav'), ['tabIndex' => 2])
@endsection


@section('js')

    <script src="{{ asset('vendor/doT.min.js') }}"></script>

    <script type="text/template" id="template">
        @{{~it:value:index}}
            <a class="product-item2 scroll-post" href="/product/@{{=value.id}}">
              <div class="img">
                  <img src="@{{=value.image }}">
              </div>
              <div class="title">@{{=value.name}}</div>
              <div class="price">¥@{{=value.price}} <span class="buynum">@{{=value.sales_count}}人购买</span></div>
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
                      if (data.status_code != 0) {
                        return;
                      }

                      if (data.data.length == 0) {
                        fireEvent = false;
                        $('#shopinfo').show();
                        return;
                      }
                      if (data.data.length) {
                      // 编译模板函数
                      var tempFn = doT.template( $('#template').html() );

                      // 使用模板函数生成HTML文本
                      var resultHTML = tempFn(data.data);

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