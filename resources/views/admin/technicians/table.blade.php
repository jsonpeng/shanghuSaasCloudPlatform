<table class="table table-responsive" id="technicians-table">
    <thead>
        <tr>
        <th>技师名称</th>
        <th>技师图片</th>
        <th>工作日</th>
        <th>提供服务</th>
        <th colspan="3">操作</th>
        </tr>
    </thead>
    <tbody>
    @foreach($technicians as $technician)
        <tr>
            <td>{!! $technician->name !!}</td>
            <td>{!! $technician->image !!}</td>
            <td>{!! $technician->WorkDays !!}</td>
            <td>{!! $technician->Services !!}</td>
            <td>
                {!! Form::open(['route' => ['technicians.destroy', $technician->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                  {{--   <a href="{!! route('technicians.show', [$technician->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a> --}}
                    <a href="{!! route('technicians.edit', [$technician->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('确定删除吗?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>