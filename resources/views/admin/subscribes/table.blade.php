<table class="table table-responsive" id="subscribes-table">
    <thead>
        <tr>
        <th>预约人</th>
        <th>手机号</th>
        <th>到店时间</th>
        <th>预约门店</th>
        <th>预约服务</th>
        <th>预约技师</th>
        <th>状态</th>
            <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($subscribes as $subscribe)
        <tr>
            <td>{!! $subscribe->subman !!}</td>
            <td>{!! $subscribe->mobile !!}</td>
            <td>{!! $subscribe->arrive_time !!}</td>
            <td>{!! optional($subscribe->shop()->first())->name !!}</td>
            <td>{!! optional($subscribe->service()->first())->name !!}</td>
            <td>{!! optional($subscribe->technician()->first())->name !!}</td>
            <td>{!! $subscribe->status !!}</td>
            <td>
                {!! Form::open(['route' => ['subscribes.destroy', $subscribe->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                  {{--   <a href="{!! route('subscribes.show', [$subscribe->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('subscribes.edit', [$subscribe->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>