<table class="table table-responsive" id="orders-table">
    <thead>
        <th>订单编号</th>
        <th>订单金额</th>
        <th>订单状态</th>
        <th>物流状态</th>
        <th>支付类型</th>
        <th>支付状态</th>
        <th>配送时间</th>
        <th>配送地址</th>
        <th>联系人</th>
        <th>联系方式</th>
        <th>备注</th>
        <th>下单时间</th>
    </thead>
    <tbody>
        <tr>
            <td>{!! $order->snumber !!}</td>
            <td>{!! $order->price !!}</td>
            <td>{!! $order->order_status !!}</td>
            <td>{!! $order->order_delivery !!}</td>
            <td>{!! $order->pay_type !!}</td>
            <td>{!! $order->order_pay !!}</td>
            <td>{!! $order->sendtime !!}</td>
            <td>{!! $order->canteen->address !!}</td>
            <td>{!! $order->canteen->fuzeren !!}</td>
            <td>{!! $order->canteen->contact !!}</td>
            <td>{!! $order->remark !!}</td>
            <td>{!! $order->created_at !!}</td>
        </tr>
    </tbody>
</table>