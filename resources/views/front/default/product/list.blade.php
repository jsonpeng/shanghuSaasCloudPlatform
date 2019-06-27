@extends('front.default.layout.base')

@section('css')
    <style>
      
    </style>
@endsection

@section('content')
  <div class="nav_tip" style="position: fixed; left: 0; right: 0; top: 0; height: 44px; z-index: 2;">
    <div class="img">
      <a href="javascript:history.back(-1)"><i class="icon ion-ios-arrow-left"></i></div></a>
    <p class="titile">商品</p>
  </div>
  <div class="product-wrapper scroll-container" style="margin-top: 45px;">
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

  <div id="shopinfo" style="display: none;">
      @include('front.'.theme()['name'].'.layout.shopinfo')
  </div>

@endsection

@section('js')
  <script src="{{ asset('vendor/doT.min.js') }}"></script>

  <script type="text/template" id="template">
    @{{~it:value:index}}
      <a class="product-item2 scroll-post" href="/product/@{{=value.id}}">
          <div class="img">
              <img class="lazy" data-original="@{{=value.image}}">
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
            url:"/ajax/products_of_type/{{ $type }}?skip=" + $('.scroll-post').length + "&take=18&country_id={{ $country_id }}",
            type:"GET",
            success:function(data){
              working = false;
              var all_product=data.data;
              if (all_product.length == 0) {
                  fireEvent = false;
                  $('#shopinfo').show();
                  return;
              }

              // 编译模板函数
              var tempFn = doT.template( $('#template').html() );

              // 使用模板函数生成HTML文本
              var resultHTML = tempFn(all_product);

              // 否则，直接替换list中的内容
              $('.scroll-container').append(resultHTML);

              $("img.lazy").lazyload({effect: "fadeIn"});

            }

          });
        }
      });
    });
  </script>
  
@endsection