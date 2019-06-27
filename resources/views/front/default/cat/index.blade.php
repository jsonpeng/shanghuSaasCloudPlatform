@extends('front.default.layout.base')

@section('css')
    <style>
      .app-wrapper{position: relative;height: 100%;}
    </style>
@endsection

@section('content')

  <div class="cat-left">
    <div>
    @foreach($categories as $category)
      <a class="cat-row scroll-nav">{{ $category->name}}</a>
    @endforeach
    </div>
  </div>
  <div class="cat-right" id="scroll02">
    @foreach($categories as $category)
    <div class="scroll-floor">
      <div class="weui-cells">
        <a class="weui-cell weui-cell_access" href="/category/level1/{{$category->id}}">
            <div class="weui-cell__bd">
                <span style="vertical-align: middle;">{{$category->name}}</span>
            </div>
            <div class="weui-cell__ft">更多</div>
        </a>
      </div>
      <div class="list-item">
        @foreach ($category['children'] as $element)
          <a class="category-list-item" href="/category/level2/{{$element->id}}">
            <div class="img">
                <img class="lazy" data-original="{{ $element->image }}">
            </div>
            <div class="name">{{$element->name}}</div>
          </a>
        @endforeach
      </div>
    </div>
    @endforeach
  </div>
  
  @include(frontView('layout.nav'), ['tabIndex' => 2])
@endsection


@section('js')
  <!-- 商品分类页面的楼层显示效果 -->
  <script src="{{ asset('vendor/jquery.scroll.floor.js') }}"></script>
  <script type="text/javascript">
      scrollFloor({
        floorClass : '.scroll-floor',       //楼层盒子class;默认为'.scroll-floor'
        navClass : '.scroll-nav',           //导航盒子class;默认为'.scroll-nav'
        activeClass : 'active',             //导航高亮class;默认为'active'
        delayTime:300,                      //点击导航，滚动条滑动到该位置的时间间隔;默认为200
        activeTop:10,                      //楼层到窗口的某个位置时，导航高亮（设置该位置）;默认为100
        scrollTop:0                         //点击导航，楼层滑动到窗口的某位置;默认为100
      });
      
      //点击高亮
      $('.scroll-nav').click(function(){
          $('.scroll-nav').removeClass('active');
          $(this).addClass('active');
      });

      
  </script>
@endsection