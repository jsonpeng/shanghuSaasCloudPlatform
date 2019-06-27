@extends('front.default.layout.base')

@section('css')
    <style>
        .weui-grid{width: 20%; padding: 20px 5px; background: #f4f2f3;}
        .weui-grid__label{font-size:14px;}
        .weui-grid__label.label2{font-size:14px;}
        .weui-cell__bd{font-size:18px;}
    </style>
@endsection

@section('content')
    
    <div class="weui-grids index-function-grids">
        <a href="/flash_sale?time_begin={{$time01}}" class="weui-grid @if($time_begin == $time01) active-flashsale @endif">
            <p class="weui-grid__label">{{$time01->format('m-d')}}</p>
            <p class="weui-grid__label label2">秒杀中</p>
        </a>
        <a href="/flash_sale?time_begin={{$time02}}" class="weui-grid @if($time_begin == $time02) active-flashsale @endif">
            <p class="weui-grid__label">{{$time02->format('m-d')}}</p>
            <p class="weui-grid__label label2">即将开场</p>
        </a>
        <a href="/flash_sale?time_begin={{$time03}}" class="weui-grid @if($time_begin == $time03) active-flashsale @endif">
            <p class="weui-grid__label">{{$time03->format('m-d')}}</p>
            <p class="weui-grid__label label2">即将开场</p>
        </a>
        <a href="/flash_sale?time_begin={{$time04}}" class="weui-grid @if($time_begin == $time04) active-flashsale @endif">
            <p class="weui-grid__label">{{$time04->format('m-d')}}</p>
            <p class="weui-grid__label label2">即将开场</p>
        </a>
        <a href="/flash_sale?time_begin={{$time05}}" class="weui-grid @if($time_begin == $time05) active-flashsale @endif">
            <p class="weui-grid__label">{{$time05->format('m-d')}}</p>
            <p class="weui-grid__label label2">即将开场</p>
        </a>
    </div>

    <div class="product-wrapper">
 
        @foreach ($sales as $sale)

            <div class="weui-cells" style="width: 100%;"  data-endtime="{!! $sale->time_end !!}">
                <div class="weui-cell">
                    <div class="weui-cell__bd">
                        <img src="{{asset('images/default/index/miaosha.png') }}" style="vertical-align: middle; margin-right: 10px;width:20px;height: 20px;"><span style="vertical-align: middle; font-weight: bold;">限时秒杀</span> 
                    </div>
                    @if($time_begin == $time01) 
                        <div class="weui-cell__ft" id="count_timer" style="color: #333;">距离本场结束: <span> <i class="time time-hour">01</i>:<i class="time time-minute">15</i>:<i class="time time-second">25</i> </span></div>
                    @else 
                        <div class="weui-cell__ft" id="count_timer" style="color: #333;">活动还未开始</div>
                    @endif
                </div>
            </div>
            <a class="flash-sale-item" href="/product/{{$sale->product->id}}">
                <img class="product-img" src="{{$sale->product->image}}">
                <div class="product-name">{{$sale->product_name}}</div>
                <div style="position: relative;">
                    <div class="price">¥{{$sale->price}}  <span>¥{{$sale->product->price}}</span></div>
                    <div class="product-sales">还剩: {{$sale->product_num - $sale->buy_num}}件</div>
                    <div class="go">去抢购</div>
                </div>
                
            </a>
        @endforeach
    </div>
    
    @include(frontView('layout.nav'), ['tabIndex' => 2])
@endsection


@section('js')

<script type="text/javascript">
 $(function(){
    //如果存在活动
    if($('.weui-cells').length>0){
        //就开始遍历节点
        $('.weui-cells').each(function(){
             var end_time=$(this).data('endtime');
             //然后开始找子节点 传参
             startShowCountDown(end_time,$(this).find('#count_timer'),'flashsale');
        });
    } 
 });
</script>

@endsection
