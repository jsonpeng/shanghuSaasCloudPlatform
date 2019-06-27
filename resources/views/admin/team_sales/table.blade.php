<table class="table table-responsive" id="teamSales-table">
    <thead>
        <tr>
            <th>活动名称</th>
            <th class="hidden-xs">类型</th>
            <th class="hidden-xs">过期小时</th>
            <th class="hidden-xs hidden-sm">价格</th>
            <th class="hidden-xs">成团人数</th>
            <th>产品名称</th>
            <th class="hidden-xs hidden-sm">限购数量</th>
            <th class="hidden-xs hidden-sm">销售数量</th>
            <th class="hidden-xs hidden-sm">排序</th>
            <th colspan="3" class="hidden-xs">操作</th>
            <th class="visible-xs">操作</th>
        </tr>
    </thead>
    <tbody>
        @foreach($teamSales as $teamSale)
        <tr>
            <td>{!! $teamSale->name !!}</td>
            <td class="hidden-xs">{!! $teamSale->saleType !!}</td>
            <td class="hidden-xs">{!! $teamSale->expire_hour !!}</td>
            <td class="hidden-xs hidden-sm">{!! $teamSale->price !!}</td>
            <td class="hidden-xs">{!! $teamSale->member !!}</td>
            <td>{!! $teamSale->product_name !!}</td>
            <td class="hidden-xs hidden-sm">{!! $teamSale->buy_limit !!}</td>
            <td class="hidden-xs hidden-sm">{!! $teamSale->sales_sum !!}</td>
            <td class="hidden-xs hidden-sm">{!! $teamSale->sort !!}</td>
            <td>
                {!! Form::open(['route' => ['teamSales.destroy', $teamSale->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    {{-- <a href="{!! route('teamSales.show', [$teamSale->
                        id]) !!}" class='btn btn-default btn-xs'> <i class="glyphicon glyphicon-eye-open"></i>
                    </a> --}}
                    <a href="{!! route('teamSales.edit', [$teamSale->
                        id]) !!}" class='btn btn-default btn-xs'> <i class="glyphicon glyphicon-edit"></i>
                    </a>
                    {!! Form::button('
                    <i class="glyphicon glyphicon-trash"></i>
                    ', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>