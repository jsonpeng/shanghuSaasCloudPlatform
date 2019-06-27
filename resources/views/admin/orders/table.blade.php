<table class="table table-responsive" id="orders-table">
    <thead>
        <th>订单编号</th>
        <th class="hidden-sm hidden-xs">订单金额</th>
        <th>订单状态</th>
        <th>物流状态</th>
        <th>支付状态</th>
        <th class="hidden-sm hidden-xs">支付渠道</th>
        <th class="hidden-sm hidden-xs">支付单号</th>
        <th class="hidden-xs">联系人</th>
        <th class="hidden-sm hidden-xs">下单时间</th>
        <th colspan="3">操作</th>
    </thead>
    <tbody>
    @foreach($orders as $order)
        <tr>
            <td>{!! $order->snumber !!}</td>
            <td class="hidden-sm hidden-xs">{!! $order->price !!}</td>
             <td>{!! $order->order_status !!}</td>
            <td>
                @if($order->order_delivery == '已发货') <span class="label label-info">已发货</span> @endif
                @if($order->order_delivery == '已收货') <span class="label label-success">已收货</span> @endif
                @if($order->order_delivery == '未发货') <span class="label label-warning">未发货</span> @endif
            </td>
            <td>@if($order->order_pay == '已支付') <span class="label label-success">已支付</span> @else <span class="label label-warning">未支付</span>  @endif</td>
            <td class="hidden-sm hidden-xs">@if($order->order_pay == '已支付'){!! $order->pay_platform !!}@endif</td>
            <td class="hidden-sm hidden-xs">@if($order->order_pay == '已支付'){!! $order->pay_no !!}@endif</td>
            <td class="hidden-xs">{!! $order->customer_name !!} {!! $order->customer_phone !!}</td>
            <td class="hidden-sm hidden-xs">{!! $order->created_at !!}</td>
            <td>
              
                <div class='btn-group'>
                    <a href="{!! route('orders.show', [$order->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open" title="编辑"></i></a>
                    {!! Form::open(['route' => ['orders.destroy', $order->id], 'method' => 'delete' ,'style'=>'display:inline;']) !!}
                   <a onclick="printOrder({{$order->id}})" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-print" title="打印"></i></a>
                    {!! Form::close() !!}
                    {!! Form::open(['route' => ['order.report', $order->id],'style'=>'display:inline;']) !!}
                    <button type="submit" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-download-alt" title="导出"></i></button>
                   {{--   {!! Form::submit('导出', ['class' => 'glyphicon glyphicon-download-alt']) !!} --}}
                    {!! Form::close() !!}
                </div>
              

              
            </td>
        </tr>
    @endforeach
    </tbody>
</table>