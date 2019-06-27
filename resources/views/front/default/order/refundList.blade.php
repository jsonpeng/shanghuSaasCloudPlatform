@extends('front.default.layout.base')

@section('css')
    <style>
        .nav_tip{border-bottom: 1px solid #e0e0e0;}
        .order-item .total{text-align: left;color:#ff4e44;}

    </style>
@endsection

@section('content')
  <div class="nav_tip">
    <div class="img">
      <a href="javascript:history.back(-1)"><i class="icon ion-ios-arrow-left"></i></a></div>
    <p class="titile">售后服务</p>
    <div class="userSet">
        <a href="javascript:;">
              {{-- <img src="{{ asset('images/set.png') }}" alt=""> --}}
        </a>
    </div>
  </div>
  @foreach($orderRefunds as $orderRefund)
    <a class="order-item" href="/refundStatus/{{$orderRefund->id}}">
      <div class="order-item-title">
        <span class="title">申请时间 {{$orderRefund->created_at}}</span> <span class="status">{{ $orderRefund->refundStatus }}</span>
      </div>

        <div class="zcjy-product-check">
          <img src="{{ $orderRefund->item->pic }}" class="productImage" onerror="this.src= '/images/default.jpg' ">
          <div class="product-name">{{ $orderRefund->item->name }}</div>
          <div class="remark">{{ $orderRefund->item->unit}}</div>
          <div class="price"> <span style="float: left;">¥{{$orderRefund->item->price}}</span> <span style="float: right; margin-right: 0.75rem;">x{{ $orderRefund->count }}</span></div>
        </div>

      <div class="total refund-status">退货退款，<span>等待买家确认收货{{$orderRefund->price * $orderRefund->count}}</span></div>
      <div class="weui-cell refund-order-status">
        <div class="weui-cell__bd"></div>
        <div class="weui-cell__ft">查看详情</div>
      </div>
    </a>

  @endforeach
@endsection


