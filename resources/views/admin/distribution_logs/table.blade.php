<table class="table table-responsive" id="distributionLogs-table">
    <thead>
        <tr>
            <th>订单用户</th>
            <th>分佣用户</th>
            <th>订单编号</th>
            <th>分佣金额</th>
            <th>订单金额</th>
            <th>用户推荐层级</th>
            <th>状态</th>
        </tr>
    </thead>
    <tbody>
    @foreach($distributionLogs as $distributionLog)
        <tr>
            <td>{!! user($distributionLog->order_user_id)->nickname  !!}</td>
            <td>{!! user($distributionLog->user_id)->nickname !!}</td>
            <td>{!! $distributionLog->order_id !!}</td>
            <td>{!! $distributionLog->commission !!}</td>
            <td>{!! $distributionLog->order_money !!}</td>
            <td>{!! $distributionLog->user_dis_level !!}</td>
            <td>{!! $distributionLog->status !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>