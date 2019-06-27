<table class="table table-responsive" id="discountOrders-table">
    <thead>
        <tr>
        <th>实际支付金额</th>
        <th>使用用户</th>
        <th>原价</th>
        <th>不参与优惠价格</th>
        <th>使用余额</th>
        <th>会员等级优惠金额</th>
        <th>使用优惠券</th>
        <th>优惠券减免金额</th>
        <th>买单时间</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($discountOrders as $discountOrder)
        <tr>
            <td>{!! $discountOrder->price !!}</td>
            <td>{!! $discountOrder->user_id !!}</td>
            <td>{!! $discountOrder->orgin_price !!}</td>
            <td>{!! $discountOrder->no_discount_price !!}</td>
            <td>{!! $discountOrder->use_user_money !!}</td>
            <td>{!! $discountOrder->user_level_money !!}</td>
            <td>{!! $discountOrder->coupon_id !!}</td>
            <td>{!! $discountOrder->coupon_price !!}</td>
            <td>{!! $discountOrder->created_at !!}</td>
            <td>
                {!! Form::open(['route' => ['discountOrders.destroy', $discountOrder->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
            {{--         <a href="{!! route('discountOrders.show', [$discountOrder->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('discountOrders.edit', [$discountOrder->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a> --}}
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>