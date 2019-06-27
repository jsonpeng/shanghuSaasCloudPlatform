<table class="table table-responsive" id="couponRules-table">
    <thead>
        <th>类型</th>
        <th>赠送条件(消费金额满)</th>
        <th>赠送的购物券</th>
        <th>最大赠送次数</th>
        <th>已赠送次数</th>
        <th>开始时间</th>
        <th>结束时间</th>
        <th colspan="3">操作</th>
    </thead>
    <tbody>
    @foreach($couponRules as $couponRule)
        <tr>
            <td>{!! $couponRule->typeName !!}</td>
            <td>@if ($couponRule->type == 1)
                {!! $couponRule->base !!}
            @endif</td>
            <td>
                @foreach ($couponRule->coupons as $element)
                    {!! $element->name !!}&nbsp;
                @endforeach
            </td>
            <td>@if($couponRule->max_count) {!! $couponRule->max_count !!} @else 不限量 @endif</td>
            <td>{!! $couponRule->count !!}</td>
            <td>{!! $couponRule->time_begin !!}</td>
            <td>{!! $couponRule->time_end !!}</td>
            <td>
                {!! Form::open(['route' => ['couponRules.destroy', $couponRule->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('couponRules.edit', [$couponRule->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确认删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>