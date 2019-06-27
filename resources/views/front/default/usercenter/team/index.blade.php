@extends('front.default.layout.base')
@section('css')
<style></style>
@endsection
@section('content')
    <div class="nav_tip">
        <div class="img">
            <a href="javascript:history.back(-1)"><i class="icon ion-ios-arrow-left"></i></a></div>
        <p class="titile">拼团记录</p>
     </div>
    @foreach ($orders as $order)
        <?php
            $teamFound = $order->teamFound;
            $teamFollow = $order->teamFollow()->take(3)->get();
        ?>
        <a class="order-item" href="/order/{{ $order->id }}" data-endtime="{{ $teamFound->time_end }}">
            <div class="order-item-title">
                <span class="title">购买时间 {{ $order->created_at }}</span>
                <span class="status">
                    @if($teamFound->status == 0) 待开团 @endif
                    @if($teamFound->status == 1) 拼单中 @endif
                    @if($teamFound->status == 2) 拼团成功 @endif
                    @if($teamFound->status == 3) 拼团失败 @endif
                </span>
            </div>
            <div class="userlist">
                <img src="{{ $teamFound->head_pic }}" onerror="this.src= 'http://f11.baidu.com/it/u=2004983812,2970146020&fm=76' ">
                @foreach ($teamFollow as $element)
                <img src="{{ $element->head_pic }}" onerror="this.src= 'http://f11.baidu.com/it/u=2004983812,2970146020&fm=76' ">
                @endforeach

                @if($teamFound->status == 1)
                <div style="float: left; height:30px; line-height: 30px; font-size: 14px; margin-left: 10px;">
                    <span>待分享</span>, 还差{{ $teamFound->need_mem - $teamFound->join_num }}<span></span>人,<span class="teamsale_timer">剩余</span>
                </div>
                @endif
                
            </div>
            @foreach($order->items as $item)
            <div class="zcjy-product-check">
                <img src="{{ $item->pic }}" class="productImage" onerror="this.src= 'http://f11.baidu.com/it/u=2004983812,2970146020&fm=76' ">
                <div class="product-name">{{ $item->name }}</div>
                <div class="remark">{{ $item->unit }}</div>
                <div class="price">
                    <span style="float: left;">¥{{ $item->price }}</span>
                    <span style="float: right; margin-right: 0.75rem;">x{{ $item->count }}</span>
                </div>
            </div>
            @endforeach
            <div class="total">
                共{{ $order->count }}件商品，合计<span>￥{{ $order->price }}</span>
            </div>
        </a>
    @endforeach
    @include(frontView('layout.nav'), ['tabIndex' => 2])
@endsection

@section('js')
<script type="text/javascript">
    $(function(){
        $('.order-item').each(function(){
            var end_time=$(this).data('endtime');
            startShowCountDown(end_time,$(this).find('.teamsale_timer'),'teamsale');
        });
    });
</script>

@endsection