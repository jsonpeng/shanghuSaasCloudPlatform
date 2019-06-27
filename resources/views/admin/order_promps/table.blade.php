<table class="table table-responsive" id="orderPromps-table">
    <thead>
        <tr>
            <th>活动名称</th>
            <th>类型</th>
            <th>状态</th>
            <th>满足金额</th>
            <th>优惠/折扣</th>
            <th class="hidden-sm hidden-xs">活动开始</th>
            <th class="hidden-sm hidden-xs">活动结束</th>
            
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($orderPromps as $orderPromp)
        <tr>
            <td>{!! $orderPromp->name !!}</td>
            <td>{!! $orderPromp->type !!}</td>
            <td>{!! $orderPromp->status !!}</td>
            <td>{!! $orderPromp->base !!}</td>
            <td>{!! $orderPromp->value !!}</td>
            <td class="hidden-sm hidden-xs">{!! $orderPromp->time_begin !!}</td>
            <td class="hidden-sm hidden-xs">{!! $orderPromp->time_end !!}</td>
            
            <td>
                {!! Form::open(['route' => ['orderPromps.destroy', $orderPromp->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('orderPromps.edit', [$orderPromp->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>