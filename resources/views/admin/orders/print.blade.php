@extends('admin.layouts.app_shop')

@section('css')
    <style>
        table{width: 100%;}
        dl{width: 100%;}
        dt{width: 80px; display: inline-block; font-weight: normal; color: #999; vertical-align: top; font-size: 12px;}
        dd{width: 170px; display: inline-block; vertical-align: top;}
        .box-header{padding: 10px 0; font-size: 16px; border-top: 1px solid #ccc;}
        .box-header>.fa, .box-header>.glyphicon, .box-header>.ion, .box-header .box-title{font-size: 16px;}
        tr{height: 25px;}
    </style>
@endsection

@section('content')
    <div style="width: 800px; margin: 0 auto; background-color: #fff; padding: 15px;">
        <div class="box-header with-border">
            <h3 class="box-title">商品信息</h3>
        </div>
        <table>
            <thead>
                <tr>
                    <th>商品名称</th>
                    <th>货品编号</th>
                    <th>规格属性</th>
                    <th>数量</th>
                    <th>单价</th>
                    <th>小计</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->product->sn }}</td>
                    <td>{{ $item->unit }}</td>
                    <td>{{ $item->count }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ round($item->count * $item->price) }}</td>
                </tr>
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->product->sn }}</td>
                    <td>{{ $item->unit }}</td>
                    <td>{{ $item->count }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ round($item->count * $item->price) }}</td>
                </tr>
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->product->sn }}</td>
                    <td>{{ $item->unit }}</td>
                    <td>{{ $item->count }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ round($item->count * $item->price) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="box-header with-border">
            <h3 class="box-title">收件人信息</h3>
        </div>
        <dl>
            <dt>收件人：</dt>
            <dd>{{ $order->customer_name }}</dd>
            <dt>联系电话：</dt>
            <dd>{!! $order->customer_phone !!}</dd>
            <dt>收货地址：</dt>
            <dd>{{ $order->customer_address }}</dd>
        </dl>

        <div class="box-header with-border">
            <h3 class="box-title">订单详情</h3>
        </div>
        <dl>
            <dt>订单编号：</dt>
            <dd>{!! $order->snumber !!}</dd>
            <dt>订单状态：</dt>
            <dd>{!! $order->order_status !!}</dd>
            <dt>支付类型：</dt>
            <dd>{!! $order->pay_type !!}</dd>
        </dl>
        <dl>
            <dt>支付渠道：</dt>
            <dd>{!! $order->pay_platform !!}</dd>
            <dt>支付状态：</dt>
            <dd>{!! $order->order_pay !!}</dd>
            <dt>下单时间：</dt>
            <dd>{!! $order->created_at !!}</dd>
        </dl>
        <dl>
            <dt>应付费用：</dt>
            <dd>{!! $order->price !!}</dd>
            <dt>商品总价：</dt>
            <dd>{!! $order->origin_price !!}</dd>
            <dt>订单优惠：</dt>
            <dd>{!! $order->preferential !!}</dd>
        </dl>
        <dl>
            <dt>余额支付：</dt>
            <dd>{!! $order->user_money_pay !!}</dd>
            <dt>积分抵扣：</dt>
            <dd>{{ $order->credits }}积分抵扣{!! $order->credits_money !!}</dd>
            <dt>优惠券减免：</dt>
            <dd> {!! $order->coupon_money !!}</dd>
        </dl>
        <dl>
            <dt>会员优惠：</dt>
            <dd>{!! $order->user_level_money !!}</dd>
        </dl>

        
        
        @if (!empty($order->remark))
            <div class="box-header with-border">
                <h3 class="box-title">用户留言</h3>
            </div>
            <div>{!! $order->remark !!}</div>
        @endif

        <div class="box-header with-border">
            <h3 class="box-title">管理员备注</h3>
        </div>
        <div>{!! $order->backup01 !!}</div>

        <div>
            <a class="btn btn-primary" href="javascript:window.print();">打印</a>
        </div>
    
    <!--
    <script>var pfHeaderImgUrl = '';var pfHeaderTagline = '';var pfdisableClickToDel = 1;var pfHideImages = 1;var pfImageDisplayStyle = 'block';var pfDisablePDF = 1;var pfDisableEmail = 1;var pfDisablePrint = 0;var pfCustomCSS = 'http://cai.wissofts.com/vendor/print.css';var pfBtVersion='1';(function(){var js,pf;pf=document.createElement('script');pf.type='text/javascript';pf.src='//cdn.printfriendly.com/printfriendly.js';document.getElementsByTagName('head')[0].appendChild(pf)})();</script>
    <div style="text-align: right;">
    <a href="https://www.printfriendly.com" style="color:#6D9F00;text-decoration:none; margin: 15px;" class="printfriendly" onclick="window.print();return false;" title="打印"><img style="border:none;-webkit-box-shadow:none;box-shadow:none; margin-top: 15px;" src="{{ asset('images/print.png') }}" alt="打印"/></a>
    </div>
    
-->
    </div>
    
@endsection