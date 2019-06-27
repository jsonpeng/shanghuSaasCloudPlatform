<table class="table table-responsive" id="flashSales-table">
    <thead>
        <tr>
            <th>活动产品</th>
            <th class="hidden-xs">价格</th>
            <th class="hidden-xs">原价</th>
            <th class="hidden-xs">参与数量</th>
            <th class="hidden-sm hidden-xs">限购数量</th>
            <th class="hidden-sm hidden-xs">已购数量</th>
            <th class="hidden-sm hidden-xs">订单数量</th>
            <th class="hidden-sm hidden-xs">开始时间</th>
            <th class="hidden-sm hidden-xs">结束时间</th>
            <th class="hidden-xs">是否结束</th>
            <th colspan="3" class="hidden-xs">操作</th>
            <th class="visible-xs">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($flashSales as $flashSale)
        <tr>
            <td>{!! $flashSale->product_name !!}</td>
            <td class="hidden-xs">{!! $flashSale->price !!}</td>
            <td class="hidden-xs">{!! $flashSale->origin_price !!}</td>
            <td class="hidden-xs">{!! $flashSale->product_num !!}</td>
            <td class="hidden-sm hidden-xs">{!! $flashSale->buy_limit !!}</td>
            <td class="hidden-sm hidden-xs">{!! $flashSale->buy_num !!}</td>
            <td class="hidden-sm hidden-xs">{!! $flashSale->order_num !!}</td>
            <td class="hidden-sm hidden-xs">{!! $flashSale->time_begin !!}</td>
            <td class="hidden-sm hidden-xs">{!! $flashSale->time_end !!}</td>
            <td class="hidden-xs">{!! $flashSale->is_end !!}</td>
            <td>
                {!! Form::open(['route' => ['flashSales.destroy', $flashSale->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                {{--     <a href="{!! route('flashSales.show', [$flashSale->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('flashSales.edit', [$flashSale->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>